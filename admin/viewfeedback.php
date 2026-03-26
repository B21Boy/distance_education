<?php
session_start();
include(__DIR__ . '/../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css"/>
<script src="../javascript/date_time.js"></script>
<style>
.feedback-comment {
    max-width: 460px;
    white-space: pre-wrap;
    word-break: break-word;
    line-height: 1.7;
}
.feedback-delete-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 0 14px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    background: #b64242;
}
.feedback-status-message {
    margin-bottom: 18px;
    padding: 14px 16px;
    border-radius: 12px;
    font-weight: 700;
}
.feedback-status-message.is-success {
    background: #e8f7ea;
    border: 1px solid #7ecb87;
    color: #1b5e20;
}
.feedback-status-message.is-error {
    background: #fdeaea;
    border: 1px solid #e38b8b;
    color: #8a1f1f;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $rows = array();
    $feedbackCount = 0;
    $statusType = (string) ($_GET['type'] ?? '');
    $statusMessage = (string) ($_GET['message'] ?? '');

    $countResult = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM feed_back');
    if ($countResult instanceof mysqli_result) {
        $countRow = mysqli_fetch_assoc($countResult);
        $feedbackCount = (int) ($countRow['total'] ?? 0);
        mysqli_free_result($countResult);
    }

    $result = mysqli_query($conn, 'SELECT fbid, name, email, role, Comment, date FROM feed_back ORDER BY date DESC');
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }
?>
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="admin-page-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">Admin</span>
                            <h1 class="admin-page-title">Feedback Records</h1>
                            <p class="admin-page-copy">Read submitted feedback in the standard admin layout and delete individual records reliably.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <?php if ($statusMessage !== '') { ?>
                        <div class="feedback-status-message <?php echo $statusType === 'success' ? 'is-success' : 'is-error'; ?>">
                            <?php echo htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <?php } ?>
                        <div class="admin-page-status-card" style="margin-bottom:18px;">
                            Number of records: <strong><?php echo $feedbackCount; ?></strong>
                        </div>
                        <?php if (!empty($rows)) { ?>
                        <div class="admin-page-table-wrap">
                            <table class="admin-page-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>UserType</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><div class="feedback-comment"><?php echo htmlspecialchars($row['Comment'], ENT_QUOTES, 'UTF-8'); ?></div></td>
                                        <td><?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><a class="feedback-delete-link" href="deletefeedback.php?id=<?php echo urlencode((string) $row['fbid']); ?>" onclick="return confirm('Delete this feedback record?');">Delete</a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                        <div class="admin-page-empty">No feedback records found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require('rightsidebar.php'); ?></div>
    </div>
    <div id="footer"><?php include('../footer.php'); ?></div>
</div>
<?php } else { header('location:../index.php'); exit; } ?>
</body>
</html>
