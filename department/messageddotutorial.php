<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
require_once("ps_pagination.php");

departmentRequireLogin();

$userId = departmentCurrentUserId();
$escapedUserId = mysqli_real_escape_string($conn, $userId);
$type = 'tutorial';
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
    "Tutorial workload records",
    "Review instructors who reported tutorial participation for your department payment workflow."
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Records found: <?php echo $total; ?></span>
</div>

<?php if (!$rows) { ?>
<div class="department-empty">No tutorial workload records were found for your account.</div>
<?php } else { ?>
<fieldset>
    <legend><b>List of instructors who have participated in offering tutorial program</b></legend>
    <div class="department-table-wrap">
        <table border="1" id="resultTable" cellspacing="0">
            <tr bgcolor="#CAE8EA">
                <th rowspan="2">No</th>
                <th rowspan="2">Sender UID</th>
                <th rowspan="2">Tutor name</th>
                <th rowspan="2">Rank</th>
                <th rowspan="2">Course code</th>
                <th rowspan="2">Cr Hr</th>
                <th colspan="3">Students who have taken the course</th>
                <th rowspan="2">Tutorial hours</th>
            </tr>
            <tr bgcolor="#CAE8EA">
                <th>Department</th>
                <th>Year</th>
                <th>Section</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?php echo departmentH($row['no']); ?></td>
                <td><?php echo departmentH($row['UID']); ?></td>
                <td><?php echo departmentH($row['Instructors_Name']); ?></td>
                <td><?php echo departmentH($row['Rank']); ?></td>
                <td><?php echo departmentH($row['Course_Code']); ?></td>
                <td><?php echo departmentH($row['CrHr']); ?></td>
                <td><?php echo departmentH($row['Department']); ?></td>
                <td><?php echo departmentH($row['Year']); ?></td>
                <td><?php echo departmentH($row['Section']); ?></td>
                <td><?php echo departmentH($row['No_of_hours_she_he_gave_tutorial']); ?></td>
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
