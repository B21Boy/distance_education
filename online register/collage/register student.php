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

$tx_ref = trim($_GET['tx_ref'] ?? '');
$paymentRecord = null;
$message = '';
$message_class = '';
$allowRegistration = false;
$isCompletedRedirect = (trim($_GET['status'] ?? '') === 'completed');

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
    } elseif ($paymentRecord['status'] === 'success') {
        $allowRegistration = true;
    } elseif ($isCompletedRedirect) {
        // In local/test this block should allow registration to avoid callback unreliability.
        $isTestEnv = strpos($otpConfig['chapa']['secret_key'], 'TEST') !== false;
        if ($isTestEnv) {
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
                $message = 'Payment still not successful. Please complete payment again or retry.';
                $message_class = 'error';
                $allowRegistration = false;
            }
        }
    } else {
        $message = 'Payment is not marked successful yet. Please wait for confirmation or retry.';
        $message_class = 'error';
        $allowRegistration = false;
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
    $unread = 'yes';
    $status = 'active';

    if (!$sid || !$fname || !$lname || !$email || !$phone || !$college || !$department) {
        $message = 'Please complete required fields: ID, First name, Last name, Email, Phone, College, Department.';
        $message_class = 'error';
    } else {
        $stmt = $conn->prepare('INSERT INTO student (S_ID, FName, mname, LName, Sex, Email, Phone_No, College, Department, year, section, semister, program, Location, Education_level, Date, unread, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssssssssssssssss', $sid, $fname, $mname, $lname, $sex, $email, $phone, $college, $department, $year, $section, $semester, $program, $location, $education_level, $date, $unread, $status);

        if ($stmt->execute()) {
            $message = 'Student registered successfully.';
            $message_class = 'success';
            // Clear form values on success
            $sid = $fname = $mname = $lname = $sex = $email = $phone = $college = $department = $year = $section = $semester = $program = $location = $education_level = $date = '';
        } else {
            $message = 'Student registration failed: ' . $stmt->error;
            $message_class = 'error';
        }

        $stmt->close();
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
.container { max-width: 900px; margin: 32px auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 12px; }
.form-row { display: grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap: 16px; margin-bottom: 16px; }
.form-row label { display: block; font-weight: 600; margin-bottom: 5px; }
.form-row input, .form-row select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px; }
.alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; }
.alert.error { background:#fdd; border:1px solid #f99; }
.alert.success { background:#dfd; border:1px solid #9f9; }
</style>
</head>
<body class="student-portal-page">
<div class="container">
    <h1>Student Registration</h1>
    <p>After successful payment, complete student details and submit to register.</p>

    <?php if ($message) : ?>
        <div class="alert <?php echo htmlspecialchars($message_class); ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!$paymentRecord || !$allowRegistration): ?>
        <p>Error: no successful payment found for this transaction reference.</p>
        <p><a href="departmentlist.php">Go back and try again</a></p>
    <?php else: ?>
        <form method="post" action="">
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
                    <label for="year">Year</label>
                    <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year ?? '1'); ?>">
                </div>
                <div>
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" value="<?php echo htmlspecialchars($section ?? 'A'); ?>">
                </div>
                <div>
                    <label for="semister">Semester</label>
                    <input type="text" id="semister" name="semister" value="<?php echo htmlspecialchars($semester ?? '1'); ?>">
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="program">Program</label>
                    <input type="text" id="program" name="program" value="<?php echo htmlspecialchars($program ?? ''); ?>">
                </div>
                <div>
                    <label for="Location">Location</label>
                    <input type="text" id="Location" name="Location" value="<?php echo htmlspecialchars($location ?? ''); ?>">
                </div>
                <div>
                    <label for="Education_level">Education Level</label>
                    <input type="text" id="Education_level" name="Education_level" value="<?php echo htmlspecialchars($education_level ?? ''); ?>">
                </div>
                <div>
                    <label for="Date">Date</label>
                    <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>">
                </div>
            </div>

            <div style="margin-top:18px;">
                <button type="submit">Register Student</button>
            </div>
        </form>
    <?php endif; ?>

    <p style="margin-top: 20px;"><a href="departmentlist.php">Back to college & department</a></p>
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
