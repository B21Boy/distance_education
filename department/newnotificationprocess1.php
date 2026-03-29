<?php
session_start();
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: usernotification.php');
    exit;
}

if (!departmentIsLoggedIn()) {
    header('Location: usernotification.php?status=error');
    exit;
}

$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$currentUserId = departmentCurrentUserId();

if ($sender === '' || $receiver === '' || $message === '' || $currentUserId === '') {
    header('Location: usernotification.php?status=error');
    exit;
}

if ($sender !== $currentUserId) {
    header('Location: usernotification.php?status=error');
    exit;
}

$recipientStmt = mysqli_prepare(
    $conn,
    "SELECT UID
     FROM account
     WHERE UID = ? AND Role IN ('department_head', 'registrar', 'instructor', 'collage_dean', 'cdeofficer')
     LIMIT 1"
);
if (!$recipientStmt) {
    header('Location: usernotification.php?status=error');
    exit;
}

mysqli_stmt_bind_param($recipientStmt, 's', $receiver);
mysqli_stmt_execute($recipientStmt);
$recipientResult = mysqli_stmt_get_result($recipientStmt);
$recipientExists = $recipientResult instanceof mysqli_result && mysqli_fetch_assoc($recipientResult);
if ($recipientResult instanceof mysqli_result) {
    mysqli_free_result($recipientResult);
}
mysqli_stmt_close($recipientStmt);

if (!$recipientExists) {
    header('Location: usernotification.php?status=error');
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status)
     VALUES (?, ?, ?, NOW(), 'no')"
);
if (!$stmt) {
    header('Location: usernotification.php?status=error');
    exit;
}

mysqli_stmt_bind_param($stmt, 'sss', $sender, $receiver, $message);
$sent = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header('Location: usernotification.php?status=' . rawurlencode($sent ? 'sent' : 'error'));
exit;
?>
