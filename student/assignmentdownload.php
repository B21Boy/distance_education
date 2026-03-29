<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$department = studentSessionValue('sdpt');
$year = studentSessionValue('syear');
$semester = studentSessionValue('ssemister');
$assignments = array();

if ($department !== '' && $year !== '' && $semester !== '') {
    $sql = "SELECT a.no, a.asno, a.assignment_value, a.ccode, a.cname, a.department,
                   a.Student_class_year, a.semister, a.Submission_date, a.fileName,
                   COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), a.U_ID) AS instructor_name
            FROM assignment a
            LEFT JOIN user u ON u.UID = a.U_ID
            WHERE a.department = ?
              AND a.Student_class_year = ?
              AND a.semister = ?
              AND a.status = 'inst'
            ORDER BY a.Submission_date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $department, $year, $semester);
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

studentRenderPageStart(
    "Download assignment",
    "Assignments",
    "Download Assignment Files",
    "These are the published assignment files currently available for your department, class year, and semester.",
    array('include_table_css' => true)
);
?>
<div class="student-stat-row">
    <?php if ($department !== '') { ?><span class="student-stat-chip">Department: <?php echo studentH($department); ?></span><?php } ?>
    <?php if ($year !== '') { ?><span class="student-stat-chip">Year: <?php echo studentH($year); ?></span><?php } ?>
    <?php if ($semester !== '') { ?><span class="student-stat-chip">Semester: <?php echo studentH($semester); ?></span><?php } ?>
</div>

<?php if (empty($assignments)) { ?>
    <div class="student-empty-state">No assignment files are currently posted for your class.</div>
<?php } else { ?>
    <div class="student-table-wrap">
        <table cellpadding="1" cellspacing="1" id="resultTable">
            <thead>
                <tr>
                    <th>Instructor</th>
                    <th>Assignment No</th>
                    <th>Assignment Value</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Department</th>
                    <th>Class Year</th>
                    <th>Semester</th>
                    <th>Submission Date</th>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($assignments as $assignment) {
                $fileName = trim((string) ($assignment['fileName'] ?? ''));
                ?>
                <tr>
                    <td><?php echo studentH($assignment['instructor_name'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['asno'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['assignment_value'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['ccode'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['cname'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['department'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['Student_class_year'] ?? ''); ?></td>
                    <td><?php echo studentH($assignment['semister'] ?? ''); ?></td>
                    <td><?php echo studentH(studentFormatDate($assignment['Submission_date'] ?? '', 'M j, Y')); ?></td>
                    <td><?php echo studentH($fileName); ?></td>
                    <td>
                        <?php if ($fileName !== '') { ?>
                            <a class="student-action-link secondary" href="../material/assignment/<?php echo rawurlencode($fileName); ?>">Download</a>
                        <?php } else { ?>
                            <span class="student-form-note">Missing file</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
