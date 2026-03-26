<?php
require __DIR__ . '/otp_service.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    otp_json_response(405, [
        'success' => false,
        'message' => 'Only POST requests are allowed.'
    ]);
}

$input = otp_read_input();
$phoneNumber = (string) ($input['phoneNumber'] ?? '');
$otpCode = (string) ($input['otpCode'] ?? '');

$result = otp_verify_code($phoneNumber, $otpCode);
otp_json_response((int) ($result['status'] ?? 200), $result);
