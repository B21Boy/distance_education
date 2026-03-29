<?php
session_start();
include(__DIR__ . '/../connection.php');

function admin_view_student_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function admin_view_student_try_legacy_decrypt($value)
{
    if (
        !function_exists('mcrypt_decrypt') ||
        !defined('MCRYPT_RIJNDAEL_256') ||
        !defined('MCRYPT_MODE_CBC')
    ) {
        return '';
    }

    $decoded = base64_decode((string) $value, true);
    if ($decoded === false) {
        return '';
    }

    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $plaintext = @mcrypt_decrypt(
        MCRYPT_RIJNDAEL_256,
        md5($cryptKey),
        $decoded,
        MCRYPT_MODE_CBC,
        md5(md5($cryptKey))
    );

    if (!is_string($plaintext)) {
        return '';
    }

    $plaintext = trim(rtrim($plaintext, "\0"));
    if ($plaintext === '' || preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $plaintext)) {
        return '';
    }

    return $plaintext;
}

function admin_view_student_password_label($storedPassword)
{
    $storedPassword = trim((string) $storedPassword);
    if ($storedPassword === '') {
        return '-';
    }

    $legacyPassword = admin_view_student_try_legacy_decrypt($storedPassword);
    if ($legacyPassword !== '') {
        return $legacyPassword;
    }

    return $storedPassword;
}

function admin_view_student_fetch_accounts(mysqli $conn, $selectedDepartmentCode = '', $selectedDepartmentName = '')
{
    $rows = array();

    if ($selectedDepartmentCode !== '' || $selectedDepartmentName !== '') {
        $accountStmt = $conn->prepare(
            "SELECT
                a.UID,
                a.UserName,
                a.Password,
                COALESCE(
                    NULLIF(TRIM(CONCAT(COALESCE(u.fname, ''), ' ', COALESCE(u.lname, ''))), ''),
                    NULLIF(TRIM(CONCAT(COALESCE(s.FName, ''), ' ', COALESCE(s.LName, ''))), ''),
                    '-'
                ) AS student_name,
                COALESCE(NULLIF(d.DName, ''), NULLIF(s.Department, ''), ?) AS department_name
            FROM account AS a
            LEFT JOIN user AS u
                ON u.UID = a.UID
            LEFT JOIN department AS d
                ON d.Dcode = u.d_code
            LEFT JOIN student AS s
                ON s.S_ID = a.UID
            WHERE a.Role = 'student'
                AND a.status = 'yes'
                AND (
                    u.d_code = ?
                    OR LOWER(TRIM(COALESCE(s.Department, ''))) = LOWER(TRIM(?))
                )
            ORDER BY a.UID ASC"
        );
        $accountStmt->bind_param('sss', $selectedDepartmentName, $selectedDepartmentCode, $selectedDepartmentName);
    } else {
        $accountStmt = $conn->prepare(
            "SELECT
                a.UID,
                a.UserName,
                a.Password,
                COALESCE(
                    NULLIF(TRIM(CONCAT(COALESCE(u.fname, ''), ' ', COALESCE(u.lname, ''))), ''),
                    NULLIF(TRIM(CONCAT(COALESCE(s.FName, ''), ' ', COALESCE(s.LName, ''))), ''),
                    '-'
                ) AS student_name,
                COALESCE(NULLIF(d.DName, ''), NULLIF(s.Department, ''), 'Unassigned') AS department_name
            FROM account AS a
            LEFT JOIN user AS u
                ON u.UID = a.UID
            LEFT JOIN department AS d
                ON d.Dcode = u.d_code
            LEFT JOIN student AS s
                ON s.S_ID = a.UID
            WHERE a.Role = 'student'
                AND a.status = 'yes'
            ORDER BY department_name ASC, a.UID ASC"
        );
    }

    $accountStmt->execute();
    $accountResult = $accountStmt->get_result();
    while ($row = $accountResult->fetch_assoc()) {
        $rows[] = array(
            'uid' => trim((string) ($row['UID'] ?? '')),
            'student_name' => trim((string) ($row['student_name'] ?? '')),
            'department_name' => trim((string) ($row['department_name'] ?? '')),
            'username' => trim((string) ($row['UserName'] ?? '')),
            'password' => admin_view_student_password_label($row['Password'] ?? ''),
            'remark' => 'Give this password to the student and require a password change after first login.',
        );
    }
    $accountStmt->close();

    return $rows;
}

