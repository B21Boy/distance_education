<?php
session_start();
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function redirect_add_account($type, $message)
{
    $_SESSION[$type] = $message;
    header('Location: addaccount.php');
    exit;
}

function account_client_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_add_account('flash_error', 'Invalid request.');
}

$uid = trim((string) ($_POST['uid'] ?? ''));
$username = trim((string) ($_POST['un'] ?? ''));
$password = trim((string) ($_POST['pass'] ?? ''));
$role = trim((string) ($_POST['role'] ?? ''));
$status = 'yes';

if ($uid === '' || $username === '' || $password === '' || $role === '') {
    redirect_add_account('flash_error', 'Please fill in all required account fields.');
}
if (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
    redirect_add_account('flash_error', 'Username must be 3 to 50 characters long and use only letters, numbers, dot, underscore, or hyphen.');
}
if (strlen($password) < 4 || strlen($password) > 50) {
    redirect_add_account('flash_error', 'Password must be between 4 and 50 characters long.');
}

$allowedRoles = array(
    'administrator',
    'cdeofficer',
    'registrar',
    'collage_dean',
    'department_head',
    'instructor',
    'financestaff',
    'acadamic_vice_presidant',
);
if (!in_array($role, $allowedRoles, true)) {
    redirect_add_account('flash_error', 'Please select a valid role.');
}

try {
    $conn->set_charset('utf8mb4');

    $userStmt = $conn->prepare('SELECT UID FROM user WHERE UID = ? LIMIT 1');
    $userStmt->bind_param('s', $uid);
    $userStmt->execute();
    $userStmt->store_result();
    $userExists = $userStmt->num_rows > 0;
    $userStmt->close();
    if (!$userExists) {
        redirect_add_account('flash_error', 'The selected user does not exist.');
    }

    $duplicateUidStmt = $conn->prepare('SELECT UID FROM account WHERE UID = ? LIMIT 1');
    $duplicateUidStmt->bind_param('s', $uid);
    $duplicateUidStmt->execute();
    $duplicateUidStmt->store_result();
    $uidExists = $duplicateUidStmt->num_rows > 0;
    $duplicateUidStmt->close();
    if ($uidExists) {
        redirect_add_account('flash_error', 'This user already has an account.');
    }

    $duplicateUserStmt = $conn->prepare('SELECT UID FROM account WHERE UserName = ? LIMIT 1');
    $duplicateUserStmt->bind_param('s', $username);
    $duplicateUserStmt->execute();
    $duplicateUserStmt->store_result();
    $usernameExists = $duplicateUserStmt->num_rows > 0;
    $duplicateUserStmt->close();
    if ($usernameExists) {
        redirect_add_account('flash_error', 'This username is already in use.');
    }

    $conn->begin_transaction();

    $accountStmt = $conn->prepare('INSERT INTO account (UID, UserName, Password, Role, status) VALUES (?, ?, ?, ?, ?)');
    $accountStmt->bind_param('sssss', $uid, $username, $password, $role, $status);
    $accountStmt->execute();
    $accountStmt->close();

    $actualTime = date('d M Y @ H:i:s');
    $activityDate = date('Y-m-d');
    $actor = isset($_SESSION['suid']) && $_SESSION['suid'] !== '' ? (string) $_SESSION['suid'] : 'Admin';
    $activityType = 'create account';
    $activityPerformed = sprintf('uid[%s] username[%s] role[%s] status[%s]', $uid, $username, $role, $status);
    $ipAddress = account_client_ip_address();
    $roleLabel = 'system admin';
    $logEnd = '';

    $logStmt = $conn->prepare('INSERT INTO logfile (username, role, status, start_time, activity_type, activity_performed, date, ip_address, end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $logStmt->bind_param('sssssssss', $actor, $roleLabel, $status, $actualTime, $activityType, $activityPerformed, $activityDate, $ipAddress, $logEnd);
    $logStmt->execute();
    $logStmt->close();

    $conn->commit();
    redirect_add_account('flash_success', 'Account created successfully.');
} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $rollbackError) {
    }

    $errorMessage = trim($e->getMessage());
    error_log('admin/insertaccount.php failed: ' . $errorMessage);

    if ($e instanceof mysqli_sql_exception && (int) $e->getCode() === 1062) {
        if (stripos($errorMessage, 'UserName') !== false) {
            redirect_add_account('flash_error', 'This username is already in use.');
        }
        redirect_add_account('flash_error', 'This user already has an account.');
    }

    redirect_add_account('flash_error', 'Unable to create the account.');
}
?>
