<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['suid'])) {
    header("location: ../index.php");
    exit;
}

function encryptIt($value)
{
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $value, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
}

if (!isset($_POST['submit'])) {
    header("location: changepass.php");
    exit;
}

$user_id = trim((string) $_SESSION['suid']);
$old_password = trim((string) ($_POST['opass'] ?? ''));
$new_password = trim((string) ($_POST['npass'] ?? ''));
$confirm_password = trim((string) ($_POST['rnpass'] ?? ''));

if ($old_password === '' || $new_password === '' || $confirm_password === '') {
    header("location: changepass.php?status=empty");
    exit;
}

if ($new_password !== $confirm_password) {
    header("location: changepass.php?status=password-mismatch");
    exit;
}

if ($old_password === $new_password) {
    header("location: changepass.php?status=same-password");
    exit;
}

$old_encrypted = encryptIt($old_password);
$new_encrypted = encryptIt($new_password);

$stmt = mysqli_prepare($conn, "SELECT Password FROM account WHERE UID = ? LIMIT 1");
if (!$stmt) {
    header("location: changepass.php?status=error");
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
}
mysqli_stmt_close($stmt);

$current_password = isset($row['Password']) ? (string) $row['Password'] : '';
if ($current_password === '' || $current_password !== $old_encrypted) {
    header("location: changepass.php?status=old-password");
    exit;
}

$update_stmt = mysqli_prepare($conn, "UPDATE account SET Password = ? WHERE UID = ?");
if (!$update_stmt) {
    header("location: changepass.php?status=error");
    exit;
}

mysqli_stmt_bind_param($update_stmt, 'ss', $new_encrypted, $user_id);
$updated = mysqli_stmt_execute($update_stmt);
mysqli_stmt_close($update_stmt);

header("location: changepass.php?status=" . ($updated ? 'success' : 'error'));
exit;
?>
