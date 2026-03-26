<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
require_once("ps_pagination.php");

departmentRequireLogin();

$departmentName = departmentCurrentDepartmentName($conn);
$escapedDepartment = mysqli_real_escape_string($conn, $departmentName);
$sql = "SELECT s.S_ID, s.FName, s.LName, s.Sex, s.College, s.Department, s.year, s.section, s.semister
        FROM student s
        INNER JOIN entrance_exam e ON e.S_ID = s.S_ID AND e.status = 'satisfactory'
        WHERE s.Department = '{$escapedDepartment}' AND s.year = '1st' AND s.semister = 'I'
        ORDER BY s.section ASC, s.S_ID ASC";
$pager = new PS_Pagination($conn, $sql, 10, 5);
$rs = $pager->paginate();
$rows = [];
if ($rs instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($rs)) {
        $rows[] = $row;
    }
    mysqli_free_result($rs);
}
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total
    FROM student s
    INNER JOIN entrance_exam e ON e.S_ID = s.S_ID AND e.status = 'satisfactory'
    WHERE s.Department = '{$escapedDepartment}' AND s.year = '1st' AND s.semister = 'I'");
$total = 0;
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $total = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

$actions = '';
if ($departmentName !== '') {
    $actions = '<a href="sectiongenerate.php?id=' . rawurlencode($departmentName) . '" class="department-link-btn">Arrange class for all students</a>';
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "View students",
    "Review first-year students in the department and arrange sections using the same wider standard layout.",
    $actions
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Eligible students: <?php echo $total; ?></span>
    <?php if ($departmentName !== '') { ?>
    <span class="department-stat-chip"><?php echo departmentH($departmentName); ?></span>
    <?php } ?>
</div>

<?php if (!$rows) { ?>
<div class="department-empty">No satisfactory first-year student records were found for this department.</div>
<?php } else { ?>
<div class="department-table-wrap">
    <table border="1" id="resultTable" width="100%" cellspacing="0">
        <tr>
            <th>S_ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Sex</th>
            <th>College</th>
            <th>Department</th>
            <th>Year</th>
            <th>Section</th>
            <th>Semister</th>
        </tr>
        <?php foreach ($rows as $row) { ?>
        <tr>
            <td><?php echo departmentH($row['S_ID']); ?></td>
            <td><?php echo departmentH($row['FName']); ?></td>
            <td><?php echo departmentH($row['LName']); ?></td>
            <td><?php echo departmentH($row['Sex']); ?></td>
            <td><?php echo departmentH($row['College']); ?></td>
            <td><?php echo departmentH($row['Department']); ?></td>
            <td><?php echo departmentH($row['year']); ?></td>
            <td><?php echo departmentH($row['section']); ?></td>
            <td><?php echo departmentH($row['semister']); ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<div class="department-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
