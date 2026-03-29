<?php
include '../connection.php';

function posted_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'updatepost.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    posted_redirect('Invalid request.');
}

$title = isset($_POST['title']) ? trim((string) $_POST['title']) : '';
$taype = isset($_POST['typ']) ? trim((string) $_POST['typ']) : '';
$date = isset($_POST['date']) ? trim((string) $_POST['date']) : '';
$exdate = isset($_POST['exd']) ? trim((string) $_POST['exd']) : '';
$sdate = isset($_POST['sd']) ? trim((string) $_POST['sd']) : '';
$edate = isset($_POST['ed']) ? trim((string) $_POST['ed']) : '';
$infor = isset($_POST['infor']) ? trim((string) $_POST['infor']) : '';
$pbay = isset($_POST['pb']) ? trim((string) $_POST['pb']) : '';
$st = isset($_POST['st']) ? trim((string) $_POST['st']) : '';

if ($title === '' || $taype === '' || $date === '' || $exdate === '' || $sdate === '' || $edate === '' || $infor === '' || $pbay === '' || $st === '') {
    posted_redirect('All notice fields are required.');
}

$stmt = mysqli_prepare($conn, "INSERT INTO postss (Title, types, dates, Ex_date, start_date, end_date, info, posted_by, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    posted_redirect('Unable to prepare the notice insert.');
}

mysqli_stmt_bind_param($stmt, "sssssssss", $title, $taype, $date, $exdate, $sdate, $edate, $infor, $pbay, $st);
$saved = mysqli_stmt_execute($stmt);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($stmt);

if (!$saved) {
    posted_redirect('Notice was not posted. ' . $errorMessage);
}

posted_redirect('Successfully Posted.');
?>

