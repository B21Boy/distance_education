<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

departmentRequireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['sent'])) {
    header('Location: updatepost.php');
    exit;
}

$title = trim((string) ($_POST['title'] ?? ''));
$type = trim((string) ($_POST['typ'] ?? ''));
$info = trim((string) ($_POST['infor'] ?? ''));
$date = trim((string) ($_POST['date'] ?? ''));
$expireDate = trim((string) ($_POST['edate'] ?? ''));
$postedBy = trim((string) ($_POST['pb'] ?? ''));

if ($title === '' || $type === '' || $info === '' || $date === '' || $postedBy === '') {
    header('Location: updatepost.php?status=empty');
    exit;
}

if ($expireDate !== '') {
    $postedTimestamp = strtotime($date);
    $expireTimestamp = strtotime($expireDate);
    if ($postedTimestamp !== false && $expireTimestamp !== false && $expireTimestamp < $postedTimestamp) {
        header('Location: updatepost.php?status=error');
        exit;
    }
}

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO postss (Title, types, dates, Ex_date, info, posted_by)
     VALUES (?, ?, ?, ?, ?, ?)"
);
if (!$stmt) {
    header('Location: updatepost.php?status=error');
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssssss', $title, $type, $date, $expireDate, $info, $postedBy);
$saved = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header('Location: updatepost.php?status=' . rawurlencode($saved ? 'posted' : 'error'));
exit;
?>
