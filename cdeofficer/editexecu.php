<?php
include '../connection.php';

function editexecu_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'viewuploadmodule.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    editexecu_redirect('Invalid request.');
}

$ccode = isset($_POST["cc"]) ? trim((string) $_POST["cc"]) : '';
$dpt = isset($_POST["combo"]) ? trim((string) $_POST["combo"]) : '';
$scy = isset($_POST["combo1"]) ? trim((string) $_POST["combo1"]) : '';
$sem = isset($_POST["sem"]) ? trim((string) $_POST["sem"]) : '';

if ($ccode === '' || $dpt === '' || $scy === '' || $sem === '') {
    editexecu_redirect('All assignment fields are required.');
}

$location = '';
$hasUpload = isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name']);

if ($hasUpload) {
    $fileName = isset($_FILES['image']['name']) ? basename((string) $_FILES['image']['name']) : '';
    if ($fileName === '') {
        editexecu_redirect('Uploaded file name is missing.');
    }

    $targetPath = "../material/module/" . $fileName;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
        editexecu_redirect('The uploaded file could not be saved.');
    }
    $location = $fileName;
}

if ($location !== '') {
    $stmt = mysqli_prepare($conn, "UPDATE course SET s_c_year = ?, semister = ?, FileName = ?, other_department_takes = ?, status = 'yes', unread = 'no' WHERE course_code = ?");
    if (!$stmt) {
        editexecu_redirect('Unable to prepare the module assignment update.');
    }
    mysqli_stmt_bind_param($stmt, "sssss", $scy, $sem, $location, $dpt, $ccode);
} else {
    $stmt = mysqli_prepare($conn, "UPDATE course SET s_c_year = ?, semister = ?, other_department_takes = ?, status = 'yes', unread = 'no' WHERE course_code = ?");
    if (!$stmt) {
        editexecu_redirect('Unable to prepare the module assignment update.');
    }
    mysqli_stmt_bind_param($stmt, "ssss", $scy, $sem, $dpt, $ccode);
}

$updated = mysqli_stmt_execute($stmt);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($stmt);

if (!$updated) {
    editexecu_redirect('Module assignment was not saved. ' . $errorMessage);
}

editexecu_redirect('Module assignment saved successfully.');
?>
