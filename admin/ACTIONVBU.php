<?php
session_start();
include(__DIR__ . '/../connection.php');

function admin_vbu_redirect($type, $message)
{
    header('Location: viewbuser.php?type=' . urlencode($type) . '&message=' . urlencode($message));
    exit;
}

function admin_vbu_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
}

if (!isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole'])) {
    header('location:../index.php');
    exit;
}

if (!($conn instanceof mysqli)) {
    admin_vbu_redirect('error', 'Database connection is not available.');
}

$uid = trim((string) ($_GET['status'] ?? ''));
if ($uid === '') {
    admin_vbu_redirect('error', 'Blocked user id is missing.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn->set_charset('utf8mb4');

    $selectStmt = $conn->prepare('SELECT status FROM account WHERE UID = ? LIMIT 1');
    $selectStmt->bind_param('s', $uid);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $row = $result->fetch_assoc();
    $selectStmt->close();

    if (!is_array($row)) {
        admin_vbu_redirect('error', 'The selected account was not found.');
    }

    $currentStatus = trim((string) ($row['status'] ?? ''));
    $nextStatus = $currentStatus === 'no' ? 'yes' : 'no';
    $activityType = $nextStatus === 'yes' ? 'unblock user' : 'block user';

    $conn->begin_transaction();

    $updateStmt = $conn->prepare('UPDATE account SET status = ? WHERE UID = ?');
    $updateStmt->bind_param('ss', $nextStatus, $uid);
    $updateStmt->execute();
    $updateStmt->close();

    $actor = isset($_SESSION['suid']) && $_SESSION['suid'] !== '' ? (string) $_SESSION['suid'] : 'Admin';
    $roleLabel = 'system admin';
    $logStatus = 'yes';
    $startTime = date('d M Y @ H:i:s');
    $activityPerformed = sprintf('uid[%s] status[%s]', $uid, $nextStatus);
    $activityDate = date('Y-m-d');
    $ipAddress = admin_vbu_client_ip();
    $endTime = '';

    $logStmt = $conn->prepare('INSERT INTO logfile (username, role, status, start_time, activity_type, activity_performed, date, ip_address, end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $logStmt->bind_param('sssssssss', $actor, $roleLabel, $logStatus, $startTime, $activityType, $activityPerformed, $activityDate, $ipAddress, $endTime);
    $logStmt->execute();
    $logStmt->close();

    $conn->commit();
    admin_vbu_redirect('success', $nextStatus === 'yes' ? 'User account unblocked successfully.' : 'User account blocked successfully.');
} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $rollbackError) {
    }

    $errorMessage = trim($e->getMessage());
    error_log('admin/ACTIONVBU.php failed: ' . $errorMessage);
    admin_vbu_redirect('error', 'Unable to update the blocked user record.');
}
?>
