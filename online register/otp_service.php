<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__) . '/connection.php';

function otp_config(): array
{
    static $config = null;

    if ($config === null) {
        $config = require __DIR__ . '/otp_config.php';
    }

    return $config;
}

function otp_db(): mysqli
{
    global $conn;

    return $conn;
}

function otp_json_response(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

function otp_read_input(): array
{
    $raw = file_get_contents('php://input');
    if ($raw !== false && trim($raw) !== '') {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded;
        }
    }

    return $_POST;
}

function otp_normalize_phone_number(string $value): string
{
    $sanitized = preg_replace('/[^\d+]/', '', trim($value));
    if ($sanitized === null) {
        return '';
    }

    $sanitized = preg_replace('/(?!^)\+/', '', $sanitized);
    if ($sanitized === null || $sanitized === '') {
        return '';
    }

    if (str_starts_with($sanitized, '+')) {
        return $sanitized;
    }

    if (str_starts_with($sanitized, '00')) {
        return '+' . substr($sanitized, 2);
    }

    if (str_starts_with($sanitized, '251')) {
        return '+' . $sanitized;
    }

    if (str_starts_with($sanitized, '0')) {
        return '+251' . substr($sanitized, 1);
    }

    if (preg_match('/^9\d{8}$/', $sanitized) === 1) {
        return '+251' . $sanitized;
    }

    return $sanitized;
}

function otp_is_valid_phone_number(string $phoneNumber): bool
{
    return preg_match('/^\+\d{9,15}$/', $phoneNumber) === 1;
}

function otp_purpose(): string
{
    return (string) (otp_config()['purpose'] ?? 'online_register');
}

