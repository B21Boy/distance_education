<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$departmentCode = departmentCurrentDepartmentCode();
$departmentName = departmentCurrentDepartmentName($conn);
$status = (string) ($_GET['status'] ?? '');
$messages = [
    'assigned' => 'Instructor assigned successfully.',
    'empty' => 'All assignment fields are required.',
    'invalid-course' => 'The selected course could not be found.',
    'invalid-instructor' => 'The selected instructor could not be found.',
    'already-assigned' => 'This course already has an assigned instructor.',
    'error' => 'The instructor could not be assigned right now.'
];
$courses = departmentFetchCourses($conn);

$actions = '';
if ($departmentCode !== '') {
    $actions = '<a href="viewassigndinst.php?id=' . rawurlencode($departmentCode) . '" class="department-link-btn">View assigned instructor</a>';
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Assign instructor",
    "Review all courses under your department and assign or update the responsible instructor for each one.",
    $actions
);
?>
<?php echo departmentStatusBanner($status, $messages); ?>
<div class="department-stat-row">
    <span class="department-stat-chip">Courses found: <?php echo count($courses); ?></span>
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
                <th>Assign instructor</th>
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
                <td><div align="center"><a rel="facebox" href="assign_course_instructorS.php?id=<?php echo rawurlencode((string) $course['course_code']); ?>">Assign</a></div></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
