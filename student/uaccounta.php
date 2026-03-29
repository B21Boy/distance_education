<?php
session_start();
include(__DIR__ . '/../connection.php');

function student_password_alert_redirect($message)
{
    $statusMap = array(
        'All password fields are required.' => 'empty',
        'Password did not match.' => 'mismatch',
        'The old password cannot be used as the new password.' => 'reuse',
        'Database connection is not available.' => 'db',
        'Could not prepare the password lookup.' => 'db',
        'Account record not found.' => 'missing',
        'Old password is incorrect.' => 'incorrect',
        'Could not prepare the password update.' => 'db',
        'Could not update the password.' => 'db',
        'Password changed successfully.' => 'success',
        'New password is too short.' => 'short'
    );

    $status = isset($statusMap[$message]) ? $statusMap[$message] : 'db';
    header('location:changepass.php?status=' . urlencode($status));
    exit;
}

function student_legacy_encrypt($value)
{
    if (!function_exists('mcrypt_encrypt')) {
        return '';
    }

    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';

    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $value, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
}

function student_password_matches($storedPassword, $enteredPassword)
{
    $storedPassword = (string) $storedPassword;
    $enteredPassword = (string) $enteredPassword;

    if ($storedPassword === $enteredPassword) {
        return true;
    }

    $legacyPassword = student_legacy_encrypt($enteredPassword);
    if ($legacyPassword !== '' && hash_equals($storedPassword, $legacyPassword)) {
        return true;
    }

    if (preg_match('/^[a-f0-9]{32}$/i', $storedPassword) === 1 && hash_equals(strtolower($storedPassword), md5($enteredPassword))) {
        return true;
    }

    return false;
}

if (!isset($_SESSION['suid'])) {
    header('location:../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('location:changepass.php');
    exit;
}

if (!($conn instanceof mysqli)) {
    student_password_alert_redirect('Database connection is not available.');
}

$studentId = trim((string) $_SESSION['suid']);
$oldPassword = trim((string) ($_POST['opass'] ?? ''));
$newPassword = trim((string) ($_POST['npass'] ?? ''));
$confirmPassword = trim((string) ($_POST['rnpass'] ?? ''));

if ($oldPassword === '' || $newPassword === '' || $confirmPassword === '') {
    student_password_alert_redirect('All password fields are required.');
}
if ($newPassword !== $confirmPassword) {
    student_password_alert_redirect('Password did not match.');
}
if ($oldPassword === $newPassword) {
    student_password_alert_redirect('The old password cannot be used as the new password.');
}
if (strlen($newPassword) < 6) {
    student_password_alert_redirect('New password is too short.');
}

$stmt = mysqli_prepare($conn, 'SELECT Password FROM account WHERE UID = ? LIMIT 1');
if (!($stmt instanceof mysqli_stmt)) {
    student_password_alert_redirect('Could not prepare the password lookup.');
}

mysqli_stmt_bind_param($stmt, 's', $studentId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
}
mysqli_stmt_close($stmt);

if (!$row) {
    student_password_alert_redirect('Account record not found.');
}

$storedPassword = isset($row['Password']) ? (string) $row['Password'] : '';
if (!student_password_matches($storedPassword, $oldPassword)) {
    student_password_alert_redirect('Old password is incorrect.');
}

$updateStmt = mysqli_prepare($conn, 'UPDATE account SET Password = ? WHERE UID = ?');
if (!($updateStmt instanceof mysqli_stmt)) {
    student_password_alert_redirect('Could not prepare the password update.');
}

mysqli_stmt_bind_param($updateStmt, 'ss', $newPassword, $studentId);
$updated = mysqli_stmt_execute($updateStmt);
mysqli_stmt_close($updateStmt);

if (!$updated) {
    student_password_alert_redirect('Could not update the password.');
}

$_SESSION['spw'] = $newPassword;
student_password_alert_redirect('Password changed successfully.');
?>
