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

$messageId = trim((string) ($_POST['ud_id'] ?? ''));
$sender = trim((string) ($_POST['M_sender'] ?? ''));
$receiver = trim((string) ($_POST['M_Reciever'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$currentUserId = departmentCurrentUserId();

if ($messageId === '' || $sender === '' || $receiver === '' || $message === '' || $currentUserId === '') {
    header('Location: usernotification.php?status=error');
    exit;
}

if ($sender !== $currentUserId) {
    header('Location: usernotification.php?status=error');
    exit;
}

$messageStmt = mysqli_prepare(
    $conn,
    "SELECT M_ID
     FROM message
     WHERE M_ID = ? AND M_Reciever = ?
     LIMIT 1"
);
if (!$messageStmt) {
    header('Location: usernotification.php?status=error');
    exit;
}

mysqli_stmt_bind_param($messageStmt, 'ss', $messageId, $currentUserId);
mysqli_stmt_execute($messageStmt);
$messageResult = mysqli_stmt_get_result($messageStmt);
$messageExists = $messageResult instanceof mysqli_result && mysqli_fetch_assoc($messageResult);
if ($messageResult instanceof mysqli_result) {
    mysqli_free_result($messageResult);
}
mysqli_stmt_close($messageStmt);

if (!$messageExists) {
    header('Location: usernotification.php?status=error');
    exit;
}

$updateStmt = mysqli_prepare($conn, "UPDATE message SET M_sender = 'replay', status = 'yes' WHERE M_ID = ?");
$insertStmt = mysqli_prepare(
    $conn,
    "INSERT INTO message (M_sender, M_Reciever, message, date_sended, status)
     VALUES (?, ?, ?, NOW(), 'no')"
);

if (!$updateStmt || !$insertStmt) {
    if ($updateStmt) {
        mysqli_stmt_close($updateStmt);
    }
    if ($insertStmt) {
        mysqli_stmt_close($insertStmt);
    }
    header('Location: usernotification.php?status=error');
    exit;
}

mysqli_begin_transaction($conn);

mysqli_stmt_bind_param($updateStmt, 's', $messageId);
$updated = mysqli_stmt_execute($updateStmt);

mysqli_stmt_bind_param($insertStmt, 'sss', $sender, $receiver, $message);
$inserted = mysqli_stmt_execute($insertStmt);

if ($updated && $inserted) {
    mysqli_commit($conn);
    $status = 'replied';
} else {
    mysqli_rollback($conn);
    $status = 'error';
}

mysqli_stmt_close($updateStmt);
mysqli_stmt_close($insertStmt);

header('Location: usernotification.php?status=' . rawurlencode($status));
exit;
?>
