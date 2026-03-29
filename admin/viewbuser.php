<?php
session_start();
include(__DIR__ . '/../connection.php');

function admin_blocked_user_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole'])) {
    header('location:../index.php');
    exit;
}

$rows = array();
$blockedCount = 0;
$pageError = '';
$statusType = trim((string) ($_GET['type'] ?? ''));
$statusMessage = trim((string) ($_GET['message'] ?? ''));

if (!($conn instanceof mysqli)) {
    $pageError = 'Database connection is not available.';
} else {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn->set_charset('utf8mb4');

        $countResult = $conn->query("SELECT COUNT(*) AS total FROM account WHERE status='no'");
        if ($countResult instanceof mysqli_result) {
            $countRow = $countResult->fetch_assoc();
            $blockedCount = (int) ($countRow['total'] ?? 0);
            $countResult->free();
        }

        $blockedSql = "
            SELECT
                a.UID,
                a.Role,
                a.status,
                COALESCE(u.fname, '') AS fname,
                COALESCE(u.lname, '') AS lname,
                COALESCE(u.sex, '') AS sex,
                COALESCE(u.Email, '') AS Email,
                COALESCE(u.phone_No, '') AS phone_No,
                COALESCE(u.location, '') AS location
            FROM account AS a
            LEFT JOIN user AS u
                ON u.UID = a.UID
            WHERE a.status = 'no'
            ORDER BY a.Role ASC, a.UID ASC
        ";
        $blockedResult = $conn->query($blockedSql);
        while ($row = $blockedResult->fetch_assoc()) {
            $rows[] = $row;
        }
        $blockedResult->free();
    } catch (Throwable $e) {
        $pageError = trim($e->getMessage()) !== '' ? trim($e->getMessage()) : 'Unable to load blocked user records right now.';
        error_log('admin/viewbuser.php error: ' . $pageError);
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
.blocked-user-shell {
    display: grid;
    gap: 20px;
}
.blocked-user-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.blocked-user-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}
.blocked-user-stat {
    padding: 18px;
    border-radius: 16px;
    border: 1px solid #dbe6f2;
    background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
}
.blocked-user-stat span {
    display: block;
    margin-bottom: 8px;
    color: #67819a;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.blocked-user-stat strong {
    color: #12395f;
    font-size: 28px;
}
.blocked-user-note {
    color: #4a6480;
    line-height: 1.6;
}
.blocked-user-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #fdeaea;
    color: #a12c2c;
}
.blocked-user-role {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    padding: 0 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #e8f1fb;
    color: #1a5589;
}
.blocked-user-action {
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
.blocked-user-message {
    margin-bottom: 18px;
    padding: 14px 16px;
    border-radius: 12px;
    font-weight: 700;
}
.blocked-user-message.is-success {
    background: #e8f7ea;
    border: 1px solid #7ecb87;
    color: #1b5e20;
}
.blocked-user-message.is-error {
    background: #fdeaea;
    border: 1px solid #e38b8b;
    color: #8a1f1f;
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
                <div class="blocked-user-shell">
                    <div class="admin-page-shell">
                        <div class="admin-page-header">
                            <div>
                                <span class="admin-page-kicker">Admin</span>
                                <h1 class="admin-page-title">Blocked User Records</h1>
                                <p class="admin-page-copy">Review blocked account records in the same admin layout used by the other pages and unblock access through the current `account` and `user` tables safely.</p>
                            </div>
                        </div>

                        <?php if ($statusMessage !== '') { ?>
                        <div class="blocked-user-message <?php echo $statusType === 'success' ? 'is-success' : 'is-error'; ?>">
                            <?php echo admin_blocked_user_h($statusMessage); ?>
                        </div>
                        <?php } ?>

                        <?php if ($pageError !== '') { ?>
                        <div class="admin-page-panel">
                            <div class="admin-page-empty"><?php echo admin_blocked_user_h($pageError); ?></div>
                        </div>
                        <?php } else { ?>
                        <div class="admin-page-panel">
                            <div class="blocked-user-toolbar">
                                <div class="blocked-user-note">This page reads blocked users from the shared admin database connection and joins account records with user profile details in one query.</div>
                                <a href="addaccountb.php" class="admin-page-btn-secondary">Manage All Accounts</a>
                            </div>
                        </div>

                        <div class="admin-page-panel">
                            <div class="blocked-user-summary">
                                <div class="blocked-user-stat">
                                    <span>Blocked Users</span>
                                    <strong><?php echo $blockedCount; ?></strong>
                                </div>
                                <div class="blocked-user-stat">
                                    <span>Action</span>
                                    <strong><?php echo $blockedCount > 0 ? 'Unblock Ready' : 'None'; ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="admin-page-panel">
                            <?php if (!empty($rows)) { ?>
                            <div class="admin-page-table-wrap">
                                <table class="admin-page-table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>UID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>User Type</th>
                                            <th>Sex</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row) { ?>
                                        <tr>
                                            <td><?php echo admin_blocked_user_h($row['UID']); ?></td>
                                            <td><?php echo admin_blocked_user_h($row['fname']); ?></td>
                                            <td><?php echo admin_blocked_user_h($row['lname']); ?></td>
                                            <td><span class="blocked-user-role"><?php echo admin_blocked_user_h($row['Role']); ?></span></td>
                                            <td><?php echo admin_blocked_user_h($row['sex']); ?></td>
                                            <td><?php echo admin_blocked_user_h($row['Email']); ?></td>
                                            <td><?php echo admin_blocked_user_h($row['phone_No']); ?></td>
                                            <td><?php echo admin_blocked_user_h($row['location']); ?></td>
                                            <td><span class="blocked-user-status"><?php echo admin_blocked_user_h($row['status']); ?></span></td>
                                            <td>
                                                <a class="blocked-user-action" href="ACTIONVBU.php?status=<?php echo urlencode((string) $row['UID']); ?>" onclick="return confirm('Are you sure you want to unblock <?php echo admin_blocked_user_h($row['UID']); ?>?');">
                                                    Unblock
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="admin-page-empty">No blocked user records were found.</div>
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
</body>
</html>
