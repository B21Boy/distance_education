<?php
session_start();
require_once('../connection.php');
require_once('page_helpers.php');

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$filter = isset($_SESSION['sendstudentlist_filter']) && is_array($_SESSION['sendstudentlist_filter'])
    ? $_SESSION['sendstudentlist_filter']
    : array();

$department = trim((string) ($filter['department'] ?? ($_SESSION['ddd'] ?? '')));
$year = trim((string) ($filter['year'] ?? '1st'));
$semester = trim((string) ($filter['semester'] ?? 'I'));

if ($department === '' || $year !== '1st' || $semester !== 'I') {
    $_SESSION['sendstudentlist_status'] = array(
        'message' => 'Select first-year semester-I students first before sending them to the system administrator.',
        'class' => 'error',
    );
    header("location:sendstudentlist.php");
    exit;
}

$countStmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS total
     FROM student s
     WHERE s.Department = ?
       AND s.year = ?
       AND s.semister = ?
       AND COALESCE(TRIM(s.unread), '') <> 'no'
       AND NOT EXISTS (SELECT 1 FROM user u WHERE u.UID = s.S_ID)
       AND NOT EXISTS (SELECT 1 FROM account a WHERE a.UID = s.S_ID)"
);

$updateStmt = mysqli_prepare(
    $conn,
    "UPDATE student s
     SET s.unread = 'no'
     WHERE s.Department = ?
       AND s.year = ?
       AND s.semister = ?
       AND COALESCE(TRIM(s.unread), '') <> 'no'
       AND NOT EXISTS (SELECT 1 FROM user u WHERE u.UID = s.S_ID)
       AND NOT EXISTS (SELECT 1 FROM account a WHERE a.UID = s.S_ID)"
);

if (!$countStmt || !$updateStmt) {
    if ($countStmt) {
        mysqli_stmt_close($countStmt);
    }
    if ($updateStmt) {
        mysqli_stmt_close($updateStmt);
    }

    $_SESSION['sendstudentlist_status'] = array(
        'message' => 'The student-send action could not be prepared. Please check the database connection and try again.',
        'class' => 'error',
    );
    header("location:sendstudentlist.php");
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
    $_SESSION['sendstudentlist_status'] = array(
        'message' => 'No additional students are ready to send to the system administrator right now.',
        'class' => 'info',
    );
    header("location:sendstudentlist.php");
    exit;
}

mysqli_stmt_bind_param($updateStmt, 'sss', $department, $year, $semester);
$updated = mysqli_stmt_execute($updateStmt);
$affected = $updated ? mysqli_stmt_affected_rows($updateStmt) : 0;
mysqli_stmt_close($updateStmt);

if ($updated) {
    $_SESSION['sendstudentlist_status'] = array(
        'message' => $affected . ' student record(s) were sent to the system administrator account queue successfully.',
        'class' => 'success',
    );
} else {
    $_SESSION['sendstudentlist_status'] = array(
        'message' => 'The student-send action failed. ' . mysqli_error($conn),
        'class' => 'error',
    );
}

header("location:sendstudentlist.php");
exit;
