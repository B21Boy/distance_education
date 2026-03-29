<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$departmentCode = departmentCurrentDepartmentCode();
$departmentName = departmentCurrentDepartmentName($conn);
$status = (string) ($_GET['status'] ?? '');
$messages = [
    'success' => 'Course registered successfully.',
    'empty' => 'All course fields are required.',
    'invalid-code' => 'Course code must use only letters, numbers, or hyphen.',
    'invalid-credit' => 'Credit hour must be a valid positive number.',
    'invalid-year' => 'Academic year must be a valid 4-digit year.',
    'exists' => 'That course code or course title is already registered.',
    'error' => 'The course could not be registered right now.'
];
$courses = departmentFetchCourses($conn);

$actions = '<a rel="facebox" href="addcourse.php" class="department-btn">Add course</a>';

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Manage courses",
    "Register and review department courses from the same wider layout used by the updated department pages.",
    $actions
);
?>
<?php echo departmentStatusBanner($status, $messages); ?>
<div class="department-stat-row">
    <span class="department-stat-chip">Courses found: <?php echo count($courses); ?></span>
    <?php if ($departmentCode !== '') { ?>
    <span class="department-stat-chip">Department code: <?php echo departmentH($departmentCode); ?></span>
    <?php } ?>
    <?php if ($departmentName !== '') { ?>
    <span class="department-stat-chip"><?php echo departmentH($departmentName); ?></span>
    <?php } ?>
</div>

<?php if (!$courses) { ?>
<div class="department-empty">No courses are registered for this department yet.</div>
<?php } else { ?>
<div class="department-table-wrap">
    <table cellpadding="1" cellspacing="1" id="resultTable">
        <thead>
            <tr>
                <th style="border-left: 1px solid #C1DAD7">Course code</th>
                <th style="border-left: 1px solid #C1DAD7">Course name</th>
                <th style="border-left: 1px solid #C1DAD7">Credit hour</th>
                <th>Academic year</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) { ?>
            <tr class="record">
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($course['course_code']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($course['cname']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($course['chour']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($course['ayear']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($course['department']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
