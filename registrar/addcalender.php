<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: acadamic_calender.php');
    exit;
}

$semister = trim((string) ($_POST['semister'] ?? ''));
$date = trim((string) ($_POST['date'] ?? ''));
$activ = trim((string) ($_POST['activ'] ?? ''));

if ($semister === '' || $date === '' || $activ === '') {
    header('Location: acadamic_calender.php?status=error');
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO acadamic_calender (semister, date, activ) VALUES (?, ?, ?)");
if (!$stmt) {
    header('Location: acadamic_calender.php?status=error');
    exit;
}

mysqli_stmt_bind_param($stmt, 'sss', $semister, $date, $activ);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header('Location: acadamic_calender.php?status=' . ($ok ? 'success' : 'error'));
exit;
?>
