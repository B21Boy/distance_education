<?php
session_start();
include("../connection.php");

function notificationprocess1_redirect(string $message = ''): void
{
    $target = 'usernotification.php';
    if ($message !== '') {
        echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=' . json_encode($target) . ';</script>';
        exit;
    }

    header("location: " . $target);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    notificationprocess1_redirect('Invalid request.');
}

$ud_id = isset($_POST['ud_id']) ? (int) $_POST['ud_id'] : 0;
$M_sender = isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : trim((string) ($_POST['M_sender'] ?? ''));
$M_Reciever = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($ud_id <= 0 || $M_sender === '' || $M_Reciever === '' || $message === '') {
    notificationprocess1_redirect('All reply fields are required.');
}

$updateStmt = mysqli_prepare($conn, "UPDATE message SET status = 'yes' WHERE M_ID = ?");
if (!$updateStmt) {
    notificationprocess1_redirect('Unable to prepare the message update.');
}

mysqli_stmt_bind_param($updateStmt, "i", $ud_id);
$updated = mysqli_stmt_execute($updateStmt);
$updateError = mysqli_error($conn);
mysqli_stmt_close($updateStmt);

if (!$updated) {
    notificationprocess1_redirect('The original message could not be updated. ' . $updateError);
}

$insertStmt = mysqli_prepare($conn, "INSERT INTO message (M_sender, M_reciever, message, date_sended, status) VALUES (?, ?, ?, NOW(), 'no')");
if (!$insertStmt) {
    notificationprocess1_redirect('Unable to prepare the reply message.');
}

mysqli_stmt_bind_param($insertStmt, "sss", $M_sender, $M_Reciever, $message);
$inserted = mysqli_stmt_execute($insertStmt);
$insertError = mysqli_error($conn);
mysqli_stmt_close($insertStmt);

if (!$inserted) {
    notificationprocess1_redirect('Reply was not sent. ' . $insertError);
}

notificationprocess1_redirect('Reply sent successfully.');
?>
