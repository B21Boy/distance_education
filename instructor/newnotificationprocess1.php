<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$sender = instructorCurrentUserId();
$receiver = isset($_POST['M_Reciever']) ? trim((string) $_POST['M_Reciever']) : '';
$message = isset($_POST['message']) ? trim((string) $_POST['message']) : '';

if ($sender === '' || $receiver === '' || $message === '' || $sender === $receiver) {
    header("location: usernotification.php?status=invalid");
    exit;
}

$accountCheck = mysqli_prepare($conn, "SELECT 1 FROM account WHERE UID = ? LIMIT 1");
if (!$accountCheck) {
    header("location: usernotification.php?status=failed");
    exit;
}

mysqli_stmt_bind_param($accountCheck, 's', $receiver);
mysqli_stmt_execute($accountCheck);
$accountResult = mysqli_stmt_get_result($accountCheck);
$receiverExists = $accountResult instanceof mysqli_result && mysqli_num_rows($accountResult) > 0;
if ($accountResult instanceof mysqli_result) {
    mysqli_free_result($accountResult);
}
mysqli_stmt_close($accountCheck);

if (!$receiverExists) {
    header("location: usernotification.php?status=not-found");
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
if (!$stmt) {
    header("location: usernotification.php?status=failed");
    exit;
}

mysqli_stmt_bind_param($stmt, 'sss', $sender, $receiver, $message);
$saved = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("location: usernotification.php?status=" . ($saved ? "sent" : "failed"));
exit;
