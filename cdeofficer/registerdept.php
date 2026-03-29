<?php
include '../connection.php';

function registerdept_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'managedept.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    registerdept_redirect('Invalid request.');
}

$id = isset($_POST['dc']) ? trim((string) $_POST['dc']) : '';
$name = isset($_POST['dn']) ? trim((string) $_POST['dn']) : '';
$location = isset($_POST['loc']) ? trim((string) $_POST['loc']) : '';
$collegeCode = isset($_POST['cc']) ? trim((string) $_POST['cc']) : '';

if ($id === '' || $name === '' || $location === '' || $collegeCode === '') {
    registerdept_redirect('All department fields are required.');
}

$collegeStmt = mysqli_prepare($conn, "SELECT Ccode FROM collage WHERE Ccode = ? LIMIT 1");
if (!$collegeStmt) {
    registerdept_redirect('Unable to validate the selected college code.');
}

mysqli_stmt_bind_param($collegeStmt, "s", $collegeCode);
mysqli_stmt_execute($collegeStmt);
$collegeResult = mysqli_stmt_get_result($collegeStmt);
$collegeExists = $collegeResult instanceof mysqli_result && mysqli_fetch_assoc($collegeResult);
if ($collegeResult instanceof mysqli_result) {
    mysqli_free_result($collegeResult);
}
mysqli_stmt_close($collegeStmt);

if (!$collegeExists) {
    registerdept_redirect('The selected college code does not exist.');
}

$insertStmt = mysqli_prepare($conn, "INSERT INTO department (Dcode, DName, Location, Ccode) VALUES (?, ?, ?, ?)");
if (!$insertStmt) {
    registerdept_redirect('Unable to prepare the department registration.');
}

mysqli_stmt_bind_param($insertStmt, "ssss", $id, $name, $location, $collegeCode);
$saved = mysqli_stmt_execute($insertStmt);
$errorCode = mysqli_errno($conn);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($insertStmt);

if (!$saved) {
    if ($errorCode === 1062) {
        registerdept_redirect('Department code or department name already exists.');
    }

    registerdept_redirect('Department was not registered. ' . $errorMessage);
}

registerdept_redirect('Successfully Registered.');
?>
