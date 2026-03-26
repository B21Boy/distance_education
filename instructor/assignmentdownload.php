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
$departments = instructorFetchDistinctAssignedValues($conn, 'department', $userId);
$classYears = instructorFetchDistinctAssignedValues($conn, 'Student_class_year', $userId);
$semisters = instructorFetchDistinctAssignedValues($conn, 'semister', $userId);
$courseCodes = instructorFetchDistinctAssignedValues($conn, 'corse_code', $userId);

$filters = [
    'dpt' => trim((string) ($_POST['dpt'] ?? '')),
    'scy' => trim((string) ($_POST['scy'] ?? '')),
    'sem' => trim((string) ($_POST['sem'] ?? '')),
    'cc' => trim((string) ($_POST['cc'] ?? '')),
];
$hasSearch = isset($_POST['search']);
$assignments = [];
if ($hasSearch && $filters['dpt'] !== '' && $filters['scy'] !== '' && $filters['sem'] !== '' && $filters['cc'] !== '') {
    $assignments = instructorFetchSubmittedAssignments($conn, $userId, $filters['dpt'], $filters['scy'], $filters['sem'], $filters['cc']);
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
                            <h1 class="instructor-page-title">Download Submitted Assignments</h1>
                            <p class="instructor-page-copy">Filter the submitted assignment records for the course you teach, then download the files directly from the table.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <form action="" method="post">
                            <div class="instructor-form-grid">
                                <div class="instructor-form-field">
                                    <label for="assignmentdownload-dpt">Select Department</label>
                                    <select id="assignmentdownload-dpt" name="dpt" required>
                                        <option value="">--select department--</option>
                                        <?php foreach ($departments as $department) { ?>
                                            <option value="<?php echo instructorH($department); ?>"<?php echo $filters['dpt'] === $department ? ' selected' : ''; ?>><?php echo instructorH($department); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="instructor-form-field">
                                    <label for="assignmentdownload-scy">Student Class Year</label>
                                    <select id="assignmentdownload-scy" name="scy" required>
                                        <option value="">--select Class Year--</option>
                                        <?php foreach ($classYears as $classYear) { ?>
                                            <option value="<?php echo instructorH($classYear); ?>"<?php echo $filters['scy'] === $classYear ? ' selected' : ''; ?>><?php echo instructorH($classYear); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="instructor-form-field">
                                    <label for="assignmentdownload-sem">Semister</label>
                                    <select id="assignmentdownload-sem" name="sem" required>
                                        <option value="">--select Semister--</option>
                                        <?php foreach ($semisters as $semister) { ?>
                                            <option value="<?php echo instructorH($semister); ?>"<?php echo $filters['sem'] === $semister ? ' selected' : ''; ?>><?php echo instructorH($semister); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="instructor-form-field">
                                    <label for="assignmentdownload-cc">Course Code</label>
                                    <select id="assignmentdownload-cc" name="cc" required>
                                        <option value="">Select course code</option>
                                        <?php foreach ($courseCodes as $courseCode) { ?>
                                            <option value="<?php echo instructorH($courseCode); ?>"<?php echo $filters['cc'] === $courseCode ? ' selected' : ''; ?>><?php echo instructorH($courseCode); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="instructor-form-actions">
                                <button type="submit" class="instructor-btn" name="search">Search</button>
                            </div>
                        </form>
                        <?php if ($hasSearch) { ?>
                            <?php if ($assignments) { ?>
                                <div class="instructor-table-wrap">
                                    <table cellpadding="1" cellspacing="1" id="resultTable">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Assignment Number</th>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Department</th>
                                                <th>Student Class Year</th>
                                                <th>Semister</th>
                                                <th>Submitted Date</th>
                                                <th>File Name</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($assignments as $assignment) { ?>
                                                <tr>
                                                    <td><?php echo instructorH($assignment['U_ID'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['asno'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['ccode'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['cname'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['department'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['Student_class_year'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['semister'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['Submission_date'] ?? ''); ?></td>
                                                    <td><?php echo instructorH($assignment['fileName'] ?? ''); ?></td>
                                                    <td>
                                                        <?php if (!empty($assignment['fileName'])) { ?>
                                                            <a class="instructor-inline-link" href="../material/assignment/<?php echo rawurlencode((string) $assignment['fileName']); ?>">Download</a>
                                                        <?php } else { ?>
                                                            <span>-</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="instructor-empty-state">There is no submitted assignment for the selected filters.</div>
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
<?php instructorRenderIconScripts(); ?>
</body>
</html>