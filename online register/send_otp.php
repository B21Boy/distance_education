<?php
require __DIR__ . '/otp_service.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    otp_json_response(405, [
        'success' => false,
        'message' => 'Only POST requests are allowed.'
    ]);
}

$input = otp_read_input();
$username = trim((string) ($input['username'] ?? ''));
$password = (string) ($input['password'] ?? '');
$confirmPassword = (string) ($input['confirmPassword'] ?? '');
$phoneNumber = (string) ($input['phoneNumber'] ?? '');

if ($username === '') {
    otp_json_response(422, [
        'success' => false,
        'message' => 'Enter the user name.'
    ]);
}

if (strlen($password) < 6) {
    otp_json_response(422, [
        'success' => false,
        'message' => 'Password must be at least 6 characters long.'
    ]);
}

if ($password !== $confirmPassword) {
    otp_json_response(422, [
        'success' => false,
        'message' => 'Password and confirm password do not match.'
    ]);
}

$result = otp_send_code($phoneNumber);
otp_json_response((int) ($result['status'] ?? 200), $result);
