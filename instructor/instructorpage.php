<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photoPath = instructorCurrentPhotoPath();
$firstName = instructorH($_SESSION['sfn'] ?? 'Instructor');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="instructor-page.css" type="text/css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menuins.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenuins.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="instructor-page-shell">
                    <section class="instructor-dashboard-hero">
                        <span class="instructor-page-kicker">Instructor Dashboard</span>
                        <h1 class="instructor-page-title">Welcome back, <?php echo $firstName; ?>.</h1>
                        <p class="instructor-page-copy">Use this page to manage assigned courses, upload learning materials, post and review course results, download submitted assignments, and follow student or system notifications. The instructor workspace is focused on teaching support, assessment follow-up, and academic communication.</p>
                    </section>
                    <div class="instructor-dashboard-grid">
                        <a class="instructor-dashboard-card" href="uploadmodule.php">
                            <strong>Assigned Courses</strong>
                            <span>Review the courses and teaching loads currently assigned to your account.</span>
                        </a>
                        <a class="instructor-dashboard-card" href="uploadmoduleto.php">
                            <strong>Upload Modules</strong>
                            <span>Share prepared modules and teaching materials for the courses you handle.</span>
                        </a>
                        <a class="instructor-dashboard-card" href="assignmentdownload.php">
                            <strong>Submitted Assignments</strong>
                            <span>Download student assignment files and track the latest submissions.</span>
                        </a>
                        <a class="instructor-dashboard-card" href="postresult.php">
                            <strong>Post Results</strong>
                            <span>Choose a course, prepare result records, and continue to the posting workflow.</span>
                        </a>
                        <a class="instructor-dashboard-card" href="viewgrade.php">
                            <strong>Send Results</strong>
                            <span>Review posted result batches and forward them through the approval process.</span>
                        </a>
                        <a class="instructor-dashboard-card" href="usernotification.php">
                            <strong>Notifications</strong>
                            <span>Check unread messages, follow updates, and respond to academic communication.</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php instructorRenderSidebar($photoPath); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
