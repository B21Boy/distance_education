<?php
session_start();
include(__DIR__ . '/../connection.php');
include_once(__DIR__ . '/ps_pagination.php');

function admin_student_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
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
.studentlist-shell {
    display: grid;
    gap: 20px;
}
.studentlist-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 16px;
    color: #45627f;
}
.studentlist-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.studentlist-status-badge.is-alert {
    background: #fff0d7;
    color: #9a5a06;
}
.studentlist-status-badge.is-blocked {
    background: #fdeaea;
    color: #a12c2c;
}
.studentlist-action-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 38px;
    padding: 0 16px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    background: #1f6fb2;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $studentRows = array();
    $studentPager = null;
    $studentCount = 0;
    $blockedRows = array();
    $blockedCount = 0;
    $pageError = '';

    if (!($conn instanceof mysqli)) {
        $pageError = 'Database connection is not available.';
    } else {
        $studentCountResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM student WHERE unread='no'");
        if ($studentCountResult instanceof mysqli_result) {
            $studentCountRow = mysqli_fetch_assoc($studentCountResult);
            $studentCount = (int) ($studentCountRow['total'] ?? 0);
            mysqli_free_result($studentCountResult);
        }

        $studentSql = "SELECT S_ID, FName, LName, Sex, Email, Phone_No, College, Department FROM student WHERE unread='no' ORDER BY Department ASC, S_ID ASC";
        $studentPager = new PS_Pagination($conn, $studentSql, 12, 5);
        $studentResult = $studentPager->paginate();
        if ($studentResult instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($studentResult)) {
                $studentRows[] = $row;
            }
            mysqli_free_result($studentResult);
        }

        $blockedSql = "SELECT entrance_exam.S_ID, entrance_exam.status, entrance_exam.account, student.Department, account.status AS account_status FROM entrance_exam LEFT JOIN student ON student.S_ID = entrance_exam.S_ID LEFT JOIN account ON account.UID = entrance_exam.S_ID WHERE entrance_exam.status='unsatisfactory' AND (entrance_exam.account=' ' OR entrance_exam.account='seen') ORDER BY entrance_exam.S_ID ASC";
        $blockedResult = mysqli_query($conn, $blockedSql);
        if ($blockedResult instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($blockedResult)) {
                $blockedRows[] = $row;
            }
            $blockedCount = count($blockedRows);
            mysqli_free_result($blockedResult);
        }
    }
?>
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="studentlist-shell">
                    <div class="admin-page-shell">
                        <div class="admin-page-header">
                            <div>
                                <span class="admin-page-kicker">Admin</span>
                                <h1 class="admin-page-title">Student Account Requests</h1>
                                <p class="admin-page-copy">Review students who are ready for account creation, monitor unsatisfactory entrance exam results, and keep the admin account workflow connected to the database correctly.</p>
                            </div>
                            <?php if ($studentCount > 0) { ?>
                            <a href="generatepassword.php" class="admin-page-btn">Create Account For All Students</a>
                            <?php } ?>
                        </div>

                        <?php if ($pageError !== '') { ?>
                        <div class="admin-page-empty"><?php echo admin_student_h($pageError); ?></div>
                        <?php } else { ?>
                        <div class="admin-page-panel">
                            <div class="studentlist-meta">
                                <div>Students ready for account creation: <strong><?php echo $studentCount; ?></strong></div>
                                <div>Blocked-request candidates: <strong><?php echo $blockedCount; ?></strong></div>
                            </div>
                            <?php if (!empty($studentRows)) { ?>
                            <div class="admin-page-table-wrap">
                                <table class="admin-page-table" cellpadding="0" cellspacing="0">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($studentRows as $row) { ?>
                                        <tr>
                                            <td><?php echo admin_student_h($row['S_ID']); ?></td>
                                            <td><?php echo admin_student_h($row['FName']); ?></td>
                                            <td><?php echo admin_student_h($row['LName']); ?></td>
                                            <td><?php echo admin_student_h($row['Sex']); ?></td>
                                            <td><?php echo admin_student_h($row['Email']); ?></td>
                                            <td><?php echo admin_student_h($row['Phone_No']); ?></td>
                                            <td><?php echo admin_student_h($row['College']); ?></td>
                                            <td><?php echo admin_student_h($row['Department']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($studentPager !== null) { ?>
                            <div class="admin-page-pagination"><?php echo $studentPager->renderFullNav(); ?></div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="admin-page-empty">No new students are ready for account creation right now.</div>
                            <?php } ?>
                        </div>

                        <div class="admin-page-panel">
                            <div class="studentlist-meta">
                                <div>Students with unsatisfactory entrance exam results</div>
                                <div>This list is connected to the current `student`, `entrance_exam`, and `account` tables.</div>
                            </div>
                            <?php if (!empty($blockedRows)) { ?>
                            <div class="admin-page-table-wrap">
                                <table class="admin-page-table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Department</th>
                                            <th>Exam Status</th>
                                            <th>Account Flag</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($blockedRows as $row) {
                                            $accountStatus = (string) ($row['account_status'] ?? '');
                                            $actionLabel = ($accountStatus === 'no') ? 'Unblock' : 'Block';
                                        ?>
                                        <tr>
                                            <td><?php echo admin_student_h($row['S_ID']); ?></td>
                                            <td><?php echo admin_student_h($row['Department'] ?? ''); ?></td>
                                            <td><span class="studentlist-status-badge is-alert"><?php echo admin_student_h($row['status']); ?></span></td>
                                            <td><span class="studentlist-status-badge is-blocked"><?php echo admin_student_h($row['account']); ?></span></td>
                                            <td>
                                                <a class="studentlist-action-link" href="ACTIONs.php?status=<?php echo urlencode((string) $row['S_ID']); ?>" onclick="return confirm('Are you sure you want to <?php echo strtolower($actionLabel); ?> <?php echo admin_student_h($row['S_ID']); ?>?');">
                                                    <?php echo $actionLabel; ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="admin-page-empty">No blocked-account requests are waiting right now.</div>
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
<?php
} else {
    header('location:../index.php');
    exit;
}
?>
</body>
</html>
