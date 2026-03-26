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
$departmentCodes = instructorFetchDepartmentCodes($conn, $userId);
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
                            <h1 class="instructor-page-title">Send Course Result</h1>
                            <p class="instructor-page-copy">Select the course result batch you want to review and forward. These dropdowns now follow the assigned-course combinations for this instructor account.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if (!$assignedRows) { ?>
                            <div class="instructor-empty-state">There are no assigned course records for this instructor account yet, so the course-result filters are empty.</div>
                        <?php } else { ?>
                            <p class="instructor-form-note">Pick the teaching assignment first, then choose the destination department code for the result workflow.</p>
                            <form action="viewcourseresult.php" method="post" id="viewgrade-form">
                                <div class="instructor-form-grid">
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-dpt">Select Department</label>
                                        <select id="viewgrade-dpt" name="dpt" data-selected="" required>
                                            <option value="">--select department--</option>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo instructorH($department); ?>"><?php echo instructorH($department); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-scy">Student Class Year</label>
                                        <select id="viewgrade-scy" name="scy" data-selected="" required>
                                            <option value="">--select Class Year--</option>
                                            <?php foreach ($classYears as $classYear) { ?>
                                                <option value="<?php echo instructorH($classYear); ?>"><?php echo instructorH($classYear); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-sem">Semister</label>
                                        <select id="viewgrade-sem" name="sem" data-selected="" required>
                                            <option value="">--select Semister--</option>
                                            <?php foreach ($semisters as $semister) { ?>
                                                <option value="<?php echo instructorH($semister); ?>"><?php echo instructorH($semister); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-sec">Section</label>
                                        <select id="viewgrade-sec" name="sec" data-selected="" required>
                                            <option value="">--select Section--</option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?php echo instructorH($section); ?>"><?php echo instructorH($section); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-cc">Course Code</label>
                                        <select id="viewgrade-cc" name="cc" data-selected="" required>
                                            <option value="">Select course code</option>
                                            <?php foreach ($courseCodes as $courseCode) { ?>
                                                <option value="<?php echo instructorH($courseCode); ?>"><?php echo instructorH($courseCode); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewgrade-uu">Send To</label>
                                        <select id="viewgrade-uu" name="uu" required>
                                            <option value="">--select Department Code--</option>
                                            <?php foreach ($departmentCodes as $departmentCode) { ?>
                                                <option value="<?php echo instructorH($departmentCode); ?>"><?php echo instructorH($departmentCode); ?></option>
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
<?php if ($assignedRows) { instructorRenderAssignedFilterScript('viewgrade-form', $assignedRows, array('dpt', 'scy', 'sem', 'sec', 'cc')); } ?>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
