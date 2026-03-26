<?php
session_start();
include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: usernotification.php");
    exit;
}

$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($sender === '' || $receiver === '' || $message === '') {
    header("location: usernotification.php?status=error");
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
if (!$stmt) {
    header("location: usernotification.php?status=error");
    exit;
}

mysqli_stmt_bind_param($stmt, 'sss', $sender, $receiver, $message);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("location: usernotification.php?status=" . ($ok ? 'sent' : 'error'));
exit;
?>