if (!isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole'])) {
    header('location:../index.php');
    exit;
}

$departments = array();
$accountRows = array();
$selectedDepartment = '';
$selectedDepartmentCode = '';
$pageError = '';
$pageNotice = '';
$shouldAutoPrint = isset($_GET['print_dialog']) && $_GET['print_dialog'] === '1';

if (!($conn instanceof mysqli)) {
    $pageError = 'Database connection is not available.';
} else {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn->set_charset('utf8mb4');

        $departmentResult = $conn->query('SELECT DName, Dcode FROM department ORDER BY DName ASC');
        while ($row = $departmentResult->fetch_assoc()) {
            $departments[] = $row;
        }
        $departmentResult->free();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $selectedDepartment = trim((string) ($_POST['dpt'] ?? ''));

            if ($selectedDepartment === '') {
                $pageError = 'Select a department before searching.';
            } else {
                $departmentStmt = $conn->prepare('SELECT DName, Dcode FROM department WHERE DName = ? LIMIT 1');
                $departmentStmt->bind_param('s', $selectedDepartment);
                $departmentStmt->execute();
                $departmentResult = $departmentStmt->get_result();
                $departmentRow = $departmentResult->fetch_assoc();
                $departmentStmt->close();

                if (!is_array($departmentRow)) {
                    $pageError = 'The selected department was not found.';
                } else {
                    $selectedDepartment = trim((string) ($departmentRow['DName'] ?? ''));
                    $selectedDepartmentCode = trim((string) ($departmentRow['Dcode'] ?? ''));
                    $accountRows = admin_view_student_fetch_accounts($conn, $selectedDepartmentCode, $selectedDepartment);

                    if (empty($accountRows)) {
                        $pageNotice = 'No active student accounts were found for the selected department.';
                    }
                }
            }
        } elseif ($shouldAutoPrint) {
            $selectedDepartment = 'All departments';
            $accountRows = admin_view_student_fetch_accounts($conn);
            if (empty($accountRows)) {
                $pageNotice = 'No active student accounts were found to print.';
            }
        }
    } catch (Throwable $e) {
        $pageError = trim($e->getMessage()) !== '' ? trim($e->getMessage()) : 'Unable to load student account records right now.';
        error_log('admin/viewstudentaccount.php error: ' . $pageError);
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
<script src="../javascript/date_time.js"></script>
<style>
.view-account-shell {
    display: grid;
    gap: 20px;
}
.view-account-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}
.view-account-stat {
    padding: 18px;
    border-radius: 16px;
    border: 1px solid #dbe6f2;
    background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
}
.view-account-stat span {
    display: block;
    margin-bottom: 8px;
    color: #67819a;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.view-account-stat strong {
    color: #12395f;
    font-size: 28px;
}
.view-account-toolbar-note {
    color: #4a6480;
    font-size: 14px;
    line-height: 1.6;
}
.view-account-filter {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 16px;
    flex-wrap: wrap;
}
.view-account-print-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.view-account-result-note {
    color: #54708b;
    line-height: 1.6;
}
.view-account-table td:last-child {
    min-width: 260px;
}
.view-account-print-template {
    display: none;
}
@media print {
    body.student-portal-page #header,
    body.student-portal-page #menu,
    body.student-portal-page #left,
    body.student-portal-page #sidebar,
    body.student-portal-page #footer,
    body.student-portal-page .view-account-filter,
    body.student-portal-page .view-account-print-row,
    body.student-portal-page .admin-page-kicker,
    body.student-portal-page .admin-page-copy {
        display: none !important;
    }
    body.student-portal-page,
    body.student-portal-page #container,
    body.student-portal-page #content,
    body.student-portal-page #contentindex5,
    body.student-portal-page .main-row,
    body.student-portal-page .admin-page-shell,
    body.student-portal-page .admin-page-panel {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border: 0 !important;
        background: #ffffff !important;
    }
    body.student-portal-page .admin-page-title {
        margin-bottom: 12px !important;
        font-size: 24px !important;
    }
    body.student-portal-page .view-account-summary {
        margin-bottom: 18px !important;
    }
}
@media (max-width: 720px) {
    .view-account-filter {
        align-items: stretch;
    }
}
</style>
<script>
function openStudentAccountPrintDialog() {
    window.print();
}
</script>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="view-account-shell">
                    <div class="admin-page-shell">
                        <div class="admin-page-header">
                            <div>
                                <span class="admin-page-kicker">Admin</span>
                                <h1 class="admin-page-title">Print Student Account</h1>
                                <p class="admin-page-copy">Select a department to filter the list, or open this page from the side menu to print all active student accounts immediately with the browser print dialog.</p>
                            </div>
                        </div>

                        <div class="admin-page-panel">
                            <form action="" method="post" class="view-account-filter">
                                <div class="admin-page-form-row">
                                    <label for="dpt"><strong>Select department</strong></label>
                                    <select name="dpt" id="dpt" class="admin-page-select" required>
                                        <option value="">-- select department --</option>
                                        <?php foreach ($departments as $department) {
                                            $departmentName = trim((string) ($department['DName'] ?? ''));
                                        ?>
                                        <option value="<?php echo admin_view_student_h($departmentName); ?>"<?php echo $departmentName === $selectedDepartment ? ' selected' : ''; ?>>
                                            <?php echo admin_view_student_h($departmentName); ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <button type="submit" name="search" class="admin-page-btn">Search</button>
                                    <?php if ($selectedDepartment !== '') { ?>
                                    <a href="viewstudentaccount.php" class="admin-page-btn-secondary">Clear</a>
                                    <?php } ?>
                                </div>
                                <div class="view-account-toolbar-note">This page is read-only. It uses the shared admin database connection and reads from the `department`, `account`, `user`, and `student` tables.</div>
                            </form>
                        </div>

                        <?php if ($pageError !== '') { ?>
                        <div class="admin-page-panel">
                            <div class="admin-page-empty"><?php echo admin_view_student_h($pageError); ?></div>
                        </div>
                        <?php } else { ?>
                        <div class="admin-page-panel">
                            <div class="view-account-summary">
                                <div class="view-account-stat">
                                    <span>Departments</span>
                                    <strong><?php echo count($departments); ?></strong>
                                </div>
                                <div class="view-account-stat">
                                    <span>Selected Department</span>
                                    <strong><?php echo admin_view_student_h($selectedDepartment !== '' ? $selectedDepartment : '-'); ?></strong>
                                </div>
                                <div class="view-account-stat">
                                    <span>Accounts Found</span>
                                    <strong><?php echo count($accountRows); ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="admin-page-panel">
                            <?php if ($pageNotice !== '') { ?>
                            <div class="admin-page-empty"><?php echo admin_view_student_h($pageNotice); ?></div>
                            <?php } elseif (!empty($accountRows)) { ?>
                            <div class="view-account-print-row">
                                <div class="view-account-result-note">Use the print button below to open the browser print dialog with the currently displayed student account list.</div>
                                <button type="button" class="admin-page-btn" onclick="openStudentAccountPrintDialog()">Print Student Accounts</button>
                            </div>
                            <div class="admin-page-table-wrap">
                                <table class="admin-page-table view-account-table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Department</th>
                                            <th>Username</th>
                                            <th>Temporary Password</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($accountRows as $row) { ?>
                                        <tr>
                                            <td><?php echo admin_view_student_h($row['uid']); ?></td>
                                            <td><?php echo admin_view_student_h($row['student_name']); ?></td>
                                            <td><?php echo admin_view_student_h($row['department_name']); ?></td>
                                            <td><?php echo admin_view_student_h($row['username']); ?></td>
                                            <td><?php echo admin_view_student_h($row['password']); ?></td>
                                            <td><?php echo admin_view_student_h($row['remark']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php } else { ?>
                            <div class="admin-page-empty">Select a department and search to load student accounts for printing.</div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require('rightsidebar.php'); ?></div>
    </div>
    <div id="footer"><?php include('../footer.php'); ?></div>
</div>
<?php if ($shouldAutoPrint && $pageError === '' && !empty($accountRows)) { ?>
<script>
window.addEventListener('load', function () {
    window.setTimeout(function () {
        window.print();
    }, 350);
});
</script>
<?php } ?>
</body>
</html>