function otp_ensure_table(): void
{
    static $tableEnsured = false;

    if ($tableEnsured) {
        return;
    }

    $sql = "
        CREATE TABLE IF NOT EXISTS online_register_otp (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            purpose VARCHAR(50) NOT NULL,
            session_id VARCHAR(128) NOT NULL,
            phone_number VARCHAR(20) NOT NULL,
            otp_hash VARCHAR(255) NOT NULL,
            attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
            expires_at DATETIME NOT NULL,
            last_sent_at DATETIME NOT NULL,
            verified_at DATETIME DEFAULT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            KEY idx_otp_phone (phone_number, purpose, session_id),
            KEY idx_otp_created (created_at)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ";

    otp_db()->query($sql);
    $tableEnsured = true;
}

function otp_cleanup_old_rows(): void
{
    otp_db()->query("DELETE FROM online_register_otp WHERE created_at < (NOW() - INTERVAL 7 DAY)");
}

function otp_generate_code(int $length): string
{
    $digits = '';
    for ($index = 0; $index < $length; $index++) {
        $digits .= (string) random_int(0, 9);
    }

    return $digits;
}

function otp_fetch_latest_request(string $phoneNumber, string $purpose, string $sessionId): ?array
{
    $statement = otp_db()->prepare(
        'SELECT id, otp_hash, attempts, expires_at, last_sent_at, verified_at
         FROM online_register_otp
         WHERE phone_number = ? AND purpose = ? AND session_id = ?
         ORDER BY id DESC
         LIMIT 1'
    );
    if (!$statement) {
        return null;
    }
    $statement->bind_param('sss', $phoneNumber, $purpose, $sessionId);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result ? $result->fetch_assoc() : null;
    $statement->close();

    return $row ?: null;
}

function otp_build_sms_message(string $otpCode): string
{
    $expirySeconds = (int) (otp_config()['otp_expiry_seconds'] ?? 300);
    $expiryMinutes = max(1, (int) ceil($expirySeconds / 60));

    return sprintf(
        'Your Distance Education verification code is %s. It expires in %d minute%s.',
        $otpCode,
        $expiryMinutes,
        $expiryMinutes === 1 ? '' : 's'
    );
}

function otp_send_sms(string $phoneNumber, string $otpCode): array
{
    $config = otp_config()['sms'] ?? [];
    $driver = (string) ($config['driver'] ?? 'log');
    $message = otp_build_sms_message($otpCode);

    if ($driver === 'log') {
        $logFile = (string) ($config['log_file'] ?? (__DIR__ . '/otp_debug.log'));
        $logLine = sprintf("[%s] %s %s\n", date('Y-m-d H:i:s'), $phoneNumber, $message);
        file_put_contents($logFile, $logLine, FILE_APPEND);

        return [
            'success' => true,
            'transport' => 'log',
            'debugOtp' => !empty($config['debug_return_otp']) ? $otpCode : null,
            'message' => 'OTP generated successfully in local log mode.'
        ];
    }

    if ($driver === 'twilio') {
        if (!function_exists('curl_init')) {
            return [
                'success' => false,
                'message' => 'cURL is required for Twilio SMS sending.'
            ];
        }

        $twilioConfig = is_array($config['twilio'] ?? null) ? $config['twilio'] : [];
        $accountSid = trim((string) ($twilioConfig['account_sid'] ?? ''));
        $authToken = trim((string) ($twilioConfig['auth_token'] ?? ''));
        $from = trim((string) ($twilioConfig['from'] ?? ''));
        $messagingServiceSid = trim((string) ($twilioConfig['messaging_service_sid'] ?? ''));
        $statusCallback = trim((string) ($twilioConfig['status_callback'] ?? ''));

        if ($accountSid === '' || $authToken === '') {
            return [
                'success' => false,
                'message' => 'Twilio credentials are missing. Set TWILIO_ACCOUNT_SID and TWILIO_AUTH_TOKEN.'
            ];
        }

        if ($from === '' && $messagingServiceSid === '') {
            return [
                'success' => false,
                'message' => 'Twilio sender is missing. Set TWILIO_FROM or TWILIO_MESSAGING_SERVICE_SID.'
            ];
        }

        $apiUrl = 'https://api.twilio.com/2010-04-01/Accounts/' . rawurlencode($accountSid) . '/Messages.json';
        $payload = [
            'To' => $phoneNumber,
            'Body' => $message
        ];

        if ($messagingServiceSid !== '') {
            $payload['MessagingServiceSid'] = $messagingServiceSid;
        } else {
            $payload['From'] = $from;
        }

        if ($statusCallback !== '') {
            $payload['StatusCallback'] = $statusCallback;
        }

        $curl = curl_init($apiUrl);
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => (int) ($config['timeout_seconds'] ?? 15),
            CURLOPT_USERPWD => $accountSid . ':' . $authToken,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC
        ]);

        $responseBody = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($curlError !== '') {
            return [
                'success' => false,
                'message' => 'Twilio request failed: ' . $curlError
            ];
        }

        $decoded = json_decode((string) $responseBody, true);
        if ($httpCode < 200 || $httpCode >= 300) {
            $messageText = 'Twilio rejected the SMS request with HTTP ' . $httpCode . '.';
            if (is_array($decoded) && !empty($decoded['message'])) {
                $messageText = 'Twilio error: ' . $decoded['message'];
            }

            return [
                'success' => false,
                'message' => $messageText,
                'gatewayResponse' => $decoded ?: $responseBody
            ];
        }

        return [
            'success' => true,
            'transport' => 'twilio',
            'message' => 'OTP sent successfully through Twilio.',
            'gatewayResponse' => $decoded ?: null
        ];
    }

    if ($driver !== 'generic_json') {
        return [
            'success' => false,
            'message' => 'SMS gateway is not configured. Update otp_config.php with a supported driver.'
        ];
    }

    if (!function_exists('curl_init')) {
        return [
            'success' => false,
            'message' => 'cURL is required for generic_json SMS sending.'
        ];
    }

    $apiUrl = trim((string) ($config['api_url'] ?? ''));
    if ($apiUrl === '') {
        return [
            'success' => false,
            'message' => 'SMS API URL is missing. Update otp_config.php.'
        ];
    }

    $genericConfig = $config['generic_json'] ?? [];
    $recipientField = (string) ($genericConfig['recipient_field'] ?? 'to');
    $messageField = (string) ($genericConfig['message_field'] ?? 'message');
    $senderField = (string) ($genericConfig['sender_field'] ?? 'from');
    $payload = is_array($genericConfig['extra_payload'] ?? null) ? $genericConfig['extra_payload'] : [];
    $payload[$recipientField] = $phoneNumber;
    $payload[$messageField] = $message;

    $senderId = trim((string) ($config['sender_id'] ?? ''));
    if ($senderId !== '' && $senderField !== '') {
        $payload[$senderField] = $senderId;
    }

    $headers = ['Content-Type: application/json'];
    $apiToken = trim((string) ($config['api_token'] ?? ''));
    if ($apiToken !== '') {
        $prefix = (string) ($genericConfig['authorization_prefix'] ?? 'Bearer ');
        $headers[] = 'Authorization: ' . $prefix . $apiToken;
    }

    $curl = curl_init($apiUrl);
    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => (int) ($config['timeout_seconds'] ?? 15)
    ]);

    $responseBody = curl_exec($curl);
    $curlError = curl_error($curl);
    $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($curlError !== '') {
        return [
            'success' => false,
            'message' => 'SMS gateway request failed: ' . $curlError
        ];
    }

    if ($httpCode < 200 || $httpCode >= 300) {
        return [
            'success' => false,
            'message' => 'SMS gateway rejected the request with HTTP ' . $httpCode . '.',
            'gatewayResponse' => $responseBody
        ];
    }

    return [
        'success' => true,
        'transport' => 'generic_json',
        'message' => 'OTP sent successfully.'
    ];
}

