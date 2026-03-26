<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$semesterOne = [];
$semesterTwo = [];

$result = mysqli_query($conn, "SELECT no, dates, activities FROM acadamic_calender WHERE semister = 'Semister one' ORDER BY no ASC");
if ($result instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $semesterOne[] = $row;
    }
    mysqli_free_result($result);
}

$result = mysqli_query($conn, "SELECT no, dates, activities FROM acadamic_calender WHERE semister = 'Semister two' ORDER BY no ASC");
if ($result instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $semesterTwo[] = $row;
    }
    mysqli_free_result($result);
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Academic schedule",
    "Track the academic calendar for both semesters from the standard department view."
);
?>
<div class="department-card-grid">
    <div class="department-section">
        <h3 style="margin-top:0;">Semester one</h3>
        <?php if (!$semesterOne) { ?>
        <div class="department-empty">No academic schedule has been posted for semester one.</div>
        <?php } else { ?>
        <div class="department-table-wrap">
            <table id="resultTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Dates</th>
                        <th>Activities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($semesterOne as $row) { ?>
                    <tr>
                        <td><?php echo departmentH($row['no']); ?></td>
                        <td><?php echo departmentH($row['dates']); ?></td>
                        <td><?php echo departmentH($row['activities']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
    <div class="department-section">
        <h3 style="margin-top:0;">Semester two</h3>
        <?php if (!$semesterTwo) { ?>
        <div class="department-empty">No academic schedule has been posted for semester two.</div>
        <?php } else { ?>
        <div class="department-table-wrap">
            <table id="resultTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Dates</th>
                        <th>Activities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($semesterTwo as $row) { ?>
                    <tr>
                        <td><?php echo departmentH($row['no']); ?></td>
                        <td><?php echo departmentH($row['dates']); ?></td>
                        <td><?php echo departmentH($row['activities']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>
<?php
departmentRenderPageEnd();
?>
