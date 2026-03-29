<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

departmentRequireLogin();

function departmentUpdateRedirect(string $status, string $departmentCode = ''): void
{
    if ($departmentCode === '') {
        $departmentCode = departmentCurrentDepartmentCode();
    }

    $location = 'viewassigndinst.php';
    if ($departmentCode !== '') {
        $location .= '?id=' . rawurlencode($departmentCode);
        if ($status !== '') {
            $location .= '&status=' . rawurlencode($status);
        }
    } elseif ($status !== '') {
        $location .= '?status=' . rawurlencode($status);
    }

    header('Location: ' . $location);
    exit;
}

function departmentUpdateClientIp(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwardedIps = explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim((string) ($forwardedIps[0] ?? ''));
    }
    return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    departmentUpdateRedirect('');
}

try {
    $courseCode = trim((string) ($_POST['cc'] ?? ''));
    $courseName = trim((string) ($_POST['cn'] ?? ''));
    $instructorId = trim((string) ($_POST['In'] ?? ''));
    $departmentName = trim((string) ($_POST['dc'] ?? ''));
    $section = trim((string) ($_POST['sec'] ?? ''));
    $studentClassYear = trim((string) ($_POST['scy'] ?? ''));
    $semester = trim((string) ($_POST['sem'] ?? ''));
    $creditHour = trim((string) ($_POST['ch'] ?? ''));
    $academicYear = trim((string) ($_POST['ay'] ?? ''));
    $userId = departmentCurrentUserId();
    $departmentCode = departmentCurrentDepartmentCode();

    if (
        $courseCode === '' || $courseName === '' || $instructorId === '' || $departmentName === '' ||
        $section === '' || $studentClassYear === '' || $semester === '' || $creditHour === '' || $academicYear === ''
    ) {
        departmentUpdateRedirect('empty', $departmentCode);
    }

    $assignmentStmt = mysqli_prepare($conn, "SELECT no FROM assign_instructor WHERE corse_code = ? LIMIT 1");
    if (!$assignmentStmt) {
        departmentUpdateRedirect('error', $departmentCode);
    }

    mysqli_stmt_bind_param($assignmentStmt, 's', $courseCode);
    mysqli_stmt_execute($assignmentStmt);
    mysqli_stmt_store_result($assignmentStmt);
    $assignmentExists = mysqli_stmt_num_rows($assignmentStmt) > 0;
    mysqli_stmt_close($assignmentStmt);

    if (!$assignmentExists) {
        departmentUpdateRedirect('not-found', $departmentCode);
    }

    $courseStmt = mysqli_prepare($conn, "SELECT department, chour, ayear FROM course WHERE course_code = ? LIMIT 1");
    if (!$courseStmt) {
        departmentUpdateRedirect('error', $departmentCode);
    }

    mysqli_stmt_bind_param($courseStmt, 's', $courseCode);
    mysqli_stmt_execute($courseStmt);
    mysqli_stmt_bind_result($courseStmt, $dbDepartmentName, $dbCreditHour, $dbAcademicYear);
    $courseFound = mysqli_stmt_fetch($courseStmt);
    mysqli_stmt_close($courseStmt);

    if (!$courseFound) {
        departmentUpdateRedirect('invalid-course', $departmentCode);
    }

    if ($departmentCode === '') {
        $departmentLookupStmt = mysqli_prepare($conn, "SELECT Dcode FROM department WHERE DName = ? LIMIT 1");
        if ($departmentLookupStmt) {
            mysqli_stmt_bind_param($departmentLookupStmt, 's', $dbDepartmentName);
            mysqli_stmt_execute($departmentLookupStmt);
            mysqli_stmt_bind_result($departmentLookupStmt, $resolvedDepartmentCode);
            if (mysqli_stmt_fetch($departmentLookupStmt)) {
                $departmentCode = trim((string) $resolvedDepartmentCode);
            }
            mysqli_stmt_close($departmentLookupStmt);
        }
    }

    $instructorStmt = mysqli_prepare($conn, "SELECT fname, lname FROM user WHERE UID = ? LIMIT 1");
    if (!$instructorStmt) {
        departmentUpdateRedirect('error', $departmentCode);
    }

    mysqli_stmt_bind_param($instructorStmt, 's', $instructorId);
    mysqli_stmt_execute($instructorStmt);
    mysqli_stmt_bind_result($instructorStmt, $instructorFirstName, $instructorLastName);
    $instructorFound = mysqli_stmt_fetch($instructorStmt);
    mysqli_stmt_close($instructorStmt);

    if (!$instructorFound) {
        departmentUpdateRedirect('invalid-instructor', $departmentCode);
    }

    $instructorName = trim((string) $instructorFirstName . ' ' . $instructorLastName);

    $updateStmt = mysqli_prepare(
        $conn,
        "UPDATE assign_instructor
         SET uid = ?, Iname = ?, department = ?, section = ?, Student_class_year = ?, semister = ?
         WHERE corse_code = ?"
    );
    if (!$updateStmt) {
        departmentUpdateRedirect('error', $departmentCode);
    }

    mysqli_stmt_bind_param(
        $updateStmt,
        'sssssss',
        $instructorId,
        $instructorName,
        $departmentName,
        $section,
        $studentClassYear,
        $semester,
        $courseCode
    );
    $updated = mysqli_stmt_execute($updateStmt);
    mysqli_stmt_close($updateStmt);

    if (!$updated) {
        departmentUpdateRedirect('error', $departmentCode);
    }

    $role = '';
    if ($userId !== '') {
        $roleStmt = mysqli_prepare($conn, "SELECT Role FROM account WHERE UID = ? LIMIT 1");
        if ($roleStmt) {
            mysqli_stmt_bind_param($roleStmt, 's', $userId);
            if (mysqli_stmt_execute($roleStmt)) {
                mysqli_stmt_bind_result($roleStmt, $roleValue);
                if (mysqli_stmt_fetch($roleStmt)) {
                    $role = (string) $roleValue;
                }
            }
            mysqli_stmt_close($roleStmt);
        }
    }

    $status = 'yes';
    $actualTime = date('d M Y @ H:i:s');
    $activityPerformed = "uid[{$userId}] role[{$role}] status[{$status}]";
    $activityType = 'Update course instructor assignment';
    $dateValue = date('Y-m-d');
    $ipAddress = departmentUpdateClientIp();
    $username = 'depthead';
    $defaultRole = 'Department_Head';
    $endValue = '';

    $logStmt = mysqli_prepare(
        $conn,
        "INSERT INTO logfile (username, role, status, start_time, activity_type, activity_performed, date, ip_address, end)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    if ($logStmt) {
        mysqli_stmt_bind_param(
            $logStmt,
            'sssssssss',
            $username,
            $defaultRole,
            $status,
            $actualTime,
            $activityType,
            $activityPerformed,
            $dateValue,
            $ipAddress,
            $endValue
        );
        @mysqli_stmt_execute($logStmt);
        mysqli_stmt_close($logStmt);
    }

    departmentUpdateRedirect('updated', $departmentCode);
} catch (Throwable $e) {
    departmentUpdateRedirect('error', departmentCurrentDepartmentCode());
}
?>
