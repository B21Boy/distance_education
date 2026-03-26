<?php
session_start();
include('../connection.php');
require_once('page_helpers.php');

if (!instructorIsLoggedIn()) {
    header('location:../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:uploadmodule.php');
    exit;
}

$uid = trim((string) ($_POST['uid'] ?? ''));
$asno = trim((string) ($_POST['asno'] ?? ''));
$asv = trim((string) ($_POST['asv'] ?? ''));
$ccode = trim((string) ($_POST['cc'] ?? ''));
$cname = trim((string) ($_POST['cn'] ?? ''));
$dept = trim((string) ($_POST['dc'] ?? ''));
$scyear = trim((string) ($_POST['scy'] ?? ''));
$sem = trim((string) ($_POST['sem'] ?? ''));
$sdate = trim((string) ($_POST['date'] ?? ''));

if ($uid === '' || $asno === '' || $asv === '' || $ccode === '' || $cname === '' || $dept === '' || $scyear === '' || $sem === '' || $sdate === '' || !isset($_FILES['file'])) {
    exit("<script>alert('Error! missing assignment data.');window.location='uploadmodule.php';</script>");
}

$fileName = trim((string) ($_FILES['file']['name'] ?? ''));
$tmpName = trim((string) ($_FILES['file']['tmp_name'] ?? ''));
$fileSize = (string) ($_FILES['file']['size'] ?? '0');
$fileType = trim((string) ($_FILES['file']['type'] ?? ''));

if ($fileName === '' || $tmpName === '') {
    exit("<script>alert('Error! file not selected.');window.location='uploadmodule.php';</script>");
}

$sql = "INSERT INTO assignment VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'inst', 'no')";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    exit("<script>alert('Error! not uploaded!');window.location='uploadmodule.php';</script>");
}

mysqli_stmt_bind_param($stmt, 'sssssssssssss', $uid, $asno, $asv, $ccode, $cname, $dept, $scyear, $sem, $sdate, $fileName, $tmpName, $fileSize, $fileType);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo "<script>alert('Successfully Uploaded !!!');window.location='uploadmodule.php';</script>";
    exit;
}

$error = mysqli_error($conn);
exit("<script>alert('Error! not uploaded!');window.location='uploadmodule.php';</script>" . instructorH($error));