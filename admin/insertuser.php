<?php
session_start();
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function redirect_add_user($type, $message)
{
    $_SESSION[$type] = $message;
    header('Location: adduser.php');
    exit;
}

function client_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
}

function upload_error_message($code)
{
    $messages = array(
        UPLOAD_ERR_INI_SIZE => 'Photo size exceeds the server upload limit.',
        UPLOAD_ERR_FORM_SIZE => 'Photo size should not be greater than 2 MB!',
        UPLOAD_ERR_PARTIAL => 'Photo upload was interrupted. Please try again.',
        UPLOAD_ERR_NO_TMP_DIR => 'Temporary upload folder is missing on the server.',
        UPLOAD_ERR_CANT_WRITE => 'Unable to write the uploaded photo to disk.',
        UPLOAD_ERR_EXTENSION => 'The photo upload was stopped by a server extension.',
    );

    return isset($messages[$code]) ? $messages[$code] : 'Unable to upload the selected photo.';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_add_user('flash_error', 'Invalid request.');
}

$uid = trim((string) ($_POST['uid'] ?? ''));
$fname = trim((string) ($_POST['fname'] ?? ''));
$lname = trim((string) ($_POST['lname'] ?? ''));
$sex = trim((string) ($_POST['sex'] ?? ''));
$phone = preg_replace('/\s+/', '', trim((string) ($_POST['phone'] ?? '')));
$email = trim((string) ($_POST['email'] ?? ''));
$loc = trim((string) ($_POST['loc'] ?? ''));
$role = trim((string) ($_POST['ct'] ?? ''));
$cCode = trim((string) ($_POST['ac'] ?? ''));
$dCode = trim((string) ($_POST['dc'] ?? ''));

if ($uid === '' || $fname === '' || $lname === '' || $sex === '' || $phone === '' || $email === '' || $loc === '' || $role === '') {
    redirect_add_user('flash_error', 'Please fill in all required fields.');
}

