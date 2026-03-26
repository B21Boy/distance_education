<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photoPath = instructorCurrentPhotoPath();
$schedules = instructorFetchModuleSchedules($conn);
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
                    <div class="instructor-page-header">
                        <div>
                            <span class="instructor-page-kicker">Schedule</span>
                            <h1 class="instructor-page-title">Module Preparation Schedule</h1>
                            <p class="instructor-page-copy">This page keeps the current schedule information and presents it in a cleaner shared format used across the instructor pages.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if ($schedules) { ?>
                            <div class="instructor-schedule-list">
                                <?php foreach ($schedules as $schedule) { ?>
                                    <div class="instructor-schedule-card"><?php echo nl2br(instructorH($schedule['information'] ?? '')); ?></div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="instructor-empty-state">No module preparation schedule is available right now.</div>
                        <?php } ?>
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