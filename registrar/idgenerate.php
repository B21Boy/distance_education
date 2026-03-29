<?php
session_start();
require_once("../connection.php");

function registrarGenerateIdPrefix(string $department): string
{
    $department = strtolower(trim($department));
    $map = array(
        'accounting' => 'ACC/',
        'law' => 'LAW/',
        'economics' => 'ECNS/',
        'managament' => 'MNGT/',
        'management' => 'MNGT/',
    );

    if (isset($map[$department])) {
        return $map[$department];
    }

    $letters = preg_replace('/[^A-Z]/', '', strtoupper($department));
    $letters = substr(str_pad($letters, 4, 'X'), 0, 4);
    return $letters . '/';
}

function registrarGenerateIdFlash(string $message, string $class): void
{
    $_SESSION['generateclass_status'] = array(
        'message' => $message,
        'class' => $class,
    );
}

$department = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
if ($department === '' && isset($_SESSION['idsec'])) {
    $department = trim((string) $_SESSION['idsec']);
}

if ($department === '') {
    registrarGenerateIdFlash('Select a department first before generating student IDs.', 'error');
    header("location:generateid.php");
    exit;
}

$_SESSION['idsec'] = $department;

$studentStmt = mysqli_prepare(
    $conn,
    "SELECT s.S_ID, s.FName
     FROM student s
     WHERE s.Department = ?
       AND s.year = '1st'
       AND s.semister = 'I'
       AND TRIM(s.section) <> ''
       AND COALESCE(TRIM(s.status), '') <> 'ok'
       AND EXISTS (
            SELECT 1
            FROM entrance_exam ee
            WHERE ee.S_ID = s.S_ID
              AND ee.status = 'satisfactory'
       )
     ORDER BY s.section ASC, s.FName ASC, s.S_ID ASC"
);

if (!$studentStmt) {
    registrarGenerateIdFlash('The database connection is available, but the student list could not be prepared for ID generation.', 'error');
    header("location:generateclass.php");
    exit;
}

mysqli_stmt_bind_param($studentStmt, 's', $department);
mysqli_stmt_execute($studentStmt);
$studentResult = mysqli_stmt_get_result($studentStmt);

$students = array();
if ($studentResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($studentResult)) {
        $students[] = $row;
    }
    mysqli_free_result($studentResult);
}
mysqli_stmt_close($studentStmt);

if (empty($students)) {
    registrarGenerateIdFlash('No students are ready for ID generation in the selected department.', 'info');
    header("location:generateclass.php");
    exit;
}

$prefix = registrarGenerateIdPrefix($department);
$yearSuffix = (string) (((int) date('y')) - 8);
$nextSequence = 1;

$existingStmt = mysqli_prepare($conn, "SELECT S_ID FROM student WHERE Department = ? AND S_ID LIKE ? ORDER BY S_ID ASC");
if ($existingStmt) {
    $likePattern = $prefix . '%';
    mysqli_stmt_bind_param($existingStmt, 'ss', $department, $likePattern);
    mysqli_stmt_execute($existingStmt);
    $existingResult = mysqli_stmt_get_result($existingStmt);

    if ($existingResult instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($existingResult)) {
            $existingId = trim((string) ($row['S_ID'] ?? ''));
            if (preg_match('#^' . preg_quote($prefix, '#') . '(\d{4})/\d{2}$#', $existingId, $matches)) {
                $nextSequence = max($nextSequence, ((int) $matches[1]) + 1);
            }
        }
        mysqli_free_result($existingResult);
    }

    mysqli_stmt_close($existingStmt);
}

$updateEntranceStmt = mysqli_prepare($conn, "UPDATE entrance_exam SET S_ID = ? WHERE S_ID = ? AND status = 'satisfactory'");
$updateStudentStmt = mysqli_prepare($conn, "UPDATE student SET S_ID = ?, status = 'ok' WHERE S_ID = ?");
$updateUserStmt = mysqli_prepare($conn, "UPDATE user SET UID = ? WHERE UID = ?");
$updateAccountStmt = mysqli_prepare($conn, "UPDATE account SET UID = ? WHERE UID = ?");

if (!$updateEntranceStmt || !$updateStudentStmt || !$updateUserStmt || !$updateAccountStmt) {
    if ($updateEntranceStmt) {
        mysqli_stmt_close($updateEntranceStmt);
    }
    if ($updateStudentStmt) {
        mysqli_stmt_close($updateStudentStmt);
    }
    if ($updateUserStmt) {
        mysqli_stmt_close($updateUserStmt);
    }
    if ($updateAccountStmt) {
        mysqli_stmt_close($updateAccountStmt);
    }

    registrarGenerateIdFlash('The ID generation process could not start because one or more database statements failed to prepare.', 'error');
    header("location:generateclass.php");
    exit;
}

$generatedCount = 0;
mysqli_begin_transaction($conn);

try {
    foreach ($students as $student) {
        $oldId = trim((string) ($student['S_ID'] ?? ''));
        if ($oldId === '') {
            continue;
        }

        $newId = $prefix . str_pad((string) $nextSequence, 4, '0', STR_PAD_LEFT) . '/' . $yearSuffix;
        $nextSequence++;

        mysqli_stmt_bind_param($updateEntranceStmt, 'ss', $newId, $oldId);
        if (!mysqli_stmt_execute($updateEntranceStmt)) {
            throw new RuntimeException(mysqli_stmt_error($updateEntranceStmt));
        }

        mysqli_stmt_bind_param($updateStudentStmt, 'ss', $newId, $oldId);
        if (!mysqli_stmt_execute($updateStudentStmt)) {
            throw new RuntimeException(mysqli_stmt_error($updateStudentStmt));
        }

        mysqli_stmt_bind_param($updateUserStmt, 'ss', $newId, $oldId);
        if (!mysqli_stmt_execute($updateUserStmt)) {
            throw new RuntimeException(mysqli_stmt_error($updateUserStmt));
        }

        mysqli_stmt_bind_param($updateAccountStmt, 'ss', $newId, $oldId);
        if (!mysqli_stmt_execute($updateAccountStmt)) {
            throw new RuntimeException(mysqli_stmt_error($updateAccountStmt));
        }

        $generatedCount++;
    }

    if (!mysqli_commit($conn)) {
        throw new RuntimeException(mysqli_error($conn));
    }

    registrarGenerateIdFlash($generatedCount . ' student ID number(s) were generated successfully.', 'success');
} catch (Throwable $exception) {
    mysqli_rollback($conn);
    registrarGenerateIdFlash('ID generation failed. ' . trim($exception->getMessage()), 'error');
}

mysqli_stmt_close($updateEntranceStmt);
mysqli_stmt_close($updateStudentStmt);
mysqli_stmt_close($updateUserStmt);
mysqli_stmt_close($updateAccountStmt);

header("location:generateclass.php");
exit;
