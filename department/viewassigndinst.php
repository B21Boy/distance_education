<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$departmentCode = trim((string) ($_GET['id'] ?? departmentCurrentDepartmentCode()));
$currentDepartmentCode = departmentCurrentDepartmentCode();
$departmentName = '';
$assignments = [];

if ($departmentCode !== '') {
    $departmentStmt = mysqli_prepare($conn, "SELECT DName FROM department WHERE Dcode = ? LIMIT 1");
    if ($departmentStmt) {
        mysqli_stmt_bind_param($departmentStmt, 's', $departmentCode);
        mysqli_stmt_execute($departmentStmt);
        mysqli_stmt_bind_result($departmentStmt, $resolvedDepartmentName);
        if (mysqli_stmt_fetch($departmentStmt)) {
            $departmentName = trim((string) $resolvedDepartmentName);
        }
        mysqli_stmt_close($departmentStmt);
    }
}

if ($departmentName === '' && $currentDepartmentCode !== '') {
    $departmentName = departmentCurrentDepartmentName($conn);
}

if ($departmentName !== '' || $departmentCode !== '') {
    $filters = [];
    $params = [];
    $types = '';

    if ($departmentName !== '') {
        $filters[] = '(ai.department = ? OR c.department = ?)';
        $params[] = $departmentName;
        $params[] = $departmentName;
        $types .= 'ss';
    }

    if ($departmentCode !== '' && $departmentCode !== $departmentName) {
        $filters[] = 'c.department = ?';
        $params[] = $departmentCode;
        $types .= 's';
    }

    $sql = "SELECT ai.no, ai.corse_code, ai.cname, ai.Iname, ai.department, ai.section,
                   ai.Student_class_year, ai.semister, ai.chour, ai.ayear,
                   COALESCE(c.chour, ai.chour) AS course_chour,
                   COALESCE(c.ayear, ai.ayear) AS course_ayear
            FROM assign_instructor ai
            LEFT JOIN course c ON c.course_code = ai.corse_code";
    if ($filters) {
        $sql .= " WHERE " . implode(' OR ', $filters);
    }
    $sql .= " ORDER BY ai.corse_code ASC";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        if ($types !== '') {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $assignments[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}

$actions = '';
if ($currentDepartmentCode !== '') {
    $actions = '<a href="manageinst.php" class="department-link-btn">Back to assign instructor</a>';
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "View assigned instructor",
    "Review the instructors already assigned to your department courses and open the update popup when you need to change the assignment.",
    $actions
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Assigned courses: <?php echo count($assignments); ?></span>
    <?php if ($departmentName !== '') { ?>
    <span class="department-stat-chip"><?php echo departmentH($departmentName); ?></span>
    <?php } ?>
    <?php if ($departmentCode !== '') { ?>
    <span class="department-stat-chip">Department code: <?php echo departmentH($departmentCode); ?></span>
    <?php } ?>
</div>

<?php if (!$assignments) { ?>
<div class="department-empty">No assigned instructor record was found for this department yet.</div>
<?php } else { ?>
<div class="department-table-wrap">
    <table cellpadding="1" cellspacing="1" id="resultTable">
        <thead>
            <tr>
                <th style="border-left: 1px solid #C1DAD7">Course code</th>
                <th style="border-left: 1px solid #C1DAD7">Course title</th>
                <th style="border-left: 1px solid #C1DAD7">Instructor name</th>
                <th style="border-left: 1px solid #C1DAD7">Department</th>
                <th>Section</th>
                <th>Student class year</th>
                <th>Semester</th>
                <th>Credit hour</th>
                <th>Academic year</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $assignment) { ?>
            <tr class="record">
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['corse_code']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['cname']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['Iname']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['department']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['section']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['Student_class_year']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['semister']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['course_chour']); ?></td>
                <td style="border-left: 1px solid #C1DAD7;"><?php echo departmentH($assignment['course_ayear']); ?></td>
                <td>
                    <div align="center">
                        <a rel="facebox" href="assign_course_instructorSu.php?id=<?php echo rawurlencode((string) $assignment['corse_code']); ?>">Update</a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
