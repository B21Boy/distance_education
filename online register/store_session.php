<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$phone_number = trim($_POST['phone_number'] ?? '');

if (empty($username) || empty($password) || empty($phone_number)) {
    echo json_encode(['error' => 'All fields required']);
    exit;
}

$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$_SESSION['phone_number'] = $phone_number;

echo json_encode(['success' => true]);
?>