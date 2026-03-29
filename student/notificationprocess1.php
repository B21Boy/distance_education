<?php
require_once("../connection.php");

$messageId = trim((string) ($_POST['ud_id'] ?? ''));
$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($messageId !== '') {
    $updateStmt = mysqli_prepare($conn, "UPDATE message SET M_sender = 'replay', status = 'yes' WHERE M_ID = ?");
    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, 's', $messageId);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    }
}

if ($sender !== '' && $receiver !== '' && $message !== '') {
    $insertStmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, 'sss', $sender, $receiver, $message);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);
    }
}

header("location: usernotification.php");
exit;
?>
