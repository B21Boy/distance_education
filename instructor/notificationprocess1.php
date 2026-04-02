<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$messageId = isset($_POST['ud_id']) ? trim((string) $_POST['ud_id']) : '';
$sender = instructorCurrentUserId();
$receiver = isset($_POST['M_Reciever']) ? trim((string) $_POST['M_Reciever']) : '';
$message = isset($_POST['message']) ? trim((string) $_POST['message']) : '';

if ($messageId === '' || $sender === '' || $receiver === '' || $message === '') {
    header("location: usernotification.php?status=invalid");
    exit;
}

$verify = mysqli_prepare($conn, "SELECT 1 FROM message WHERE M_ID = ? AND M_reciever = ? LIMIT 1");
if (!$verify) {
    header("location: usernotification.php?status=failed");
    exit;
}

mysqli_stmt_bind_param($verify, 'ss', $messageId, $sender);
mysqli_stmt_execute($verify);
$verifyResult = mysqli_stmt_get_result($verify);
$messageExists = $verifyResult instanceof mysqli_result && mysqli_num_rows($verifyResult) > 0;
if ($verifyResult instanceof mysqli_result) {
    mysqli_free_result($verifyResult);
}
mysqli_stmt_close($verify);

if (!$messageExists) {
    header("location: usernotification.php?status=not-found");
    exit;
}

$update = mysqli_prepare($conn, "UPDATE message SET status = 'yes' WHERE M_ID = ?");
$insert = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
if (!$update || !$insert) {
    if ($update) {
        mysqli_stmt_close($update);
    }
    if ($insert) {
        mysqli_stmt_close($insert);
    }
    header("location: usernotification.php?status=failed");
    exit;
}

mysqli_begin_transaction($conn);
mysqli_stmt_bind_param($update, 's', $messageId);
$updated = mysqli_stmt_execute($update);
mysqli_stmt_bind_param($insert, 'sss', $sender, $receiver, $message);
$inserted = mysqli_stmt_execute($insert);

if ($updated && $inserted) {
    mysqli_commit($conn);
    $status = 'reply-sent';
} else {
    mysqli_rollback($conn);
    $status = 'failed';
}

mysqli_stmt_close($update);
mysqli_stmt_close($insert);

header("location: usernotification.php?status=" . $status);
exit;