function otp_store_request(string $phoneNumber, string $otpCode): array
{
    otp_ensure_table();
    otp_cleanup_old_rows();

    $config = otp_config();
    $purpose = otp_purpose();
    $sessionId = session_id();
    $cooldownSeconds = (int) ($config['resend_cooldown_seconds'] ?? 60);
    $latest = otp_fetch_latest_request($phoneNumber, $purpose, $sessionId);

    if ($latest !== null && !empty($latest['last_sent_at'])) {
        $secondsSinceLastSend = time() - strtotime((string) $latest['last_sent_at']);
        if ($secondsSinceLastSend < $cooldownSeconds) {
            return [
                'success' => false,
                'status' => 429,
                'message' => 'Wait ' . ($cooldownSeconds - $secondsSinceLastSend) . ' seconds before requesting another OTP.'
            ];
        }
    }

    $createdAt = date('Y-m-d H:i:s');
    $expiresAt = date('Y-m-d H:i:s', time() + (int) ($config['otp_expiry_seconds'] ?? 300));
    $hash = password_hash($otpCode, PASSWORD_DEFAULT);

    $statement = otp_db()->prepare(
        'INSERT INTO online_register_otp (purpose, session_id, phone_number, otp_hash, attempts, expires_at, last_sent_at, verified_at, created_at)
         VALUES (?, ?, ?, ?, 0, ?, ?, NULL, ?)'
    );
    if (!$statement) {
        return [
            'success' => false,
            'status' => 500,
            'message' => 'Database error: unable to prepare insert statement.'
        ];
    }

    $statement->bind_param('sssssss', $purpose, $sessionId, $phoneNumber, $hash, $expiresAt, $createdAt, $createdAt);
    if (!$statement->execute()) {
        $statement->close();
        return [
            'success' => false,
            'status' => 500,
            'message' => 'Database error: unable to insert OTP record.'
        ];
    }

    $insertId = otp_db()->insert_id;
    $statement->close();

    $smsResult = otp_send_sms($phoneNumber, $otpCode);
    if (!$smsResult['success']) {
        $deleteStatement = otp_db()->prepare('DELETE FROM online_register_otp WHERE id = ?');
        $deleteStatement->bind_param('i', $insertId);
        $deleteStatement->execute();
        $deleteStatement->close();

        return [
            'success' => false,
            'status' => 502,
            'message' => (string) ($smsResult['message'] ?? 'Unable to send OTP through the SMS gateway.')
        ];
    }

    $_SESSION['online_register_verified_phone'] = null;

    return [
        'success' => true,
        'status' => 200,
        'message' => (string) ($smsResult['message'] ?? 'OTP sent successfully.'),
        'phoneNumber' => $phoneNumber,
        'expiresInSeconds' => (int) ($config['otp_expiry_seconds'] ?? 300),
        'debugOtp' => $smsResult['debugOtp'] ?? null,
        'transport' => $smsResult['transport'] ?? null
    ];
}

