<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>CDE Officer page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $modules = array();
    $result = mysql_query("SELECT * FROM course where status='yes'");
    while ($row = mysql_fetch_array($result)) {
        $senderId = $row['Sender_name'];
        $senderResult = mysql_query("SELECT * FROM user where UID='$senderId'");
        $sender = mysql_fetch_array($senderResult);
        $row['sender_full_name'] = trim($sender['fname'] . ' ' . $sender['lname']);
        $modules[] = $row;
    }
?>
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menucdeo.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenucdeo.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="admin-page-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">CDE Officer</span>
                            <h1 class="admin-page-title">All Uploaded Modules</h1>
                            <p class="admin-page-copy">Review modules that were already uploaded, download files, and reopen assignment actions from a cleaner table layout.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-toolbar">
                            <span class="page-stat-chip"><?php echo count($modules); ?> uploaded modules</span>
                        </div>
                        <?php if (!empty($modules)) { ?>
                        <div class="admin-page-table-wrap">
                            <table class="admin-page-table">
                                <thead>
                                    <tr>
                                        <th>Sender Name</th>
                                        <th>Module Code</th>
                                        <th>Module Name</th>
                                        <th>Credit Hour</th>
                                        <th>Year</th>
                                        <th>Department</th>
                                        <th>File Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($modules as $row) {
                                    $fileName = $row['FileName'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['sender_full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['course_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['cname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['chour'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['ayear'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['FileName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <div class="page-nav-links">
                                                <a class="page-nav-link" href="../material/module/<?php echo htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8'); ?>">Download</a>
                                                <a class="page-nav-link is-secondary" rel="facebox" href="assign_course_instructorSu.php?id=<?php echo urlencode($row['course_code']); ?>">Assign Upload</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                        <div class="admin-page-empty">No uploaded modules were found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require("officer_sidebar.php"); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php
} else {
    header("location:../index.php");
    exit;
}
?>
</body>
</html>
