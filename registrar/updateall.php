<?php
session_start();
require_once("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

function registrarUpdateAllFlash(string $message, string $class): void
{
    $_SESSION['studentlist_status'] = array(
        'message' => $message,
        'class' => $class,
    );
}

function registrarUpdateAllNextStage(string $year, string $semester): ?array
{
    $map = array(
        '1st|I' => array('year' => '1st', 'semester' => 'II'),
        '1st|II' => array('year' => '1st', 'semester' => 'III'),
        '1st|III' => array('year' => '2nd', 'semester' => 'I'),
        '2nd|I' => array('year' => '2nd', 'semester' => 'II'),
        '2nd|II' => array('year' => '2nd', 'semester' => 'III'),
        '2nd|III' => array('year' => '3rd', 'semester' => 'I'),
        '3rd|I' => array('year' => '3rd', 'semester' => 'II'),
        '3rd|II' => array('year' => '3rd', 'semester' => 'III'),
    );

    $key = trim($year) . '|' . trim($semester);
    return $map[$key] ?? null;
}

$department = isset($_SESSION['dpt']) ? trim((string) $_SESSION['dpt']) : '';
$year = isset($_SESSION['yea']) ? trim((string) $_SESSION['yea']) : '';
$semester = isset($_SESSION['sem']) ? trim((string) $_SESSION['sem']) : '';

if ($department === '' || $year === '' || $semester === '') {
    registrarUpdateAllFlash('Select the student group first before using Update All.', 'error');
    header("location:studentlist.php");
    exit;
}

$nextStage = registrarUpdateAllNextStage($year, $semester);
if ($nextStage === null) {
    registrarUpdateAllFlash('The selected year and semester do not have a configured next stage for bulk update.', 'error');
    header("location:studentlist.php");
    exit;
}

$countStmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS total
     FROM student
     WHERE Department = ?
       AND year = ?
       AND semister = ?
       AND unread = 'yes'"
);

$updateStmt = mysqli_prepare(
    $conn,
    "UPDATE student
     SET year = ?, semister = ?
     WHERE Department = ?
       AND year = ?
       AND semister = ?
       AND unread = 'yes'"
);

if (!$countStmt || !$updateStmt) {
    if ($countStmt) {
        mysqli_stmt_close($countStmt);
    }
    if ($updateStmt) {
        mysqli_stmt_close($updateStmt);
    }

    registrarUpdateAllFlash('The bulk update action could not be prepared. Please check the database connection and try again.', 'error');
    header("location:studentlist.php");
    exit;
}

mysqli_stmt_bind_param($countStmt, 'sss', $department, $year, $semester);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$eligibleCount = 0;
if ($countResult instanceof mysqli_result) {
    $row = mysqli_fetch_assoc($countResult);
    $eligibleCount = (int) ($row['total'] ?? 0);
    mysqli_free_result($countResult);
}
mysqli_stmt_close($countStmt);

if ($eligibleCount < 1) {
    mysqli_stmt_close($updateStmt);
    registrarUpdateAllFlash('No student records are currently marked as ready for bulk update in this class group.', 'info');
    header("location:studentlist.php");
    exit;
}

mysqli_stmt_bind_param(
    $updateStmt,
    'sssss',
    $nextStage['year'],
    $nextStage['semester'],
    $department,
    $year,
    $semester
);

$updated = mysqli_stmt_execute($updateStmt);
$affected = $updated ? mysqli_stmt_affected_rows($updateStmt) : 0;
$error = $updated ? '' : mysqli_stmt_error($updateStmt);
mysqli_stmt_close($updateStmt);

if (!$updated) {
    registrarUpdateAllFlash('Bulk update failed. ' . $error, 'error');
    header("location:studentlist.php");
    exit;
}

$_SESSION['yea'] = $nextStage['year'];
$_SESSION['sem'] = $nextStage['semester'];

registrarUpdateAllFlash(
    $affected . ' student record(s) were updated successfully to ' . $nextStage['year'] . ' year, semester ' . $nextStage['semester'] . '.',
    'success'
);
header("location:studentlist.php");
exit;
