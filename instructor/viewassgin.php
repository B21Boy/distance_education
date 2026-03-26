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

$filters = [
    'dpt' => trim((string) ($_POST['dpt'] ?? '')),
    'scy' => trim((string) ($_POST['scy'] ?? '')),
    'sem' => trim((string) ($_POST['sem'] ?? '')),
];
$hasSearch = isset($_POST['search']);
$assignments = [];
if ($hasSearch && $filters['dpt'] !== '' && $filters['scy'] !== '' && $filters['sem'] !== '') {
    $assignments = instructorFetchAssignmentUploads($conn, $filters['dpt'], $filters['scy'], $filters['sem']);
}
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
                            <span class="instructor-page-kicker">Assignment</span>
                            <h1 class="instructor-page-title">View Uploaded Assignments</h1>
                            <p class="instructor-page-copy">Use the current filters to review uploaded assignment records. The filter fields now load from your assigned course combinations and keep the selected values after search.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if (!$assignedRows) { ?>
                            <div class="instructor-empty-state">There are no assigned course records for this instructor account yet, so the assignment filters are empty.</div>
                        <?php } else { ?>
                            <p class="instructor-form-note">Choose department, class year, and semister from your assigned teaching records to load uploaded assignment entries.</p>
                            <form action="" method="post" id="viewassign-form">
                                <div class="instructor-form-grid">
                                    <div class="instructor-form-field">
                                        <label for="viewassign-dpt">Select Department</label>
                                        <select id="viewassign-dpt" name="dpt" data-selected="<?php echo instructorH($filters['dpt']); ?>" required>
                                            <option value="">--select department--</option>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo instructorH($department); ?>"<?php echo $filters['dpt'] === $department ? ' selected' : ''; ?>><?php echo instructorH($department); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewassign-scy">Student Class Year</label>
                                        <select id="viewassign-scy" name="scy" data-selected="<?php echo instructorH($filters['scy']); ?>" required>
                                            <option value="">Select Student Class Year</option>
                                            <?php foreach ($classYears as $classYear) { ?>
                                                <option value="<?php echo instructorH($classYear); ?>"<?php echo $filters['scy'] === $classYear ? ' selected' : ''; ?>><?php echo instructorH($classYear); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="instructor-form-field">
                                        <label for="viewassign-sem">Semister</label>
                                        <select id="viewassign-sem" name="sem" data-selected="<?php echo instructorH($filters['sem']); ?>" required>
                                            <option value="">Select Semister</option>
                                            <?php foreach ($semisters as $semister) { ?>
                                                <option value="<?php echo instructorH($semister); ?>"<?php echo $filters['sem'] === $semister ? ' selected' : ''; ?>><?php echo instructorH($semister); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="instructor-form-actions">
                                    <button type="submit" class="instructor-btn" name="search">Search</button>
                                </div>
                            </form>
                        <?php } ?>
                        <?php if ($hasSearch) { ?>
                            <?php if ($assignments) { ?>
                                <div class="instructor-table-wrap">
                                    <table cellpadding="1" cellspacing="1" id="resultTable">
                                        <thead>
                                            <tr>
                                                <th>Assignment Number</th>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Student Class Year</th>
                                                <th>Semister</th>
                                                <th>Submission Date</th>
                                                <th>File Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($assignments as $assignment) { ?>
                                                <tr>
                                                    <td><?php echo instructorH($assignment['asno'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['ccode'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['cname'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['department'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['Student_class_year'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['semister'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['Submission_date'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['fileName'] ?? ''); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="instructor-empty-state">There is no uploaded assignment for the selected filters.</div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php instructorRenderSidebar($photoPath); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php if ($assignedRows) { instructorRenderAssignedFilterScript('viewassign-form', $assignedRows, array('dpt', 'scy', 'sem')); } ?>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
