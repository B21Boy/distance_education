<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['suid'])) {
    header("location: ../index.php");
    exit;
}

if (!isset($_POST['submit']) || !isset($_FILES['photo'])) {
    header("location: updateprofilephoto.php?status=error");
    exit;
}

$userId = trim((string) $_SESSION['suid']);
$photo = $_FILES['photo'];

if (($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    header("location: updateprofilephoto.php?status=upload");
    exit;
}

$maxSize = 2 * 1024 * 1024;
if (($photo['size'] ?? 0) > $maxSize) {
    header("location: updateprofilephoto.php?status=too-large");
    exit;
}

$allowedExtensions = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp'
];

$originalName = (string) ($photo['name'] ?? '');
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$tmpPath = (string) ($photo['tmp_name'] ?? '');
$mimeType = '';
$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
if ($finfo) {
    $mimeType = (string) finfo_file($finfo, $tmpPath);
    finfo_close($finfo);
} else {
    $mimeType = (string) ($photo['type'] ?? '');
}

if (!isset($allowedExtensions[$extension]) || $allowedExtensions[$extension] !== $mimeType) {
    header("location: updateprofilephoto.php?status=invalid-type");
    exit;
}

$uploadDir = __DIR__ . '/userphoto';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
    header("location: updateprofilephoto.php?status=error");
    exit;
}

$safeFileName = preg_replace('/[^a-zA-Z0-9_-]+/', '_', $userId) . '_' . time() . '.' . $extension;
$targetPath = $uploadDir . '/' . $safeFileName;
$relativePath = 'userphoto/' . $safeFileName;

if (!move_uploaded_file($tmpPath, $targetPath)) {
    header("location: updateprofilephoto.php?status=upload");
    exit;
}

$stmt = mysqli_prepare($conn, "UPDATE user SET photo = ? WHERE UID = ?");
if (!$stmt) {
    header("location: updateprofilephoto.php?status=error");
    exit;
}

mysqli_stmt_bind_param($stmt, 'ss', $relativePath, $userId);
$updated = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($updated) {
    $_SESSION['sphoto'] = $relativePath;
    header("location: updateprofilephoto.php?status=success");
    exit;
}

header("location: updateprofilephoto.php?status=error");
exit;
?>
