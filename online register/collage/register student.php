<?php
session_start();
include __DIR__ . '/../../connection.php';
$otpConfig = require __DIR__ . '/../otp_config.php';

function chapaVerifyStatus($tx_ref, $secretKey) {
    $apiUrl = 'https://api.chapa.co/v1/transaction/verify/' . urlencode($tx_ref);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $secretKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        return 'failed';
    }

    $data = json_decode($response, true);
    if (!$data || !isset($data['data']['status'])) {
        return 'failed';
    }

    return $data['data']['status'];
}

function parseRawQueryParams() {
    $query = $_SERVER['QUERY_STRING'] ?? '';
    if (strpos($query, '&amp;') !== false) {
        $query = str_replace('&amp;', '&', $query);
    }

    $params = [];
    parse_str($query, $params);
    return $params;
}

function ensureNewStudentTableExists($conn) {
    $createTableSql = "CREATE TABLE IF NOT EXISTS `newstudent` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `S_ID` VARCHAR(50) NOT NULL,
        `FName` VARCHAR(150) NOT NULL,
        `mname` VARCHAR(150) DEFAULT NULL,
        `LName` VARCHAR(150) NOT NULL,
        `Sex` VARCHAR(20) DEFAULT NULL,
        `Email` VARCHAR(200) NOT NULL,
        `Phone_No` VARCHAR(50) NOT NULL,
        `College` VARCHAR(200) NOT NULL,
        `Department` VARCHAR(200) NOT NULL,
        `year` VARCHAR(50) DEFAULT NULL,
        `section` VARCHAR(50) DEFAULT NULL,
        `semister` VARCHAR(50) DEFAULT NULL,
        `program` VARCHAR(100) NOT NULL DEFAULT 'Degree',
        `Location` VARCHAR(200) DEFAULT NULL,
        `Education_level` VARCHAR(100) DEFAULT NULL,
        `Date` DATE DEFAULT NULL,
        `unread` VARCHAR(20) NOT NULL DEFAULT 'yes',
        `status` VARCHAR(50) NOT NULL DEFAULT 'active',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uniq_S_ID` (`S_ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $conn->query($createTableSql);
}

$tx_ref = trim($_GET['tx_ref'] ?? '');
$status = trim($_GET['status'] ?? '');
if (empty($tx_ref) || $status === '') {
    $rawParams = parseRawQueryParams();
    if (empty($tx_ref) && !empty($rawParams['tx_ref'])) {
        $tx_ref = trim($rawParams['tx_ref']);
    }
    if ($status === '' && isset($rawParams['status'])) {
        $status = trim($rawParams['status']);
    }
}

$paymentRecord = null;
$message = '';
$message_class = '';
$allowRegistration = false;
$isCompletedRedirect = ($status === 'completed');

