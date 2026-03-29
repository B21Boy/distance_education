<?php
require_once("../connection.php");

$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($sender !== '' && $receiver !== '' && $message !== '') {
    $stmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $sender, $receiver, $message);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("location: usernotification.php");
exit;
?>