if (!preg_match('/^[A-Za-z0-9]{2,20}$/', $uid)) {
    redirect_add_user('flash_error', 'User ID must contain only letters and numbers and be 2 to 20 characters long.');
}
if (!preg_match('/^[A-Za-z ]{2,30}$/', $fname)) {
    redirect_add_user('flash_error', 'First name must contain only letters and spaces.');
}
if (!preg_match('/^[A-Za-z ]{2,30}$/', $lname)) {
    redirect_add_user('flash_error', 'Last name must contain only letters and spaces.');
}
if ($sex !== 'male' && $sex !== 'female') {
    redirect_add_user('flash_error', 'Please select a valid sex value.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_add_user('flash_error', 'Please enter a valid email address.');
}
if (!preg_match('/^[0-9+]{10,20}$/', $phone)) {
    redirect_add_user('flash_error', 'Phone number must be 10 to 20 characters long and use only numbers or +.');
}
if (!preg_match('/^[A-Za-z0-9 .,-]{2,50}$/', $loc)) {
    redirect_add_user('flash_error', 'Location contains unsupported characters.');
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
    redirect_add_user('flash_error', 'Please select a valid user type.');
}

if ($role === 'collage_dean' || $role === 'department_head' || $role === 'instructor') {
    if ($cCode === '') {
        redirect_add_user('flash_error', "Please select the user's college.");
    }
}
if ($role === 'department_head' || $role === 'instructor') {
    if ($dCode === '') {
        redirect_add_user('flash_error', "Please select the user's department.");
    }
}
if (!($role === 'department_head' || $role === 'instructor')) {
    $dCode = '';
}
if (!($role === 'collage_dean' || $role === 'department_head' || $role === 'instructor')) {
    $cCode = '';
}

$photoPath = 'userphoto/img1.jpg';
$uploadedPhotoPath = '';

try {
    $conn->set_charset('utf8mb4');

    $duplicateStmt = $conn->prepare('SELECT UID FROM user WHERE UID = ? LIMIT 1');
    $duplicateStmt->bind_param('s', $uid);
    $duplicateStmt->execute();
    $duplicateStmt->store_result();
    $userExists = $duplicateStmt->num_rows > 0;
    $duplicateStmt->close();
    if ($userExists) {
        redirect_add_user('flash_error', 'This user ID already exists.');
    }

    if ($cCode !== '') {
        $collegeStmt = $conn->prepare('SELECT Ccode FROM collage WHERE Ccode = ? LIMIT 1');
        $collegeStmt->bind_param('s', $cCode);
        $collegeStmt->execute();
        $collegeStmt->store_result();
        $collegeExists = $collegeStmt->num_rows > 0;
        $collegeStmt->close();
        if (!$collegeExists) {
            redirect_add_user('flash_error', 'The selected college was not found in the database.');
        }
    }

    if ($dCode !== '') {
        $departmentStmt = $conn->prepare('SELECT Dcode FROM department WHERE Dcode = ? AND Ccode = ? LIMIT 1');
        $departmentStmt->bind_param('ss', $dCode, $cCode);
        $departmentStmt->execute();
        $departmentStmt->store_result();
        $departmentExists = $departmentStmt->num_rows > 0;
        $departmentStmt->close();
        if (!$departmentExists) {
            redirect_add_user('flash_error', 'The selected department does not belong to the selected college.');
        }
    }

    if (isset($_FILES['photo']) && isset($_FILES['photo']['error']) && (int) $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadError = (int) $_FILES['photo']['error'];
        if ($uploadError !== UPLOAD_ERR_OK) {
            redirect_add_user('flash_error', upload_error_message($uploadError));
        }

        $tmpLocation = isset($_FILES['photo']['tmp_name']) ? (string) $_FILES['photo']['tmp_name'] : '';
        $fileSize = isset($_FILES['photo']['size']) ? (int) $_FILES['photo']['size'] : 0;
        if ($tmpLocation === '' || !is_uploaded_file($tmpLocation)) {
            redirect_add_user('flash_error', 'Uploaded photo could not be verified.');
        }
        if ($fileSize > 2000000) {
            redirect_add_user('flash_error', 'Photo size should not be greater than 2 MB!');
        }

        $imageInfo = @getimagesize($tmpLocation);
        if ($imageInfo === false || empty($imageInfo['mime'])) {
            redirect_add_user('flash_error', 'Uploaded file is not a valid image.');
        }

        $mime = (string) $imageInfo['mime'];
        $allowedMimeTypes = array(
            'image/jpeg' => 'jpg',
            'image/pjpeg' => 'jpg',
            'image/png' => 'png',
        );
        if (!isset($allowedMimeTypes[$mime])) {
            redirect_add_user('flash_error', 'Photo should be in JPEG or PNG format.');
        }

        $uploadDir = __DIR__ . '/userphoto';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            redirect_add_user('flash_error', 'Unable to create the photo upload directory.');
        }

        $safeUid = preg_replace('/[^A-Za-z0-9]/', '', $uid);
        $newFileName = 'user_' . $safeUid . '_' . time() . '.' . $allowedMimeTypes[$mime];
        $uploadedPhotoPath = $uploadDir . '/' . $newFileName;
        if (!move_uploaded_file($tmpLocation, $uploadedPhotoPath)) {
            redirect_add_user('flash_error', 'Unable to upload the photo.');
        }
        $photoPath = 'userphoto/' . $newFileName;
    }

    $conn->begin_transaction();

    $userStmt = $conn->prepare(
        'INSERT INTO user (UID, fname, lname, sex, Email, phone_No, location, photo, d_code, c_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?, ""), ?)'
    );
    $userStmt->bind_param('ssssssssss', $uid, $fname, $lname, $sex, $email, $phone, $loc, $photoPath, $dCode, $cCode);
    $userStmt->execute();
    $userStmt->close();

    $actualTime = date('d M Y @ H:i:s');
    $activityDate = date('Y-m-d');
    $actor = isset($_SESSION['suid']) && $_SESSION['suid'] !== '' ? (string) $_SESSION['suid'] : 'Admin';
    $status = 'yes';
    $activityType = 'add user';
    $activityPerformed = sprintf(
        'uid[%s] first_name[%s] last_name[%s] sex[%s] phone[%s] role[%s]',
        $uid,
        $fname,
        $lname,
        $sex,
        $phone,
        $role
    );
    $logEnd = '';
    $ipAddress = client_ip_address();
    $roleLabel = 'system admin';

    $logStmt = $conn->prepare(
        'INSERT INTO logfile (username, role, status, start_time, activity_type, activity_performed, date, ip_address, end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $logStmt->bind_param('sssssssss', $actor, $roleLabel, $status, $actualTime, $activityType, $activityPerformed, $activityDate, $ipAddress, $logEnd);
    $logStmt->execute();
    $logStmt->close();

    $conn->commit();
    redirect_add_user('flash_success', 'Your Information Is Successfully Registered !!!');
} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $rollbackError) {
    }

    if ($uploadedPhotoPath !== '' && is_file($uploadedPhotoPath)) {
        @unlink($uploadedPhotoPath);
    }

    $errorMessage = trim($e->getMessage());
    error_log('admin/insertuser.php failed: ' . $errorMessage);

    if ($e instanceof mysqli_sql_exception && (int) $e->getCode() === 1062) {
        redirect_add_user('flash_error', 'This user ID already exists.');
    }
    if (stripos($errorMessage, 'phone_No') !== false) {
        redirect_add_user('flash_error', 'The phone number format is not accepted. Use digits only or the full +251 format.');
    }
    if (stripos($errorMessage, 'd_code') !== false) {
        redirect_add_user('flash_error', 'The selected department could not be saved. Please choose a valid department.');
    }

    redirect_add_user('flash_error', 'Unable to register the user.');
}
?>
