<?php
session_start();
include '../connection.php';

if (!isset($_POST['sent'])) {
    header("location: updatepost.php");
    exit;
}

$title = trim((string) ($_POST['title'] ?? ''));
$type = trim((string) ($_POST['typ'] ?? ''));
$info = trim((string) ($_POST['infor'] ?? ''));
$date = trim((string) ($_POST['date'] ?? ''));
$expireDate = trim((string) ($_POST['edate'] ?? ''));
$postedBy = trim((string) ($_POST['pb'] ?? ''));

if ($title === '' || $type === '' || $info === '' || $date === '' || $postedBy === '') {
    echo '<script type="text/javascript">alert("Please complete all required notice fields.");window.location=\'updatepost.php\';</script>';
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO postss (Title, types, dates, Ex_date, info, posted_by) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo '<script type="text/javascript">alert("Error! notice was not posted.");window.location=\'updatepost.php\';</script>';
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssssss', $title, $type, $date, $expireDate, $info, $postedBy);
$saved = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($saved) {
    echo '<script type="text/javascript">alert("Successfully posted.");window.location=\'updatepost.php\';</script>';
} else {
    echo '<script type="text/javascript">alert("Error! notice was not posted.");window.location=\'updatepost.php\';</script>';
}
exit;
?>
