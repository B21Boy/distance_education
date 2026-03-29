<?php
session_start();
include(__DIR__ . '/../connection.php');

function admin_generate_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function admin_generate_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
}

function admin_generate_slug($value)
{
    $value = strtolower(trim((string) $value));
    $value = preg_replace('/[^a-z0-9]/', '', $value);

    return $value === null ? '' : $value;
}

function admin_generate_temp_password($firstName, $studentId)
{
    $namePart = admin_generate_slug($firstName);
    if ($namePart === '') {
        $namePart = admin_generate_slug($studentId);
    }
    if ($namePart === '') {
        $namePart = 'student';
    }

    return 'cde' . substr($namePart, 0, 10) . '123#';
}

function admin_generate_unique_username(mysqli $conn, array &$reservedUsernames, $firstName, $lastName, $studentId)
{
    $seed = admin_generate_slug($firstName);
    if ($seed === '') {
        $seed = admin_generate_slug($lastName);
    }
    if ($seed === '') {
        $seed = admin_generate_slug($studentId);
    }
    if ($seed === '') {
        $seed = 'stud';
    }

    $seed = substr($seed, 0, 5);
    if ($seed === '') {
        $seed = 'stud';
    }

    $tail = admin_generate_slug($studentId);
    $tail = $tail !== '' ? substr($tail, -3) : '001';

    $firstCandidate = substr($seed . $tail, 0, 8);
    if (!isset($reservedUsernames[$firstCandidate])) {
        $reservedUsernames[$firstCandidate] = true;
        return $firstCandidate;
    }

    for ($counter = 1; $counter <= 999; $counter++) {
        $candidate = substr($seed, 0, 5) . str_pad((string) $counter, 3, '0', STR_PAD_LEFT);
        if (!isset($reservedUsernames[$candidate])) {
            $reservedUsernames[$candidate] = true;
            return $candidate;
        }
    }

    throw new RuntimeException('Unable to generate a unique username for student ' . $studentId . '.');
}

function admin_generate_log_bulk_activity(mysqli $conn, $createdCount, $processedCount)
{
    if ($createdCount < 1) {
        return;
    }

    $actor = isset($_SESSION['suid']) && $_SESSION['suid'] !== '' ? (string) $_SESSION['suid'] : 'Admin';
    $roleLabel = 'system admin';
    $status = 'yes';
    $startTime = date('d M Y @ H:i:s');
    $activityType = 'bulk create student account';
    $activityPerformed = sprintf('created[%d] processed[%d]', $createdCount, $processedCount);
    $activityDate = date('Y-m-d');
    $ipAddress = admin_generate_client_ip();
    $endTime = '';

    $logStmt = $conn->prepare('INSERT INTO logfile (username, role, status, start_time, activity_type, activity_performed, date, ip_address, end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    if (!($logStmt instanceof mysqli_stmt)) {
        return;
    }

    $logStmt->bind_param('sssssssss', $actor, $roleLabel, $status, $startTime, $activityType, $activityPerformed, $activityDate, $ipAddress, $endTime);
    $logStmt->execute();
    $logStmt->close();
}

$results = array();
$createdCount = 0;
$existingCount = 0;
$syncedCount = 0;
$failedCount = 0;
$pendingCount = 0;
$pageError = '';

if (!isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole'])) {
    header('location:../index.php');
    exit;
}

