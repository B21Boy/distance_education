<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['suid'])) {
    header("location: ../index.php");
    exit;
}

if (!isset($_POST['submit'])) {
    header("location: changepass.php");
    exit;
}

$userId = trim((string) $_SESSION['suid']);
$oldPassword = trim((string) ($_POST['opass'] ?? ''));
$newPassword = trim((string) ($_POST['npass'] ?? ''));
$confirmPassword = trim((string) ($_POST['rnpass'] ?? ''));

if ($oldPassword === '' || $newPassword === '' || $confirmPassword === '') {
    header("location: changepass.php?status=empty");
    exit;
}

if ($newPassword !== $confirmPassword) {
    header("location: changepass.php?status=password-mismatch");
    exit;
}

if ($oldPassword === $newPassword) {
    header("location: changepass.php?status=same-password");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT Password FROM account WHERE UID = ? LIMIT 1");
if (!$stmt) {
    header("location: changepass.php?status=error");
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
}
mysqli_stmt_close($stmt);

$currentPassword = isset($row['Password']) ? trim((string) $row['Password']) : '';
if ($currentPassword === '' || $currentPassword !== $oldPassword) {
    header("location: changepass.php?status=old-password");
    exit;
}

$updateStmt = mysqli_prepare($conn, "UPDATE account SET Password = ? WHERE UID = ?");
if (!$updateStmt) {
    header("location: changepass.php?status=error");
    exit;
}

mysqli_stmt_bind_param($updateStmt, 'ss', $newPassword, $userId);
$updated = mysqli_stmt_execute($updateStmt);
mysqli_stmt_close($updateStmt);

if ($updated) {
    $_SESSION['spw'] = $newPassword;
}

header("location: changepass.php?status=" . ($updated ? 'success' : 'error'));
exit;
?>
