<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
require_once("ps_pagination.php");

departmentRequireLogin();

$userId = departmentCurrentUserId();
$escapedUserId = mysqli_real_escape_string($conn, $userId);
$type = 'iexam';
$sql = "SELECT * FROM payment_table WHERE UID='{$escapedUserId}' AND type='{$type}' ORDER BY no DESC";
$pager = new PS_Pagination($conn, $sql, 10, 5);
$rs = $pager->paginate();
$rows = [];
if ($rs instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($rs)) {
        $rows[] = $row;
    }
    mysqli_free_result($rs);
}
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM payment_table WHERE UID='{$escapedUserId}' AND type='{$type}'");
$total = 0;
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $total = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Final exam invigilation workload",
    "Review the invigilation records submitted by instructors for final examinations."
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Records found: <?php echo $total; ?></span>
</div>

<?php if (!$rows) { ?>
<div class="department-empty">No invigilation workload records were found for your account.</div>
<?php } else { ?>
<fieldset>
    <legend><b>List of instructors who have participated in invigilating final exams</b></legend>
    <div class="department-table-wrap">
        <table border="1" id="resultTable" cellspacing="0" width="100%">
            <tr bgcolor="#CAE8EA">
                <th>No</th>
                <th>Sender UID</th>
                <th>Instructor name</th>
                <th>Course code</th>
                <th>No. of sections</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?php echo departmentH($row['no']); ?></td>
                <td><?php echo departmentH($row['UID']); ?></td>
                <td><?php echo departmentH($row['Instructors_Name']); ?></td>
                <td><?php echo departmentH($row['Course_Code']); ?></td>
                <td><?php echo departmentH($row['No_of_Sections']); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</fieldset>
<div class="department-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
