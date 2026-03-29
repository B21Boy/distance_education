<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$department = studentSessionValue('sdpt');
$year = studentSessionValue('syear');
$section = studentSessionValue('ssection');
$semester = studentSessionValue('ssemister');
$studentId = studentCurrentUserId();
$rows = array();

if ($department !== '' && $year !== '' && $section !== '' && $semester !== '' && $studentId !== '') {
    $stmt = mysqli_prepare($conn, "SELECT * FROM course_result WHERE Department = ? AND year = ? AND semister = ? AND section = ? AND S_ID = ? ORDER BY no DESC");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssss', $department, $year, $semester, $section, $studentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}

$excludedColumns = array('no', 'status', 'status2', 'uid', 'reject');
$visibleColumns = array();
if (!empty($rows)) {
    foreach (array_keys($rows[0]) as $columnName) {
        if (!in_array($columnName, $excludedColumns, true)) {
            $visibleColumns[] = $columnName;
        }
    }
}

studentRenderPageStart(
    "Course results",
    "Course Results",
    "View Course Result Rows",
    "This table shows the course-result records stored against your student ID for the active department, year, semester, and section.",
    array('include_table_css' => true)
);
?>
<div class="student-stat-row">
    <?php if ($department !== '') { ?><span class="student-stat-chip">Department: <?php echo studentH($department); ?></span><?php } ?>
    <?php if ($year !== '') { ?><span class="student-stat-chip">Year: <?php echo studentH($year); ?></span><?php } ?>
    <?php if ($semester !== '') { ?><span class="student-stat-chip">Semester: <?php echo studentH($semester); ?></span><?php } ?>
    <?php if ($section !== '') { ?><span class="student-stat-chip">Section: <?php echo studentH($section); ?></span><?php } ?>
</div>

<?php if (empty($rows) || empty($visibleColumns)) { ?>
    <div class="student-empty-state">No course-result rows were found for your current student record.</div>
<?php } else { ?>
    <div class="student-table-wrap">
        <table cellpadding="1" cellspacing="1" id="resultTable">
            <thead>
                <tr>
                    <?php foreach ($visibleColumns as $columnName) { ?>
                        <th><?php echo studentH($columnName); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <?php foreach ($visibleColumns as $columnName) { ?>
                        <td><?php echo studentH($row[$columnName] ?? ''); ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
