<?php
$twilioAccountSid = getenv('TWILIO_ACCOUNT_SID') ?: '';
$twilioAuthToken = getenv('TWILIO_AUTH_TOKEN') ?: '';
$twilioFrom = getenv('TWILIO_FROM') ?: '';
$twilioMessagingServiceSid = getenv('TWILIO_MESSAGING_SERVICE_SID') ?: '';
$twilioConfigured = $twilioAccountSid !== '' && $twilioAuthToken !== '' && ($twilioFrom !== '' || $twilioMessagingServiceSid !== '');

return [
    'purpose' => 'online_register',
    'otp_length' => 6,
    'otp_expiry_seconds' => 300,
    'resend_cooldown_seconds' => 60,
    'max_verify_attempts' => 5,
    'sms' => [
        'driver' => $twilioConfigured ? 'twilio' : 'log',
        'sender_id' => 'DistanceEdu',
        'api_url' => '',
        'api_token' => '',
        'timeout_seconds' => 15,
        'log_file' => __DIR__ . '/otp_debug.log',
        'debug_return_otp' => !$twilioConfigured,
        'twilio' => [
            'account_sid' => $twilioAccountSid,
            'auth_token' => $twilioAuthToken,
            'from' => $twilioFrom,
            'messaging_service_sid' => $twilioMessagingServiceSid,
            'status_callback' => getenv('TWILIO_STATUS_CALLBACK') ?: ''
        ],
        'generic_json' => [
            'recipient_field' => 'to',
            'message_field' => 'message',
            'sender_field' => 'from',
            'authorization_prefix' => 'Bearer ',
            'extra_payload' => []
        ]
    ],
    'chapa' => [
        'public_key' => 'CHAPUBK_TEST-wgG988i9y2HqZYKzleJHbUwGd8gTioTT',
        'secret_key' => 'CHASECK_TEST-Q65g8Qyl46VySAttkJD9FfW4SOlw24Ip',
        'encryption_key' => 'Vlju7rayZBttmq9WhFAHTY6g',
        'api_base_url' => 'https://api.chapa.co/v1',
        'callback_url' => 'http://localhost/distance_education/online%20register/verify_payment.php',
        'return_url' => 'http://localhost/distance_education/online%20register/collage/register%20student.php?status=completed',
        'currency' => 'ETB',
        'application_fee' => 50,
        'registration_fee' => 70,
        'total_fee' => 120
    ]
];