if ($tx_ref) {
    $stmt = $conn->prepare('SELECT status, department_code, department_name, phone_number FROM applicant_payments WHERE tx_ref = ?');
    $stmt->bind_param('s', $tx_ref);
    $stmt->execute();
    $res = $stmt->get_result();
    $paymentRecord = $res ? $res->fetch_assoc() : null;
    $stmt->close();

    if (!$paymentRecord) {
        $message = 'Payment record not found. Please complete payment first.';
        $message_class = 'error';
    } else {
        if ($paymentRecord['status'] === 'success') {
            $allowRegistration = true;
        } else {
            $isTestEnv = strpos($otpConfig['chapa']['secret_key'], 'TEST') !== false;
            if ($isTestEnv && $isCompletedRedirect) {
                $allowRegistration = true;
                $message = 'Test mode: payment redirect completed; registration is now allowed.';
                $message_class = 'success';
                $stmt = $conn->prepare('UPDATE applicant_payments SET status = ? WHERE tx_ref = ?');
                $success = 'success';
                $stmt->bind_param('ss', $success, $tx_ref);
                $stmt->execute();
                $stmt->close();
            } else {
                $chapaStatus = chapaVerifyStatus($tx_ref, $otpConfig['chapa']['secret_key']);
                if ($chapaStatus === 'success') {
                    $allowRegistration = true;
                    $message = 'Payment confirmed via Chapa verify API. Registration is now allowed.';
                    $message_class = 'success';
                    $stmt = $conn->prepare('UPDATE applicant_payments SET status = ? WHERE tx_ref = ?');
                    $success = 'success';
                    $stmt->bind_param('ss', $success, $tx_ref);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $message = 'Payment is not yet successful. Please check your payment or try again.';
                    $message_class = 'error';
                    $allowRegistration = false;
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = trim($_POST['S_ID'] ?? '');
    $fname = trim($_POST['FName'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $lname = trim($_POST['LName'] ?? '');
    $sex = trim($_POST['Sex'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $phone = preg_replace('/[^0-9]/', '', trim($_POST['Phone_No'] ?? ''));
    $college = trim($_POST['College'] ?? '');
    $department = trim($_POST['Department'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $section = trim($_POST['section'] ?? '');
    $semester = trim($_POST['semister'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $location = trim($_POST['Location'] ?? '');
    $education_level = trim($_POST['Education_level'] ?? '');
    $date = trim($_POST['Date'] ?? date('Y-m-d'));

    if ($program === '') {
        $program = 'Degree';
    }
    $unread = 'yes';
    $status = 'active';
    $document_path = '';
    $photo_path = '';

    $uploadedDocument = $_FILES['document_file'] ?? null;
    $uploadedStudentImage = $_FILES['student_image'] ?? null;
    $allowedDocumentMimeTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $allowedImageMimeTypes = ['image/jpeg', 'image/png'];
    $maxFileSize = 5 * 1024 * 1024; // 5 MB

    if ($uploadedDocument && $uploadedDocument['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($uploadedDocument['error'] !== UPLOAD_ERR_OK) {
            $message = 'Document upload failed. Please try again.';
            $message_class = 'error';
        } else {
            $mimeType = mime_content_type($uploadedDocument['tmp_name']);
            $fileSize = (int) $uploadedDocument['size'];
            $extension = strtolower(pathinfo($uploadedDocument['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

            if (!in_array($mimeType, $allowedMimeTypes, true) || !in_array($extension, $allowedExtensions, true)) {
                $message = 'Invalid document format. Please upload PDF, JPG, JPEG, or PNG only.';
                $message_class = 'error';
                $uploadedDocument = null;
            } elseif ($fileSize > $maxFileSize) {
                $message = 'File is too large. Maximum allowed size is 5 MB.';
                $message_class = 'error';
                $uploadedDocument = null;
            } else {
                $uploadDir = __DIR__ . '/uploads/student_documents';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($uploadedDocument['name']));
                $uniqueName = time() . '_' . preg_replace('/\s+/', '_', $safeName);
                $destination = $uploadDir . '/' . $uniqueName;

                if (move_uploaded_file($uploadedDocument['tmp_name'], $destination)) {
                    $document_path = 'online register/collage/uploads/student_documents/' . $uniqueName;
                } else {
                    $message = 'Unable to save the uploaded document. Please try again.';
                    $message_class = 'error';
                    $uploadedDocument = null;
                }
            }
        }
    }

    if ($uploadedStudentImage && $uploadedStudentImage['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($uploadedStudentImage['error'] !== UPLOAD_ERR_OK) {
            $message = 'Photo upload failed. Please try again.';
            $message_class = 'error';
        } else {
            $mimeType = mime_content_type($uploadedStudentImage['tmp_name']);
            $fileSize = (int) $uploadedStudentImage['size'];
            $extension = strtolower(pathinfo($uploadedStudentImage['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($mimeType, $allowedImageMimeTypes, true) || !in_array($extension, $allowedExtensions, true)) {
                $message = 'Invalid photo format. Please upload JPG, JPEG, or PNG only.';
                $message_class = 'error';
                $uploadedStudentImage = null;
            } elseif ($fileSize > $maxFileSize) {
                $message = 'Photo is too large. Maximum allowed size is 5 MB.';
                $message_class = 'error';
                $uploadedStudentImage = null;
            } else {
                $uploadDir = __DIR__ . '/uploads/student_photos';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($uploadedStudentImage['name']));
                $uniqueName = time() . '_' . preg_replace('/\s+/', '_', $safeName);
                $destination = $uploadDir . '/' . $uniqueName;

                if (move_uploaded_file($uploadedStudentImage['tmp_name'], $destination)) {
                    $photo_path = 'online register/collage/uploads/student_photos/' . $uniqueName;
                } else {
                    $message = 'Unable to save the uploaded photo. Please try again.';
                    $message_class = 'error';
                    $uploadedStudentImage = null;
                }
            }
        }
    }

    if (!$message) {
        if (!$sid || !$fname || !$lname || !$email || !$phone || !$college || !$department) {
            $message = 'Please complete required fields: ID, First name, Last name, Email, Phone, College, Department.';
            $message_class = 'error';
        } elseif (!preg_match('/^[A-Za-z0-9]{4,20}$/', $sid)) {
            $message = 'Student ID must be 4-20 characters long and contain only letters and numbers.';
            $message_class = 'error';
        } elseif (!DateTime::createFromFormat('Y-m-d', $date) || DateTime::createFromFormat('Y-m-d', $date)->format('Y-m-d') !== $date) {
            $message = 'Invalid date format. Please use YYYY-MM-DD.';
            $message_class = 'error';
        } else {
            ensureNewStudentTableExists($conn);
            $stmt = $conn->prepare('INSERT INTO newstudent (S_ID, FName, mname, LName, Sex, Email, Phone_No, College, Department, year, section, semister, program, Location, Education_level, Date, unread, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssssssssssssssss', $sid, $fname, $mname, $lname, $sex, $email, $phone, $college, $department, $year, $section, $semester, $program, $location, $education_level, $date, $unread, $status);

            if ($stmt->execute()) {
                $message = 'New student registered successfully.';
                if ($document_path) {
                    $message .= ' Document uploaded successfully.';
                }
                $message_class = 'success';
                $sid = $fname = $mname = $lname = $sex = $email = $phone = $college = $department = $year = $section = $semester = $program = $location = $education_level = $date = '';
            } else {
                $message = 'Student registration failed: ' . $stmt->error;
                $message_class = 'error';
            }

            $stmt->close();
        }
    }
}

$defaultCollege = $paymentRecord['department_code'] ?? '';
$defaultDepartment = $paymentRecord['department_name'] ?? '';
$defaultPhone = $paymentRecord['phone_number'] ?? '';

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration</title>
<link rel="stylesheet" href="../online.css">
<style>
:root {
    color-scheme: light;
    font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #102a43;
    background: #eef4fb;
}
* {
    box-sizing: border-box;
}
body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(180deg, #e8f1ff 0%, #f7fbff 100%);
    line-height: 1.6;
}
.container {
    max-width: 1040px;
    margin: 36px auto 48px;
    padding: 32px 32px 28px;
    background: rgba(255,255,255,0.98);
    border: 1px solid rgba(32, 84, 179, 0.08);
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(29, 79, 173, 0.08);
}
.page-title {
    margin: 0 0 10px;
    font-size: clamp(2rem, 2.4vw, 2.5rem);
    letter-spacing: -0.04em;
}
.page-copy {
    margin: 0 0 28px;
    max-width: 760px;
    color: #445f7d;
    font-size: 1rem;
}
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 18px;
    margin-bottom: 18px;
}
.form-row > div {
    min-width: 0;
}
label {
    display: block;
    margin-bottom: 10px;
    color: #334e68;
    font-size: 0.92rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
input,
select {
    width: 100%;
    padding: 16px 18px;
    border: 1px solid #cbd7e9;
    border-radius: 16px;
    background: #f8fbff;
    color: #102a43;
    font-size: 1rem;
    transition: border-color 0.22s ease, box-shadow 0.22s ease, transform 0.22s ease;
}
input:focus,
select:focus {
    border-color: #4c8dff;
    box-shadow: 0 0 0 4px rgba(76, 141, 255, 0.14);
    outline: none;
    transform: translateY(-1px);
}
button[type="submit"] {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    border-radius: 18px;
    background: linear-gradient(135deg, #2d6cff 0%, #2fc8ff 100%);
    color: #ffffff;
    padding: 16px 28px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.22s ease, box-shadow 0.22s ease, opacity 0.22s ease;
}
button[type="submit"]:hover,
button[type="submit"]:focus-visible {
    transform: translateY(-1px);
    box-shadow: 0 16px 32px rgba(45, 108, 255, 0.18);
    opacity: 0.98;
}
.alert {
    padding: 18px 20px;
    border-radius: 18px;
    margin-bottom: 24px;
    font-size: 0.975rem;
}
.alert.error {
    background: #ffe3e3;
    border: 1px solid #f5b3b3;
    color: #7f1e1e;
}
.alert.success {
    background: #e6f9eb;
    border: 1px solid #97d5a4;
    color: #1f5d2f;
}
a.secondary-link {
    color: #2d6cff;
    font-weight: 600;
    text-decoration: none;
}
a.secondary-link:hover {
    text-decoration: underline;
}
.progress-footer {
    margin-top: 34px;
    padding: 20px 24px;
    background: rgba(45, 108, 255, 0.05);
    border-radius: 22px;
}
.progress-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}
.form-actions {
    margin-top: 22px;
}
.step-item {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    color: #ffffff;
    font-weight: 700;
    background: #cbd7e9;
}
.step-item.completed {
    background: #2d6cff;
}
.step-item.current {
    background: #15b5ff;
}
.connector {
    flex: 1;
    height: 4px;
    border-radius: 999px;
    background: #d8e5fb;
}
.connector.active {
    background: linear-gradient(90deg, #2d6cff 0%, #15b5ff 100%);
}
@media (max-width: 660px) {
    .container {
        margin: 24px 16px 32px;
        padding: 24px;
    }
    .page-copy {
        font-size: 0.98rem;
    }
}
</style>
</head>
<body class="student-portal-page">
<div class="container">
    <h1 class="page-title">Student Registration</h1>
    <p class="page-copy">After successful payment, complete the form below to finish student registration. All required fields are marked with *</p>
    <div class="page-copy" style="font-size:0.94rem; padding: 16px 0 0; color:#506d85;">
        <strong>High-level flow:</strong> required fields are checked first, document uploads are validated for type and size, and registration is saved only when the form passes basic validation.
    </div>

    <?php if ($message) : ?>
        <div class="alert <?php echo htmlspecialchars($message_class); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!$paymentRecord || !$allowRegistration): ?>
        <p>Error: no successful payment found for this transaction reference.</p>
        <p><a href="departmentlist.php">Go back and try again</a></p>
    <?php else: ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-row">
                <div>
                    <label for="S_ID">Student ID *</label>
                    <input type="text" id="S_ID" name="S_ID" value="<?php echo htmlspecialchars($tx_ref ?: ($sid ?? '')); ?>" required>
                </div>
                <div>
                    <label for="FName">First Name *</label>
                    <input type="text" id="FName" name="FName" value="<?php echo htmlspecialchars($fname ?? ''); ?>" required>
                </div>
                <div>
                    <label for="mname">Middle Name</label>
                    <input type="text" id="mname" name="mname" value="<?php echo htmlspecialchars($mname ?? ''); ?>">
                </div>
                <div>
                    <label for="LName">Last Name *</label>
                    <input type="text" id="LName" name="LName" value="<?php echo htmlspecialchars($lname ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="Sex">Sex</label>
                    <select id="Sex" name="Sex">
                        <option value="">--Select--</option>
                        <option value="Male" <?php echo (($sex ?? '') === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (($sex ?? '') === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo (($sex ?? '') === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div>
                    <label for="Email">Email *</label>
                    <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                <div>
                    <label for="Phone_No">Phone *</label>
                    <input type="text" id="Phone_No" name="Phone_No" value="<?php echo htmlspecialchars($phone ?? $defaultPhone); ?>" required>
                </div>
                <div>
                    <label for="College">College *</label>
                    <input type="text" id="College" name="College" value="<?php echo htmlspecialchars($college ?? $defaultCollege); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="Department">Department *</label>
                    <input type="text" id="Department" name="Department" value="<?php echo htmlspecialchars($department ?? $defaultDepartment); ?>" required>
                </div>
                <div>
                    <label for="Education_level">Education Level</label>
                    <input type="text" id="Education_level" name="Education_level" value="<?php echo htmlspecialchars($education_level ?? ''); ?>">
                </div>
                <div>
                    <label for="program">Program</label>
                    <input type="text" id="program" name="program" value="<?php echo htmlspecialchars($program ?? 'Degree'); ?>">
                </div>
                <div>
                    <label for="year">Year</label>
                    <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year ?? '1'); ?>">
                </div>
                <div>
                    <label for="semister">Semester</label>
                    <input type="text" id="semister" name="semister" value="<?php echo htmlspecialchars($semester ?? '1'); ?>">
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="Location">Location</label>
                    <input type="text" id="Location" name="Location" value="<?php echo htmlspecialchars($location ?? ''); ?>">
                </div>
                <div>
                    <label for="Date">Date</label>
                    <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>">
                </div>
                <div>
                    <label for="document_file">Upload Document</label>
                    <input type="file" id="document_file" name="document_file" accept=".pdf,image/png,image/jpeg">
                    <small style="display:block; margin-top:6px; color:#617d98;">PDF, JPG, JPEG, PNG. Max 5MB.</small>
                </div>
                <div>
                    <label for="student_image">Upload Photo</label>
                    <input type="file" id="student_image" name="student_image" accept="image/png,image/jpeg">
                    <small style="display:block; margin-top:6px; color:#617d98;">JPG, JPEG, PNG. Max 5MB.</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Register Student</button>
            </div>
        </form>
    <?php endif; ?>

    <p style="margin-top: 20px;"><a class="secondary-link" href="departmentlist.php">Back to college & department</a></p>
</div>

<footer class="progress-footer">
    <div class="progress-container">
        <div class="step-item completed" id="footer-step-1">1</div>
        <div class="connector active" id="connector-1"></div>
        <div class="step-item completed" id="footer-step-2">2</div>
        <div class="connector active" id="connector-2"></div>
        <div class="step-item current" id="footer-step-3">3</div>
    </div>
</footer>
</body>
</html>
