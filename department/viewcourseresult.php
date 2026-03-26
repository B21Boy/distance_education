<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
require_once("ps_pagination.php");

departmentRequireLogin();

$departmentName = departmentCurrentDepartmentName($conn);
$escapedDepartment = mysqli_real_escape_string($conn, $departmentName);
$sql = "SELECT * FROM course_result WHERE status = 'approved' AND Department = '{$escapedDepartment}' ORDER BY no DESC";
$pager = new PS_Pagination($conn, $sql, 5, 5);
$rs = $pager->paginate();
$rows = [];
$fields = [];
if ($rs instanceof mysqli_result) {
    foreach (mysqli_fetch_fields($rs) as $field) {
        if ($field->name !== 'status') {
            $fields[] = $field->name;
        }
    }
    while ($row = mysqli_fetch_assoc($rs)) {
        $rows[] = $row;
    }
    mysqli_free_result($rs);
}
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM course_result WHERE status = 'approved' AND Department = '{$escapedDepartment}'");
$total = 0;
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $total = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Approved course results",
    "View course results that have already been approved for this department."
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Approved results: <?php echo $total; ?></span>
    <?php if ($departmentName !== '') { ?>
    <span class="department-stat-chip"><?php echo departmentH($departmentName); ?></span>
    <?php } ?>
</div>

<?php if (!$rows) { ?>
<div class="department-empty">No approved course results were found for this department.</div>
<?php } else { ?>
<div class="department-table-wrap">
    <table cellpadding="1" cellspacing="1" id="resultTable">
        <tr>
            <?php foreach ($fields as $fieldName) { ?>
            <th><?php echo departmentH($fieldName); ?></th>
            <?php } ?>
        </tr>
        <?php foreach ($rows as $row) { ?>
        <tr>
            <?php foreach ($fields as $fieldName) { ?>
            <td><?php echo departmentH($row[$fieldName] ?? ''); ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
</div>
<div class="department-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
