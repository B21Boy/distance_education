<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$userId = instructorCurrentUserId();
$photoPath = instructorCurrentPhotoPath();
$assignedRows = instructorBuildAssignedFilterRows($conn, $userId);
$departments = instructorFilterValues($assignedRows, 'dpt');
$classYears = instructorFilterValues($assignedRows, 'scy');
$semisters = instructorFilterValues($assignedRows, 'sem');
$sections = instructorFilterValues($assignedRows, 'sec');
$courseCodes = instructorFilterValues($assignedRows, 'cc');
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
                            <span class="instructor-page-kicker">Course Result</span>
                            <h1 class="instructor-page-title">View Course Result</h1>
                            <p class="instructor-page-copy">Filter the result records for the assigned course you want to review. The dropdowns now stay tied to real assigned-course combinations.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if (!$assignedRows) { ?>
                            <div class="instructor-empty-state">There are no assigned course records for this instructor account yet, so the result filters are empty.</div>
                        <?php } else { ?>
                            <p class="instructor-form-note">Choose the matching assignment path from the dropdowns to open the existing course-result view page.</p>
                            <form action="viewcourseresult1.php" method="post" id="viewcourse-form">
                                <div class="instructor-form-grid">
                                    <div class="instructor-form-field">
                                        <label for="viewcourse-dpt">Select Department</label>
                                        <select id="viewcourse-dpt" name="dpt" data-selected="" required>
                                            <option value="">--select department--</option>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo instructorH($department); ?>"><?php echo instructorH($department); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewcourse-scy">Student Class Year</label>
                                        <select id="viewcourse-scy" name="scy" data-selected="" required>
                                            <option value="">--select Class Year--</option>
                                            <?php foreach ($classYears as $classYear) { ?>
                                                <option value="<?php echo instructorH($classYear); ?>"><?php echo instructorH($classYear); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewcourse-sem">Semister</label>
                                        <select id="viewcourse-sem" name="sem" data-selected="" required>
                                            <option value="">--select Semister--</option>
                                            <?php foreach ($semisters as $semister) { ?>
                                                <option value="<?php echo instructorH($semister); ?>"><?php echo instructorH($semister); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewcourse-sec">Section</label>
                                        <select id="viewcourse-sec" name="sec" data-selected="" required>
                                            <option value="">--select Section--</option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?php echo instructorH($section); ?>"><?php echo instructorH($section); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewcourse-cc">Course Code</label>
                                        <select id="viewcourse-cc" name="cc" data-selected="" required>
                                            <option value="">Select course code</option>
                                            <?php foreach ($courseCodes as $courseCode) { ?>
                                                <option value="<?php echo instructorH($courseCode); ?>"><?php echo instructorH($courseCode); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="instructor-form-actions">
                                    <button type="submit" class="instructor-btn" name="search">Search</button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php instructorRenderSidebar($photoPath); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php if ($assignedRows) { instructorRenderAssignedFilterScript('viewcourse-form', $assignedRows, array('dpt', 'scy', 'sem', 'sec', 'cc')); } ?>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
