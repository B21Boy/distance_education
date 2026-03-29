<?php
session_start();
require_once("../connection.php");

if (!isset($_SESSION['suid'])) {
    header("location:../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header("location:updateprofilephoto.php");
    exit;
}

if (!($conn instanceof mysqli)) {
    header("location:updateprofilephoto.php?status=failed");
    exit;
}

$studentId = trim((string) $_SESSION['suid']);
if (!isset($_FILES['photo']) || !is_array($_FILES['photo'])) {
    header("location:updateprofilephoto.php?status=missing");
    exit;
}

$photo = $_FILES['photo'];
if (($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    header("location:updateprofilephoto.php?status=invalid");
    exit;
}

$fileSize = (int) ($photo['size'] ?? 0);
$tmpName = (string) ($photo['tmp_name'] ?? '');
$originalName = trim((string) ($photo['name'] ?? ''));

if ($tmpName === '' || $fileSize < 1 || $fileSize > 2000000) {
    header("location:updateprofilephoto.php?status=invalid");
    exit;
}

$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
$mimeType = $finfo ? (string) finfo_file($finfo, $tmpName) : '';
if ($finfo) {
    finfo_close($finfo);
}

$allowedTypes = array(
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp'
);

if (!isset($allowedTypes[$mimeType])) {
    header("location:updateprofilephoto.php?status=invalid");
    exit;
}

$extension = $allowedTypes[$mimeType];
$uploadDir = __DIR__ . '/userphoto';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
    header("location:updateprofilephoto.php?status=failed");
    exit;
}

$safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
$safeBase = $safeBase !== null ? trim($safeBase, '_') : '';
if ($safeBase === '') {
    $safeBase = 'student_photo';
}

$fileName = $studentId . '_' . $safeBase . '_' . date('YmdHis') . '.' . $extension;
$targetPath = $uploadDir . '/' . $fileName;
$dbPhotoPath = 'userphoto/' . $fileName;

if (!move_uploaded_file($tmpName, $targetPath)) {
    header("location:updateprofilephoto.php?status=failed");
    exit;
}

$stmt = mysqli_prepare($conn, "UPDATE user SET photo = ? WHERE UID = ?");
if (!($stmt instanceof mysqli_stmt)) {
    @unlink($targetPath);
    header("location:updateprofilephoto.php?status=failed");
    exit;
}

mysqli_stmt_bind_param($stmt, 'ss', $dbPhotoPath, $studentId);
$updated = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$updated) {
    @unlink($targetPath);
    header("location:updateprofilephoto.php?status=failed");
    exit;
}

$_SESSION['sphoto'] = $dbPhotoPath;
header("location:updateprofilephoto.php?status=success");
exit;
?>