function otp_send_code(string $rawPhoneNumber): array
{
    $phoneNumber = otp_normalize_phone_number($rawPhoneNumber);
    if (!otp_is_valid_phone_number($phoneNumber)) {
        return [
            'success' => false,
            'status' => 422,
            'message' => 'Enter a valid phone number before sending OTP.',
            'phoneNumber' => $phoneNumber
        ];
    }

    $otpLength = (int) (otp_config()['otp_length'] ?? 6);
    $otpCode = otp_generate_code($otpLength);

    return otp_store_request($phoneNumber, $otpCode);
}

function otp_verify_code(string $rawPhoneNumber, string $otpCode): array
{
    otp_ensure_table();
    otp_cleanup_old_rows();

    $phoneNumber = otp_normalize_phone_number($rawPhoneNumber);
    if (!otp_is_valid_phone_number($phoneNumber)) {
        return [
            'success' => false,
            'status' => 422,
            'message' => 'Enter a valid phone number before verifying OTP.'
        ];
    }

    $otpCode = trim($otpCode);
    $expectedLength = (int) (otp_config()['otp_length'] ?? 6);
    if (preg_match('/^\d{' . $expectedLength . '}$/', $otpCode) !== 1) {
        return [
            'success' => false,
            'status' => 422,
            'message' => 'Enter the ' . $expectedLength . '-digit OTP code from the phone.'
        ];
    }

    $row = otp_fetch_latest_request($phoneNumber, otp_purpose(), session_id());
    if ($row === null) {
        return [
            'success' => false,
            'status' => 404,
            'message' => 'Send the OTP first before verifying the code.'
        ];
    }

    if (!empty($row['verified_at'])) {
        $_SESSION['online_register_verified_phone'] = $phoneNumber;

        return [
            'success' => true,
            'status' => 200,
            'message' => 'Phone number already verified for this session.',
            'phoneNumber' => $phoneNumber
        ];
    }

    if (strtotime((string) $row['expires_at']) < time()) {
        return [
            'success' => false,
            'status' => 410,
            'message' => 'OTP expired. Send a new code and try again.'
        ];
    }

    $maxAttempts = (int) (otp_config()['max_verify_attempts'] ?? 5);
    if ((int) $row['attempts'] >= $maxAttempts) {
        return [
            'success' => false,
            'status' => 429,
            'message' => 'Too many invalid OTP attempts. Send a new code and try again.'
        ];
    }

    $otpMatches = password_verify($otpCode, (string) $row['otp_hash']);
    if (!$otpMatches) {
        $attempts = (int) $row['attempts'] + 1;
        $statement = otp_db()->prepare('UPDATE online_register_otp SET attempts = ? WHERE id = ?');
        if (!$statement) {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Database error: unable to update attempts.'
            ];
        }
        $rowId = (int) $row['id'];
        $statement->bind_param('ii', $attempts, $rowId);
        $statement->execute();
        $statement->close();

        return [
            'success' => false,
            'status' => 422,
            'message' => 'OTP verification failed. Check the code and try again.'
        ];
    }

    $verifiedAt = date('Y-m-d H:i:s');
    $attempts = (int) $row['attempts'] + 1;
    $statement = otp_db()->prepare('UPDATE online_register_otp SET attempts = ?, verified_at = ? WHERE id = ?');
    if (!$statement) {
        return [
            'success' => false,
            'status' => 500,
            'message' => 'Database error: unable to update verification.'
        ];
    }

    $_SESSION['online_register_verified_phone'] = $phoneNumber;

    return [
        'success' => true,
        'status' => 200,
        'message' => 'Phone number verified successfully.',
        'phoneNumber' => $phoneNumber
    ];
}
