<?php
include '../connection.php';

function postedu_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'updateposti.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    postedu_redirect('Invalid request.');
}

$title = isset($_POST['title']) ? trim((string) $_POST['title']) : '';
$typ = isset($_POST['typ']) ? trim((string) $_POST['typ']) : '';
$infor = isset($_POST['infor']) ? trim((string) $_POST['infor']) : '';
$date = isset($_POST['date']) ? trim((string) $_POST['date']) : '';
$exdate = isset($_POST['edate']) ? trim((string) $_POST['edate']) : '';
$pb = isset($_POST['pb']) ? trim((string) $_POST['pb']) : '';

if ($title === '' || $typ === '' || $infor === '' || $date === '' || $exdate === '' || $pb === '') {
    postedu_redirect('All notice fields are required.');
}

$startDate = $date;
$endDate = $exdate;
$status = ' ';

$insertStmt = mysqli_prepare(
    $conn,
    "INSERT INTO postss (Title, types, dates, Ex_date, start_date, end_date, info, posted_by, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$insertStmt) {
    postedu_redirect('Unable to prepare the notice post.');
}

mysqli_stmt_bind_param($insertStmt, "sssssssss", $title, $typ, $date, $exdate, $startDate, $endDate, $infor, $pb, $status);
$saved = mysqli_stmt_execute($insertStmt);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($insertStmt);

if (!$saved) {
    postedu_redirect('Notice was not posted. ' . $errorMessage);
}

postedu_redirect('Successfully Posted.');
?>

