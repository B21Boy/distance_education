<?php
session_start();
include('../connection.php');
require_once('page_helpers.php');

if (!instructorIsLoggedIn()) {
    header('location:../index.php');
    exit;
}

$courseCode = trim((string) ($_POST['id'] ?? ''));
$uid = instructorCurrentUserId();
$fileName = trim((string) ($_FILES['image']['name'] ?? ''));
$tmpName = trim((string) ($_FILES['image']['tmp_name'] ?? ''));

if ($courseCode === '' || $uid === '' || $fileName === '' || $tmpName === '') {
    exit("<script>alert('Error! missing module upload data.');window.location='uploadmoduleto.php';</script>");
}

move_uploaded_file($tmpName, '../material/module/' . $fileName);

$sql = "UPDATE course SET Sender_name = ?, FileName = ?, status = 'no' WHERE course_code = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    exit("<script>alert('Error! not uploaded!');window.location='uploadmoduleto.php';</script>");
}

mysqli_stmt_bind_param($stmt, 'sss', $uid, $fileName, $courseCode);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo "<script type='text/javascript'>alert('Successfully Uploaded !!!');window.location='uploadmoduleto.php';</script>";
    exit;
}

exit("<script>alert('Error! not uploaded!');window.location='uploadmoduleto.php';</script>");