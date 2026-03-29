<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$studentId = studentCurrentUserId();
$studentInfo = null;
$entranceRows = array();

if ($studentId !== '') {
    $studentStmt = mysqli_prepare($conn, "SELECT Department, section FROM student WHERE S_ID = ? LIMIT 1");
    if ($studentStmt) {
        mysqli_stmt_bind_param($studentStmt, 's', $studentId);
        mysqli_stmt_execute($studentStmt);
        $studentResult = mysqli_stmt_get_result($studentStmt);
        $studentInfo = $studentResult instanceof mysqli_result ? mysqli_fetch_assoc($studentResult) : null;
        if ($studentResult instanceof mysqli_result) {
            mysqli_free_result($studentResult);
        }
        mysqli_stmt_close($studentStmt);
    }

    $entranceStmt = mysqli_prepare($conn, "SELECT S_ID, result, year, status FROM entrance_exam WHERE S_ID = ? ORDER BY year DESC");
    if ($entranceStmt) {
        mysqli_stmt_bind_param($entranceStmt, 's', $studentId);
        mysqli_stmt_execute($entranceStmt);
        $entranceResult = mysqli_stmt_get_result($entranceStmt);
        if ($entranceResult instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($entranceResult)) {
                $entranceRows[] = $row;
            }
            mysqli_free_result($entranceResult);
        }
        mysqli_stmt_close($entranceStmt);
    }

    if (!empty($entranceRows)) {
        $seenStmt = mysqli_prepare($conn, "UPDATE entrance_exam SET account = 'seen' WHERE S_ID = ?");
        if ($seenStmt) {
            mysqli_stmt_bind_param($seenStmt, 's', $studentId);
            mysqli_stmt_execute($seenStmt);
            mysqli_stmt_close($seenStmt);
        }
    }
}

studentRenderPageStart(
    "Entrance results",
    "Entrance Exam",
    "View Entrance Exam Result",
    "This page shows the entrance-exam records currently attached to your student account and marks them as seen once viewed.",
    array('include_table_css' => true)
);
?>
<?php if (empty($entranceRows)) { ?>
    <div class="student-empty-state">No entrance-exam result was found for your student account.</div>
<?php } else { ?>
    <div class="student-table-wrap">
        <table cellpadding="1" cellspacing="1" id="resultTable">
            <thead>
                <tr>
                    <th>Temo ID</th>
                    <th>Result</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($entranceRows as $entranceRow) { ?>
                <tr>
                    <td><?php echo studentH($entranceRow['S_ID'] ?? ''); ?></td>
                    <td><?php echo studentH($entranceRow['result'] ?? ''); ?></td>
                    <td><?php echo studentH($studentInfo['Department'] ?? studentSessionValue('sdpt')); ?></td>
                    <td><?php echo studentH($entranceRow['year'] ?? ''); ?></td>
                    <td><?php echo studentH($entranceRow['status'] ?? ''); ?></td>
                    <td><?php echo studentH($studentInfo['section'] ?? studentSessionValue('ssection')); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
