<?php
include '../connection.php';
$config = include 'otp_config.php';

// Chapa can send data via GET or POST
$trx_ref = $_GET['trx_ref'] ?? $_POST['trx_ref'] ?? '';
$status = $_GET['status'] ?? $_POST['status'] ?? '';

error_log("Verify payment called - trx_ref: $trx_ref, status: $status");
error_log("GET params: " . json_encode($_GET));
error_log("POST params: " . json_encode($_POST));

if (empty($trx_ref)) {
    http_response_code(400);
    echo 'Invalid request - no trx_ref';
    exit;
}

// For test mode, if status is provided directly, use it
if (!empty($status)) {
    $verified_status = $status;
    error_log("Using provided status: $verified_status");
} else {
    // Verify with Chapa
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $config['chapa']['api_base_url'] . '/transaction/verify/' . $trx_ref);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $config['chapa']['secret_key']
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    error_log("Chapa verify response - HTTP: $http_code, Response: $response");

    if ($http_code !== 200) {
        error_log("Chapa verify failed for $trx_ref");
        // Don't exit, try to continue
        $verified_status = 'failed';
    } else {
        $data = json_decode($response, true);
        if (!$data || !isset($data['data']['status'])) {
            error_log("Invalid verify response for $trx_ref");
            $verified_status = 'failed';
        } else {
            $verified_status = $data['data']['status']; // success, failed, etc.
        }
    }
}

// Update database
$update_status = ($verified_status === 'success') ? 'success' : 'failed';
$conn->query("UPDATE applicant_payments SET status='$update_status' WHERE tx_ref='$trx_ref'");
error_log("Updated payment status to: $update_status for trx_ref: $trx_ref");

// Return success to Chapa
echo json_encode(['status' => 'success']);

$conn->close();

// Since it's callback, no output needed, but Chapa expects no response or something
// Actually, callbacks don't need response, but to be safe, echo ok
echo 'OK';
?>