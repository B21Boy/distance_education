<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
require_once(__DIR__ . "/../connection.php");
require_once(__DIR__ . "/page_helpers.php");

departmentRequireLogin();

function departmentAssignRedirect(string $status): void
{
    header("Location: manageinst.php?status=" . rawurlencode($status));
    exit;
}

function departmentAssignClientIp(): string
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
    departmentAssignRedirect('');
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

    if (
        $courseCode === '' || $courseName === '' || $instructorId === '' || $departmentName === '' ||
        $section === '' || $studentClassYear === '' || $semester === '' || $creditHour === '' || $academicYear === ''
    ) {
        departmentAssignRedirect('empty');
    }

    $courseStmt = mysqli_prepare($conn, "SELECT course_code, cname, chour, ayear, department FROM course WHERE course_code = ? LIMIT 1");
    if (!$courseStmt) {
        departmentAssignRedirect('error');
    }

    mysqli_stmt_bind_param($courseStmt, 's', $courseCode);
    mysqli_stmt_execute($courseStmt);
    mysqli_stmt_bind_result($courseStmt, $dbCourseCode, $dbCourseName, $dbCreditHour, $dbAcademicYear, $dbDepartmentName);
    $courseFound = mysqli_stmt_fetch($courseStmt);
    mysqli_stmt_close($courseStmt);

    if (!$courseFound) {
        departmentAssignRedirect('invalid-course');
    }

    $courseName = (string) $dbCourseName;
    $departmentName = trim((string) $dbDepartmentName);
    $creditHourValue = (int) $dbCreditHour;
    $academicYearValue = (int) $dbAcademicYear;

    $instructorStmt = mysqli_prepare($conn, "SELECT fname, lname FROM user WHERE UID = ? LIMIT 1");
    if (!$instructorStmt) {
        departmentAssignRedirect('error');
    }

    mysqli_stmt_bind_param($instructorStmt, 's', $instructorId);
    mysqli_stmt_execute($instructorStmt);
    mysqli_stmt_bind_result($instructorStmt, $instructorFirstName, $instructorLastName);
    $instructorFound = mysqli_stmt_fetch($instructorStmt);
    mysqli_stmt_close($instructorStmt);

    if (!$instructorFound) {
        departmentAssignRedirect('invalid-instructor');
    }

    $instructorName = trim((string) $instructorFirstName . ' ' . $instructorLastName);

    $existingStmt = mysqli_prepare($conn, "SELECT no FROM assign_instructor WHERE corse_code = ? LIMIT 1");
    if (!$existingStmt) {
        departmentAssignRedirect('error');
    }

    mysqli_stmt_bind_param($existingStmt, 's', $courseCode);
    mysqli_stmt_execute($existingStmt);
    mysqli_stmt_store_result($existingStmt);
    $alreadyAssigned = mysqli_stmt_num_rows($existingStmt) > 0;
    mysqli_stmt_close($existingStmt);

    if ($alreadyAssigned) {
        departmentAssignRedirect('already-assigned');
    }

    $insertStmt = mysqli_prepare(
        $conn,
        "INSERT INTO assign_instructor (corse_code, cname, chour, uid, Iname, department, section, Student_class_year, semister, ayear)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    if (!$insertStmt) {
        departmentAssignRedirect('error');
    }

    mysqli_stmt_bind_param(
        $insertStmt,
        'ssissssssi',
        $courseCode,
        $courseName,
        $creditHourValue,
        $instructorId,
        $instructorName,
        $departmentName,
        $section,
        $studentClassYear,
        $semester,
        $academicYearValue
    );
    $assigned = mysqli_stmt_execute($insertStmt);
    mysqli_stmt_close($insertStmt);

    if (!$assigned) {
        departmentAssignRedirect('error');
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
    $activityType = 'Assign course to instructor';
    $dateValue = date('Y-m-d');
    $ipAddress = departmentAssignClientIp();
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

    departmentAssignRedirect('assigned');
} catch (Throwable $e) {
    departmentAssignRedirect('error');
}
