<?php
session_start();
include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: usernotification.php");
    exit;
}

$message_id = trim((string) ($_POST['ud_id'] ?? ''));
$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($message_id === '' || $sender === '' || $receiver === '' || $message === '') {
    header("location: usernotification.php?status=error");
    exit;
}

$update_stmt = mysqli_prepare($conn, "UPDATE message SET M_sender = 'replay', status = 'yes' WHERE M_ID = ?");
$insert_stmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");

if (!$update_stmt || !$insert_stmt) {
    if ($update_stmt) {
        mysqli_stmt_close($update_stmt);
    }
    if ($insert_stmt) {
        mysqli_stmt_close($insert_stmt);
    }
    header("location: usernotification.php?status=error");
    exit;
}

mysqli_begin_transaction($conn);
mysqli_stmt_bind_param($update_stmt, 's', $message_id);
$updated = mysqli_stmt_execute($update_stmt);
mysqli_stmt_bind_param($insert_stmt, 'sss', $sender, $receiver, $message);
$inserted = mysqli_stmt_execute($insert_stmt);

if ($updated && $inserted) {
    mysqli_commit($conn);
    $status = 'replied';
} else {
    mysqli_rollback($conn);
    $status = 'error';
}

mysqli_stmt_close($update_stmt);
mysqli_stmt_close($insert_stmt);

header("location: usernotification.php?status=" . $status);
exit;
?>
