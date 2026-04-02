<?php
session_start();
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: feedback.php");
    exit;
}

$name = trim((string) ($_POST['faname'] ?? ''));
$email = trim((string) ($_POST['em'] ?? ''));
$comment = trim((string) ($_POST['feedback'] ?? ''));
$role = trim((string) ($_POST['ut'] ?? 'guest'));

if ($role === '' || !preg_match('/^[a-z_]+$/i', $role)) {
    $role = 'guest';
}

$isValidName = $name !== '' && preg_match("/^[A-Za-z][A-Za-z .'-]*$/", $name);
$isValidEmail = $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL);
$isValidComment = $comment !== '' && strlen($comment) >= 10;

if (!$isValidName || !$isValidEmail || !$isValidComment) {
    header("Location: feedback.php?status=invalid");
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO feed_back (name, email, role, Comment, date) VALUES (?, ?, ?, ?, NOW())");
if (!$stmt) {
    header("Location: feedback.php?status=error");
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $role, $comment);
$saved = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: feedback.php?status=" . ($saved ? 'success' : 'error'));
exit;
?>
