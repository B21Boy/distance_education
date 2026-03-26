<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['suid'])) {
    header("Location: ../index.php");
    exit;
}

function redirect_with_status($type, $message)
{
    header("Location: updateprofilephoto.php?type=" . urlencode($type) . "&message=" . urlencode($message));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    redirect_with_status('error', 'Invalid request.');
}

if (!isset($_FILES['photo'])) {
    redirect_with_status('error', 'Please choose a photo to upload.');
}

if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    redirect_with_status('error', 'The photo upload failed. Please try again.');
}

$uid = $_SESSION['suid'];
$tmpPhotoPath = $_FILES['photo']['tmp_name'];
$photoSize = (int) $_FILES['photo']['size'];

if ($photoSize <= 0) {
    redirect_with_status('error', 'The selected photo is empty.');
}

if ($photoSize > 2000000) {
    redirect_with_status('error', 'Photo size must be 2MB or less.');
}

$imageInfo = @getimagesize($tmpPhotoPath);
if ($imageInfo === false) {
    redirect_with_status('error', 'Only image files are allowed.');
}

$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp',
];

$mimeType = isset($imageInfo['mime']) ? $imageInfo['mime'] : '';
if (!isset($allowedMimeTypes[$mimeType])) {
    redirect_with_status('error', 'Please upload a JPG, PNG, GIF, or WEBP image.');
}

$uploadDirectory = __DIR__ . '/userphoto';
if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0777, true)) {
    redirect_with_status('error', 'Could not create the photo folder.');
}

@chmod($uploadDirectory, 0777);
if (!is_writable($uploadDirectory)) {
    redirect_with_status('error', 'Photo folder is not writable. Please check admin/userphoto permissions.');
}

$fileName = 'admin_' . preg_replace('/[^A-Za-z0-9_-]/', '_', (string) $uid) . '_' . time() . '.' . $allowedMimeTypes[$mimeType];
$relativePhotoPath = 'userphoto/' . $fileName;
$fullPhotoPath = $uploadDirectory . '/' . $fileName;

if (!move_uploaded_file($tmpPhotoPath, $fullPhotoPath)) {
    redirect_with_status('error', 'Could not save the uploaded photo.');
}

$stmt = $conn->prepare("UPDATE user SET photo = ? WHERE UID = ?");
if (!$stmt) {
    @unlink($fullPhotoPath);
    redirect_with_status('error', 'Could not prepare the photo update.');
}

$stmt->bind_param("ss", $relativePhotoPath, $uid);
if (!$stmt->execute()) {
    $stmt->close();
    @unlink($fullPhotoPath);
    redirect_with_status('error', 'Could not update the photo in the database.');
}

$stmt->close();
$_SESSION['sphoto'] = $relativePhotoPath;

redirect_with_status('success', 'Profile photo changed successfully.');
?>
