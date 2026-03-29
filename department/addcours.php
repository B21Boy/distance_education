<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
require_once(__DIR__ . "/../connection.php");
require_once(__DIR__ . "/page_helpers.php");

departmentRequireLogin();

function departmentCourseRedirect(string $status): void
{
    header("Location: managecourse.php?status=" . rawurlencode($status));
    exit;
}

function departmentClientIp(): string
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

function departmentCourseHasColumn(mysqli $conn, string $columnName): bool
{
    $safeColumn = mysqli_real_escape_string($conn, $columnName);
    $result = mysqli_query($conn, "SHOW COLUMNS FROM course LIKE '{$safeColumn}'");
    if (!$result instanceof mysqli_result) {
        return false;
    }

    $hasColumn = mysqli_num_rows($result) > 0;
    mysqli_free_result($result);
    return $hasColumn;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    departmentCourseRedirect('');
}
try {
    $courseCode = strtoupper(trim((string) ($_POST['cd'] ?? '')));
    $courseName = trim((string) ($_POST['cn'] ?? ''));
    $creditHour = trim((string) ($_POST['ch'] ?? ''));
    $academicYear = trim((string) ($_POST['ayear'] ?? ''));
    $departmentName = trim((string) ($_POST['dc'] ?? ''));
    $userId = departmentCurrentUserId();
    $canonicalDepartmentName = departmentCurrentDepartmentName($conn);

    if ($canonicalDepartmentName !== '') {
        $departmentName = $canonicalDepartmentName;
    } elseif ($departmentName === '') {
        $departmentName = departmentCurrentDepartmentCode();
    }

    if ($courseCode === '' || $courseName === '' || $creditHour === '' || $academicYear === '' || $departmentName === '') {
        departmentCourseRedirect('empty');
    }

    if (!preg_match('/^[A-Z0-9-]+$/', $courseCode)) {
        departmentCourseRedirect('invalid-code');
    }

    if (!is_numeric($creditHour) || (int) $creditHour <= 0) {
        departmentCourseRedirect('invalid-credit');
    }

    if (!preg_match('/^\d{4}$/', $academicYear)) {
        departmentCourseRedirect('invalid-year');
    }

    $duplicateStmt = mysqli_prepare($conn, "SELECT 1 FROM course WHERE course_code = ? OR cname = ? LIMIT 1");
    if (!$duplicateStmt) {
        departmentCourseRedirect('error');
    }

    mysqli_stmt_bind_param($duplicateStmt, 'ss', $courseCode, $courseName);
    $duplicateExecuted = mysqli_stmt_execute($duplicateStmt);
    $alreadyExists = false;
    if ($duplicateExecuted) {
        mysqli_stmt_store_result($duplicateStmt);
        $alreadyExists = mysqli_stmt_num_rows($duplicateStmt) > 0;
    }
    mysqli_stmt_close($duplicateStmt);

    if ($alreadyExists) {
        departmentCourseRedirect('exists');
    }

    $courseColumns = [
        'Sender_name' => $userId !== '' ? $userId : 'depthead',
        'course_code' => $courseCode,
        'cname' => $courseName,
        'chour' => (int) $creditHour,
        's_c_year' => '',
        'semister' => '',
        'ayear' => (int) $academicYear,
        'department' => $departmentName,
        'FileName' => '',
        'status' => 'yes',
        'unread' => ''
    ];

    if (departmentCourseHasColumn($conn, 'other_department_takes')) {
        $courseColumns['other_department_takes'] = '';
    }

    $orderedColumnNames = [];
    $orderedValues = [];
    foreach ($courseColumns as $columnName => $columnValue) {
        if ($columnName === 'other_department_takes' || departmentCourseHasColumn($conn, $columnName)) {
            $orderedColumnNames[] = $columnName;
            $orderedValues[] = $columnValue;
        }
    }

    if (!$orderedColumnNames) {
        departmentCourseRedirect('error');
    }

    $placeholders = implode(', ', array_fill(0, count($orderedColumnNames), '?'));
    $columnSql = implode(', ', $orderedColumnNames);
    $insertStmt = mysqli_prepare($conn, "INSERT INTO course ({$columnSql}) VALUES ({$placeholders})");
    if (!$insertStmt) {
        departmentCourseRedirect('error');
    }

    $bindTypes = '';
    $bindValues = [];
    foreach ($orderedValues as $value) {
        if (is_int($value)) {
            $bindTypes .= 'i';
        } else {
            $bindTypes .= 's';
        }
        $bindValues[] = $value;
    }

    mysqli_stmt_bind_param($insertStmt, $bindTypes, ...$bindValues);
    $saved = mysqli_stmt_execute($insertStmt);
    $insertError = mysqli_stmt_error($insertStmt);
    mysqli_stmt_close($insertStmt);

    if (!$saved) {
        if (stripos($insertError, 'duplicate') !== false) {
            departmentCourseRedirect('exists');
        }
        departmentCourseRedirect('error');
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
    $activityType = 'Add course';
    $dateValue = date('y-m-d');
    $ipAddress = departmentClientIp();
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

    departmentCourseRedirect('success');
} catch (Throwable $e) {
    departmentCourseRedirect('error');
}
