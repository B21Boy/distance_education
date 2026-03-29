<?php
include '../connection.php';

function updateposted_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'updatepost.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    updateposted_redirect('Invalid request.');
}

$no = isset($_POST['no']) ? trim((string) $_POST['no']) : '';
$title = isset($_POST['title']) ? trim((string) $_POST['title']) : '';
$type = isset($_POST['typ']) ? trim((string) $_POST['typ']) : '';
$date = isset($_POST['date']) ? trim((string) $_POST['date']) : '';
$exdate = isset($_POST['exd']) ? trim((string) $_POST['exd']) : '';
$sdate = isset($_POST['sd']) ? trim((string) $_POST['sd']) : '';
$edate = isset($_POST['ed']) ? trim((string) $_POST['ed']) : '';
$infor = isset($_POST['infor']) ? trim((string) $_POST['infor']) : '';
$postedBy = isset($_POST['pb']) ? trim((string) $_POST['pb']) : '';
$status = isset($_POST['st']) ? trim((string) $_POST['st']) : 'register';

if ($no === '' || $title === '' || $type === '' || $date === '' || $exdate === '' || $sdate === '' || $edate === '' || $infor === '' || $postedBy === '' || $status === '') {
    updateposted_redirect('All update fields are required.');
}

$stmt = mysqli_prepare($conn, "UPDATE postss SET Title = ?, types = ?, dates = ?, Ex_date = ?, start_date = ?, end_date = ?, info = ?, posted_by = ?, status = ? WHERE no = ?");
if (!$stmt) {
    updateposted_redirect('Unable to prepare the update.');
}

mysqli_stmt_bind_param($stmt, "sssssssssi", $title, $type, $date, $exdate, $sdate, $edate, $infor, $postedBy, $status, $no);
$saved = mysqli_stmt_execute($stmt);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($stmt);

if (!$saved) {
    updateposted_redirect('Notice was not updated. ' . $errorMessage);
}

updateposted_redirect('Successfully Updated.');
?>

