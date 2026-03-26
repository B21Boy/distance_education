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
    $result = mysql_query("SELECT * FROM course where status='no'");
    while ($row = mysql_fetch_array($result)) {
        $sender_id = $row['Sender_name'];
        $sender_result = mysql_query("SELECT * FROM user where UID='$sender_id'");
        $sender = mysql_fetch_array($sender_result);
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
                            <h1 class="admin-page-title">Download Modules and Upload to Students</h1>
                            <p class="admin-page-copy">Review pending uploaded modules, download files, assign them to student groups, and calculate preparation payment from one standard management screen.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-toolbar">
                            <span class="page-stat-chip"><?php echo count($modules); ?> pending module<?php echo count($modules) === 1 ? '' : 's'; ?></span>
                            <a href="viewuploadmoduleall.php" class="page-nav-link">View All Modules</a>
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
                                        <th>Download or Upload</th>
                                        <th>Payment Load</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($modules as $row) {
                                    $file_name = $row['FileName'];
                                    $course_code = $row['course_code'];
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
                                                <a href="../material/module/<?php echo htmlspecialchars($file_name, ENT_QUOTES, 'UTF-8'); ?>" class="page-nav-link">Download</a>
                                                <a rel="facebox" href="assign_course_instructorS.php?id=<?php echo urlencode($course_code); ?>" class="page-nav-link is-secondary">Upload</a>
                                            </div>
                                        </td>
                                        <td>
                                            <a rel="facebox" href="feemodule.php?id=<?php echo urlencode($course_code); ?>" class="table-action-link">Calculate payment load</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                        <div class="admin-page-empty">No pending uploaded modules were found.</div>
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
