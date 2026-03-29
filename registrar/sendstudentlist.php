<?php
session_start();
require_once("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

function registrarSendStudentStatusMeta(array $student, bool $canSendAll): array
{
    $hasUser = !empty($student['has_user']);
    $hasAccount = !empty($student['has_account']);
    $unread = trim((string) ($student['unread'] ?? ''));

    if ($hasAccount) {
        return array('label' => 'Account Ready', 'class' => 'success');
    }

    if ($hasUser) {
        return array('label' => 'User Created', 'class' => 'info');
    }

    if ($canSendAll && $unread === 'no') {
        return array('label' => 'Queued For Admin', 'class' => 'info');
    }

    if ($canSendAll) {
        return array('label' => 'Pending Send', 'class' => 'warning');
    }

    return array('label' => 'Review', 'class' => 'neutral');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $_SESSION['sendstudentlist_filter'] = array(
        'department' => trim((string) ($_POST['dpt'] ?? '')),
        'year' => trim((string) ($_POST['scy'] ?? '')),
        'semester' => trim((string) ($_POST['sem'] ?? '')),
    );
}

$filter = isset($_SESSION['sendstudentlist_filter']) && is_array($_SESSION['sendstudentlist_filter'])
    ? $_SESSION['sendstudentlist_filter']
    : array();

$department = trim((string) ($filter['department'] ?? ''));
$year = trim((string) ($filter['year'] ?? ''));
$semester = trim((string) ($filter['semester'] ?? ''));

if ($department === '' || $year === '' || $semester === '') {
    header("location:viewstudent.php");
    exit;
}

if ($year === '1st' && $semester === 'I') {
    $_SESSION['ddd'] = $department;
}

$statusMessage = '';
$statusClass = 'info';
if (isset($_SESSION['sendstudentlist_status']) && is_array($_SESSION['sendstudentlist_status'])) {
    $statusMessage = trim((string) ($_SESSION['sendstudentlist_status']['message'] ?? ''));
    $statusClass = trim((string) ($_SESSION['sendstudentlist_status']['class'] ?? 'info'));
    unset($_SESSION['sendstudentlist_status']);
}

$students = array();
$pageError = '';
$totalCount = 0;
$sendReadyCount = 0;
$queuedCount = 0;
$accountReadyCount = 0;
$canSendAll = ($year === '1st' && $semester === 'I');

$studentStmt = mysqli_prepare(
    $conn,
    "SELECT s.S_ID, s.FName, s.LName, s.Sex, s.Email, s.Phone_No, s.College, s.Department, s.year, s.semister,
            COALESCE(NULLIF(TRIM(s.unread), ''), ' ') AS unread,
            CASE WHEN EXISTS (SELECT 1 FROM user u WHERE u.UID = s.S_ID) THEN 1 ELSE 0 END AS has_user,
            CASE WHEN EXISTS (SELECT 1 FROM account a WHERE a.UID = s.S_ID) THEN 1 ELSE 0 END AS has_account
     FROM student s
     WHERE s.Department = ?
       AND s.year = ?
       AND s.semister = ?
     ORDER BY s.S_ID ASC"
);

if (!$studentStmt) {
    $pageError = 'The student list could not be loaded right now. Please check the database connection and try again.';
} else {
    mysqli_stmt_bind_param($studentStmt, 'sss', $department, $year, $semester);
    mysqli_stmt_execute($studentStmt);
    $result = mysqli_stmt_get_result($studentStmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;

            $hasUser = !empty($row['has_user']);
            $hasAccount = !empty($row['has_account']);
            $unread = trim((string) ($row['unread'] ?? ''));

            if ($hasAccount) {
                $accountReadyCount++;
            } elseif ($canSendAll && $unread === 'no') {
                $queuedCount++;
            } elseif ($canSendAll) {
                $sendReadyCount++;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($studentStmt);
    $totalCount = count($students);
}

$photoPath = registrarCurrentPhotoPath();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
<style>
.registrar-studentlist-toolbar {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 20px;
}
.registrar-studentlist-chip-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.registrar-studentlist-chip {
    padding: 10px 14px;
    border-radius: 999px;
    background: #edf5ff;
    border: 1px solid #c6d8f0;
    color: #1b4f86;
    font-size: 14px;
    font-weight: 700;
}
.registrar-studentlist-chip strong {
    color: #143a64;
}
.registrar-studentlist-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.registrar-studentlist-stat {
    padding: 18px 20px;
    border-radius: 16px;
    border: 1px solid #dae4f0;
    background: linear-gradient(180deg, #fbfdff 0%, #eef5ff 100%);
}
.registrar-studentlist-stat span {
    display: block;
    color: #5f7893;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.registrar-studentlist-stat strong {
    display: block;
    margin-top: 8px;
    color: #173a63;
    font-size: 26px;
}
.registrar-studentlist-panel {
    padding: 22px;
    border-radius: 18px;
    border: 1px solid #d9e4f0;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(17, 52, 84, 0.08);
}
.registrar-studentlist-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: flex-start;
    margin-bottom: 18px;
}
.registrar-studentlist-title {
    margin: 0;
    color: #173a63;
    font-size: 22px;
}
.registrar-studentlist-copy {
    margin: 8px 0 0;
    color: #5d748e;
    font-size: 14px;
    line-height: 1.7;
    max-width: 820px;
}
.registrar-studentlist-table-wrap {
    width: 100%;
    overflow-x: auto;
}
.registrar-studentlist-table {
    width: 100%;
    min-width: 1080px;
    border-collapse: collapse;
}
.registrar-studentlist-table th,
.registrar-studentlist-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #e3ebf4;
    text-align: left;
    font-size: 14px;
}
.registrar-studentlist-table th {
    background: #ecf4ff;
    color: #173a63;
}
.registrar-studentlist-table tbody tr:nth-child(even) {
    background: #f9fbfe;
}
.registrar-studentlist-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 30px;
    padding: 0 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.registrar-studentlist-badge.success {
    background: #e8f7ea;
    color: #1e6a33;
}
.registrar-studentlist-badge.info {
    background: #e9f2ff;
    color: #1c4f84;
}
.registrar-studentlist-badge.warning {
    background: #fff3e2;
    color: #8b5a12;
}
.registrar-studentlist-badge.neutral {
    background: #eef2f6;
    color: #5f7082;
}
.registrar-btn-disabled {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 20px;
    border-radius: 12px;
    border: 1px solid #d9e2ec;
    background: #eef2f6;
    color: #6d7f92;
    font-size: 15px;
    font-weight: 700;
}
@media (max-width: 980px) {
    .registrar-studentlist-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 720px) {
    .registrar-studentlist-stats {
        grid-template-columns: 1fr;
    }
    .registrar-studentlist-toolbar,
    .registrar-studentlist-head {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Student Records</span>
                    <h1 class="registrar-page-title">Filtered Student List</h1>
                    <p class="registrar-page-copy">Review the selected student group and, for first-year semester-I students, send the eligible records to the system administrator account-creation queue.</p>
                </div>

                <?php if ($statusMessage !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($statusClass); ?>"><?php echo registrarH($statusMessage); ?></div>
                <?php endif; ?>

                <?php if ($pageError !== ''): ?>
                    <div class="registrar-status error"><?php echo registrarH($pageError); ?></div>
                <?php endif; ?>

                <div class="registrar-studentlist-toolbar">
                    <div class="registrar-studentlist-chip-row">
                        <div class="registrar-studentlist-chip"><strong>Department:</strong> <?php echo registrarH($department); ?></div>
                        <div class="registrar-studentlist-chip"><strong>Year:</strong> <?php echo registrarH($year); ?></div>
                        <div class="registrar-studentlist-chip"><strong>Semester:</strong> <?php echo registrarH($semester); ?></div>
                        <div class="registrar-studentlist-chip"><strong>Database:</strong> <?php echo $conn instanceof mysqli ? 'Connected' : 'Unavailable'; ?></div>
                    </div>
                    <div class="registrar-actions">
                        <a href="viewstudent.php" class="registrar-link-btn">Back</a>
                        <?php if ($canSendAll && $sendReadyCount > 0): ?>
                            <a href="sendall.php" class="registrar-btn">Send All Students To System Administrator</a>
                        <?php elseif ($canSendAll): ?>
                            <span class="registrar-btn-disabled">No Students Ready To Send</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="registrar-studentlist-stats">
                    <div class="registrar-studentlist-stat">
                        <span>Total Students</span>
                        <strong><?php echo registrarH((string) $totalCount); ?></strong>
                    </div>
                    <div class="registrar-studentlist-stat">
                        <span>Ready To Send</span>
                        <strong><?php echo registrarH((string) $sendReadyCount); ?></strong>
                    </div>
                    <div class="registrar-studentlist-stat">
                        <span>Queued For Admin</span>
                        <strong><?php echo registrarH((string) $queuedCount); ?></strong>
                    </div>
                    <div class="registrar-studentlist-stat">
                        <span>Account Ready</span>
                        <strong><?php echo registrarH((string) $accountReadyCount); ?></strong>
                    </div>
                </div>

                <div class="registrar-studentlist-panel">
                    <div class="registrar-studentlist-head">
                        <div>
                            <h2 class="registrar-studentlist-title">Student List</h2>
                            <p class="registrar-studentlist-copy">This page is connected to the current `student`, `user`, and `account` tables. First-year semester-I rows can be sent to the administrator only when an account has not already been created for that student.</p>
                        </div>
                    </div>

                    <?php if (empty($students)): ?>
                        <div class="registrar-empty">No student records were found for the selected department, year, and semester.</div>
                    <?php else: ?>
                        <div class="registrar-studentlist-table-wrap">
                            <table class="registrar-studentlist-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>College</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Semester</th>
                                        <th>Account Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php $statusMeta = registrarSendStudentStatusMeta($student, $canSendAll); ?>
                                        <tr>
                                            <td><?php echo registrarH($student['S_ID'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['FName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['LName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Sex'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Email'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Phone_No'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['College'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Department'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['year'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['semister'] ?? ''); ?></td>
                                            <td><span class="registrar-studentlist-badge <?php echo registrarH($statusMeta['class']); ?>"><?php echo registrarH($statusMeta['label']); ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photoPath); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
