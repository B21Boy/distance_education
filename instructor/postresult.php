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
                            <h1 class="instructor-page-title">Post Student Course Result</h1>
                            <p class="instructor-page-copy">Choose the assigned course details below to continue to the posting screen. The dropdowns now load from the courses assigned to your account and narrow each other as you choose values.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if (!$assignedRows) { ?>
                            <div class="instructor-empty-state">There are no assigned course records for this instructor account yet, so there is nothing to choose in the filter dropdowns.</div>
                        <?php } else { ?>
                            <p class="instructor-form-note">Start with department, then choose class year, semister, section, and course code from the matching assigned-course list.</p>
                            <form action="addcourseresult.php" method="post" id="postresult-form">
                                <div class="instructor-form-grid">
                                    <div class="instructor-form-field">
                                        <label for="postresult-dpt">Select Department</label>
                                        <select id="postresult-dpt" name="dpt" data-selected="" required>
                                            <option value="">--select department--</option>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo instructorH($department); ?>"><?php echo instructorH($department); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="postresult-scy">Student Class Year</label>
                                        <select id="postresult-scy" name="scy" data-selected="" required>
                                            <option value="">--select Class Year--</option>
                                            <?php foreach ($classYears as $classYear) { ?>
                                                <option value="<?php echo instructorH($classYear); ?>"><?php echo instructorH($classYear); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="postresult-sem">Semister</label>
                                        <select id="postresult-sem" name="sem" data-selected="" required>
                                            <option value="">--select Semister--</option>
                                            <?php foreach ($semisters as $semister) { ?>
                                                <option value="<?php echo instructorH($semister); ?>"><?php echo instructorH($semister); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="postresult-sec">Section</label>
                                        <select id="postresult-sec" name="sec" data-selected="" required>
                                            <option value="">--select Section--</option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?php echo instructorH($section); ?>"><?php echo instructorH($section); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="postresult-cc">Course Code</label>
                                        <select id="postresult-cc" name="cc" data-selected="" required>
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
<?php if ($assignedRows) { instructorRenderAssignedFilterScript('postresult-form', $assignedRows, array('dpt', 'scy', 'sem', 'sec', 'cc')); } ?>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
