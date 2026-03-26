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
$assignedCourses = instructorFetchAssignedCourses($conn, $userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="instructor-page.css" type="text/css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
                            <span class="instructor-page-kicker">Module</span>
                            <h1 class="instructor-page-title">Assigned Courses</h1>
                            <p class="instructor-page-copy">Review the courses assigned to you and continue to the assignment upload screen for the course you want to work on.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if ($assignedCourses) { ?>
                            <div class="instructor-table-wrap">
                                <table cellpadding="1" cellspacing="1" id="resultTable">
                                    <thead>
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Instructor Name</th>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th>Student Class Year</th>
                                            <th>Semister</th>
                                            <th>Credit Hour</th>
                                            <th>Year</th>
                                            <th>Upload Assignment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($assignedCourses as $course) { ?>
                                            <tr>
                                                <td><?php echo instructorH($course['corse_code'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['cname'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['Iname'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['department'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['section'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['Student_class_year'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['semister'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['chour'] ?? ''); ?></td>
                                                <td><?php echo instructorH($course['ayear'] ?? ''); ?></td>
                                                <td><a class="instructor-inline-link" rel="facebox" href="uploadassignment.php?id=<?php echo urlencode((string) ($course['no'] ?? '')); ?>">Upload</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="instructor-empty-state">No assigned courses were found for your instructor account.</div>
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