if (!($conn instanceof mysqli)) {
    $pageError = 'Database connection is not available.';
} else {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn->set_charset('utf8mb4');

        $pendingSql = "
            SELECT
                s.S_ID,
                s.FName,
                s.LName,
                s.Sex,
                s.Email,
                s.Phone_No,
                s.Department,
                COALESCE(d.Dcode, '') AS d_code,
                COALESCE(d.Ccode, '') AS c_code,
                u.UID AS existing_user_uid,
                a.UID AS existing_account_uid,
                a.UserName AS existing_username
            FROM student AS s
            LEFT JOIN department AS d
                ON LOWER(TRIM(d.DName)) = LOWER(TRIM(s.Department))
            LEFT JOIN user AS u
                ON u.UID = s.S_ID
            LEFT JOIN account AS a
                ON a.UID = s.S_ID
            WHERE s.unread = 'no'
            ORDER BY s.Department ASC, s.S_ID ASC
        ";

        $pendingResult = $conn->query($pendingSql);
        $pendingStudents = array();
        while ($row = $pendingResult->fetch_assoc()) {
            $pendingStudents[] = $row;
        }
        $pendingResult->free();
        $pendingCount = count($pendingStudents);

        $reservedUsernames = array();
        $usernameResult = $conn->query('SELECT UserName FROM account');
        while ($usernameRow = $usernameResult->fetch_assoc()) {
            $existingUsername = trim((string) ($usernameRow['UserName'] ?? ''));
            if ($existingUsername !== '') {
                $reservedUsernames[$existingUsername] = true;
            }
        }
        $usernameResult->free();

        $defaultLocation = 'Distance Student';
        $defaultPhoto = 'userphoto/img1.jpg';
        $insertUserStmt = $conn->prepare('INSERT INTO user (UID, fname, lname, sex, Email, phone_No, location, photo, d_code, c_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULLIF(?, ""), ?)');
        $insertAccountStmt = $conn->prepare("INSERT INTO account (UID, UserName, Password, Role, status) VALUES (?, ?, ?, 'student', 'yes')");
        $markProcessedStmt = $conn->prepare("UPDATE student SET unread = 'yes' WHERE S_ID = ?");

        foreach ($pendingStudents as $student) {
            $studentId = trim((string) ($student['S_ID'] ?? ''));
            $firstName = trim((string) ($student['FName'] ?? ''));
            $lastName = trim((string) ($student['LName'] ?? ''));
            $sex = trim((string) ($student['Sex'] ?? ''));
            $email = trim((string) ($student['Email'] ?? ''));
            $phone = trim((string) ($student['Phone_No'] ?? ''));
            $department = trim((string) ($student['Department'] ?? ''));
            $dCode = trim((string) ($student['d_code'] ?? ''));
            $cCode = trim((string) ($student['c_code'] ?? ''));
            $hasUser = trim((string) ($student['existing_user_uid'] ?? '')) !== '';
            $hasAccount = trim((string) ($student['existing_account_uid'] ?? '')) !== '';
            $existingUsername = trim((string) ($student['existing_username'] ?? ''));

            $status = 'Failed';
            $note = '';
            $username = '';
            $password = '';

            try {
                if ($studentId === '') {
                    throw new RuntimeException('Student ID is missing.');
                }
                if ($dCode === '' || $cCode === '') {
                    throw new RuntimeException('Department mapping is missing for "' . $department . '".');
                }

                $conn->begin_transaction();

                if (!$hasUser) {
                    $insertUserStmt->bind_param('ssssssssss', $studentId, $firstName, $lastName, $sex, $email, $phone, $defaultLocation, $defaultPhoto, $dCode, $cCode);
                    $insertUserStmt->execute();
                }

                if ($hasAccount) {
                    $markProcessedStmt->bind_param('s', $studentId);
                    $markProcessedStmt->execute();
                    $conn->commit();

                    if ($hasUser) {
                        $status = 'Exists';
                        $note = $existingUsername !== ''
                            ? 'Account already exists with username "' . $existingUsername . '".'
                            : 'Account already exists for this student.';
                        $existingCount++;
                    } else {
                        $status = 'Synced';
                        $note = $existingUsername !== ''
                            ? 'Missing user profile was added. Existing account "' . $existingUsername . '" was kept.'
                            : 'Missing user profile was added. Existing account was kept.';
                        $syncedCount++;
                    }
                } else {
                    $username = admin_generate_unique_username($conn, $reservedUsernames, $firstName, $lastName, $studentId);
                    $password = admin_generate_temp_password($firstName, $studentId);

                    $insertAccountStmt->bind_param('sss', $studentId, $username, $password);
                    $insertAccountStmt->execute();

                    $markProcessedStmt->bind_param('s', $studentId);
                    $markProcessedStmt->execute();

                    $conn->commit();

                    $status = 'Created';
                    $note = 'Student account was created successfully.';
                    $createdCount++;
                }
            } catch (Throwable $e) {
                try {
                    $conn->rollback();
                } catch (Throwable $rollbackError) {
                }

                $failedCount++;
                $status = 'Failed';
                $note = trim($e->getMessage()) !== '' ? trim($e->getMessage()) : 'Unexpected error occurred.';
                error_log('admin/generatepassword.php failed for student ' . $studentId . ': ' . $note);
            }

            $results[] = array(
                'student_id' => $studentId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'department' => $department,
                'username' => $username,
                'password' => $password,
                'status' => $status,
                'note' => $note,
            );
        }

        $insertUserStmt->close();
        $insertAccountStmt->close();
        $markProcessedStmt->close();

        admin_generate_log_bulk_activity($conn, $createdCount, $pendingCount);
    } catch (Throwable $e) {
        $pageError = trim($e->getMessage()) !== '' ? trim($e->getMessage()) : 'Unable to generate student accounts right now.';
        error_log('admin/generatepassword.php page error: ' . $pageError);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<script src="../javascript/date_time.js"></script>
<style>
.generate-shell {
    display: grid;
    gap: 20px;
}
.generate-card {
    background: linear-gradient(180deg, #f7fbff 0%, #edf4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 18px 40px rgba(14, 42, 70, 0.08);
}
.generate-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}
.generate-kicker {
    display: inline-flex;
    align-items: center;
    min-height: 28px;
    padding: 0 12px;
    border-radius: 999px;
    background: #d9e9fb;
    color: #1a4f82;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.generate-title {
    margin: 10px 0 8px;
    color: #12395f;
    font-size: 28px;
}
.generate-copy {
    margin: 0;
    max-width: 760px;
    color: #4b6783;
    line-height: 1.6;
}
.generate-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.generate-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    padding: 0 18px;
    border: 0;
    border-radius: 12px;
    background: #1f6fb2;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}
.generate-btn.secondary {
    background: #e3edf7;
    color: #174a7c;
}
.generate-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 16px;
}
.generate-stat {
    padding: 18px;
    border-radius: 16px;
    background: #ffffff;
    border: 1px solid #d7e5f2;
}
.generate-stat span {
    display: block;
    margin-bottom: 6px;
    color: #68829b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.generate-stat strong {
    color: #163b60;
    font-size: 26px;
}
.generate-note {
    margin: 0;
    color: #5f7892;
    line-height: 1.6;
}
.generate-table-wrap {
    overflow-x: auto;
}
.generate-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
}
.generate-table th,
.generate-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #e2ebf3;
    text-align: left;
    vertical-align: top;
}
.generate-table th {
    background: #eef5fb;
    color: #174a7c;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.generate-table tbody tr:nth-child(even) {
    background: #fbfdff;
}
.generate-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.generate-status.created {
    background: #e6f7ee;
    color: #17613a;
}
.generate-status.exists {
    background: #fff4d8;
    color: #8f5f05;
}
.generate-status.synced {
    background: #e4f0ff;
    color: #1f5b98;
}
.generate-status.failed {
    background: #fdeaea;
    color: #9f2f2f;
}
.generate-empty {
    padding: 18px;
    border-radius: 14px;
    background: #ffffff;
    border: 1px dashed #c8d9ea;
    color: #4e6883;
}
@media (max-width: 720px) {
    .generate-card {
        padding: 18px;
    }
    .generate-title {
        font-size: 23px;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="generate-shell">
                    <div class="generate-card">
                        <div class="generate-header">
                            <div>
                                <span class="generate-kicker">Admin</span>
                                <h1 class="generate-title">Student Account Generation</h1>
                                <p class="generate-copy">This page processes every student currently waiting in the admin request list, creates missing login records, and shows the generated credentials immediately after the run.</p>
                            </div>
                            <div class="generate-actions">
                                <a href="studentlist.php" class="generate-btn secondary">Back to Student List</a>
                                <?php if (!empty($results)) { ?>
                                <button type="button" class="generate-btn" onclick="window.print()">Print Result</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($pageError !== '') { ?>
                    <div class="generate-card">
                        <div class="generate-empty"><?php echo admin_generate_h($pageError); ?></div>
                    </div>
                    <?php } else { ?>
                    <div class="generate-card">
                        <div class="generate-stats">
                            <div class="generate-stat">
                                <span>Pending Students</span>
                                <strong><?php echo $pendingCount; ?></strong>
                            </div>
                            <div class="generate-stat">
                                <span>Accounts Created</span>
                                <strong><?php echo $createdCount; ?></strong>
                            </div>
                            <div class="generate-stat">
                                <span>Already Existing</span>
                                <strong><?php echo $existingCount; ?></strong>
                            </div>
                            <div class="generate-stat">
                                <span>User Profiles Synced</span>
                                <strong><?php echo $syncedCount; ?></strong>
                            </div>
                            <div class="generate-stat">
                                <span>Failed Rows</span>
                                <strong><?php echo $failedCount; ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="generate-card">
                        <?php if (empty($results)) { ?>
                        <div class="generate-empty">No students are waiting for bulk account creation right now.</div>
                        <?php } else { ?>
                        <p class="generate-note">Temporary passwords are shown only for accounts created in this run. If you need to hand them over now, print this page before leaving it.</p>
                        <div class="generate-table-wrap">
                            <table class="generate-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Username</th>
                                        <th>Temporary Password</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $row) {
                                        $statusClass = strtolower((string) $row['status']);
                                        if (!in_array($statusClass, array('created', 'exists', 'synced', 'failed'), true)) {
                                            $statusClass = 'failed';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo admin_generate_h($row['student_id']); ?></td>
                                        <td><?php echo admin_generate_h(trim($row['first_name'] . ' ' . $row['last_name'])); ?></td>
                                        <td><?php echo admin_generate_h($row['department']); ?></td>
                                        <td><?php echo admin_generate_h($row['username'] !== '' ? $row['username'] : '-'); ?></td>
                                        <td><?php echo admin_generate_h($row['password'] !== '' ? $row['password'] : '-'); ?></td>
                                        <td><span class="generate-status <?php echo admin_generate_h($statusClass); ?>"><?php echo admin_generate_h($row['status']); ?></span></td>
                                        <td><?php echo admin_generate_h($row['note']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require('rightsidebar.php'); ?></div>
    </div>
    <div id="footer"><?php include('../footer.php'); ?></div>
</div>
</body>
</html>
