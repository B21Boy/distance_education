<?php
session_start();
include(__DIR__ . '/../connection.php');

function redirect_with_message(string $type, string $message): void
{
    header('Location: changepass.php?type=' . urlencode($type) . '&message=' . urlencode($message));
    exit;
}

if (!isset($_SESSION['suid'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    redirect_with_message('error', 'Invalid request.');
}

if (!($conn instanceof mysqli)) {
    redirect_with_message('error', 'Database connection is not available.');
}

$uid = (string) $_SESSION['suid'];
$oldPassword = trim((string) ($_POST['opass'] ?? ''));
$newPassword = trim((string) ($_POST['npass'] ?? ''));
$confirmPassword = trim((string) ($_POST['rnpass'] ?? ''));

if ($oldPassword === '' || $newPassword === '' || $confirmPassword === '') {
    redirect_with_message('error', 'All password fields are required.');
}
if ($newPassword !== $confirmPassword) {
    redirect_with_message('error', 'New password and confirmation do not match.');
}
if ($oldPassword === $newPassword) {
    redirect_with_message('error', 'The new password must be different from the old password.');
}

$stmt = mysqli_prepare($conn, 'SELECT Password FROM account WHERE UID = ? LIMIT 1');
if (!($stmt instanceof mysqli_stmt)) {
    redirect_with_message('error', 'Could not prepare the password lookup.');
}
mysqli_stmt_bind_param($stmt, 's', $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
}
mysqli_stmt_close($stmt);

if (!$row) {
    redirect_with_message('error', 'Account record not found.');
}
if ((string) $row['Password'] !== $oldPassword) {
    redirect_with_message('error', 'Old password is incorrect.');
}

$updateStmt = mysqli_prepare($conn, 'UPDATE account SET Password = ? WHERE UID = ?');
if (!($updateStmt instanceof mysqli_stmt)) {
    redirect_with_message('error', 'Could not prepare the password update.');
}
mysqli_stmt_bind_param($updateStmt, 'ss', $newPassword, $uid);
$updated = mysqli_stmt_execute($updateStmt);
mysqli_stmt_close($updateStmt);

if (!$updated) {
    redirect_with_message('error', 'Could not update the password.');
}

$_SESSION['spw'] = $newPassword;
redirect_with_message('success', 'Password changed successfully.');
?>
