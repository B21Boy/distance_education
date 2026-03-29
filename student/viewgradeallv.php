<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$studentId = studentCurrentUserId();
$departmentCode = studentSessionValue('sdcode');
$section = studentSessionValue('ssection');
$studentYear = studentSessionValue('syear');
$studentInfo = null;
$gradeSummary = null;
$courseRows = array();

if ($studentId !== '') {
    $studentStmt = mysqli_prepare($conn, "SELECT FName, mname, LName, Sex, Department, year, semister, section FROM student WHERE S_ID = ? LIMIT 1");
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
}

if ($departmentCode !== '' && $studentYear !== '' && $section !== '' && $studentId !== '') {
    $gradeStmt = mysqli_prepare($conn, "SELECT ptcrh, ptgpoint, pgpa FROM grade WHERE department = ? AND year = ? AND section = ? AND status = 'approved' AND checking = 'pending' AND sid = ? LIMIT 1");
    if ($gradeStmt) {
        mysqli_stmt_bind_param($gradeStmt, 'ssss', $departmentCode, $studentYear, $section, $studentId);
        mysqli_stmt_execute($gradeStmt);
        $gradeResult = mysqli_stmt_get_result($gradeStmt);
        $gradeSummary = $gradeResult instanceof mysqli_result ? mysqli_fetch_assoc($gradeResult) : null;
        if ($gradeResult instanceof mysqli_result) {
            mysqli_free_result($gradeResult);
        }
        mysqli_stmt_close($gradeStmt);
    }
}

if ($studentInfo) {
    $courseStmt = mysqli_prepare(
        $conn,
        "SELECT cr.C_Code, cr.Grade, c.chour
         FROM course_result cr
         LEFT JOIN course c ON c.course_code = cr.C_Code
         WHERE cr.department = ?
           AND cr.year = ?
           AND cr.semister = ?
           AND cr.section = ?
           AND cr.S_ID = ?
           AND cr.status = 'approved'
           AND cr.status2 = 'pending'
         ORDER BY cr.C_Code ASC"
    );
    if ($courseStmt) {
        $departmentName = trim((string) ($studentInfo['Department'] ?? ''));
        $yearName = trim((string) ($studentInfo['year'] ?? ''));
        $semesterName = trim((string) ($studentInfo['semister'] ?? ''));
        $sectionName = trim((string) ($studentInfo['section'] ?? ''));
        mysqli_stmt_bind_param($courseStmt, 'sssss', $departmentName, $yearName, $semesterName, $sectionName, $studentId);
        mysqli_stmt_execute($courseStmt);
        $courseResult = mysqli_stmt_get_result($courseStmt);
        if ($courseResult instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($courseResult)) {
                $courseRows[] = $row;
            }
            mysqli_free_result($courseResult);
        }
        mysqli_stmt_close($courseStmt);
    }
}

$semesterCredits = 0.0;
$semesterPoints = 0.0;
foreach ($courseRows as $courseRow) {
    $creditHours = (float) ($courseRow['chour'] ?? 0);
    $semesterCredits += $creditHours;
    $semesterPoints += $creditHours * studentGradePointValue($courseRow['Grade'] ?? '');
}

$semesterGpa = $semesterCredits > 0 ? round($semesterPoints / $semesterCredits, 2) : 0.0;
$previousCredits = (float) ($gradeSummary['ptcrh'] ?? 0);
$previousPoints = (float) ($gradeSummary['ptgpoint'] ?? 0);
$previousGpa = (float) ($gradeSummary['pgpa'] ?? 0);
$cumulativeCredits = $previousCredits + $semesterCredits;
$cumulativePoints = $previousPoints + $semesterPoints;
$cumulativeGpa = $cumulativeCredits > 0 ? round($cumulativePoints / $cumulativeCredits, 2) : 0.0;

studentRenderPageStart(
    "Grade report",
    "Grade Report",
    "View Semester Grade Report",
    "This report is built from the approved grade and course-result records already stored for your student account.",
    array('include_table_css' => true)
);
?>
<?php if (!$studentInfo || !$gradeSummary) { ?>
    <div class="student-empty-state">No approved grade report is available for your current student record.</div>
<?php } else { ?>
    <div class="student-summary-grid">
        <div class="student-summary-card">
            <h3>Previous Total</h3>
            <p>Credit Hours: <?php echo studentH($previousCredits); ?></p>
            <p>Grade Points: <?php echo studentH($previousPoints); ?></p>
            <p>GPA: <?php echo studentH(round($previousGpa, 2)); ?></p>
        </div>
        <div class="student-summary-card">
            <h3>Semester Total</h3>
            <p>Credit Hours: <?php echo studentH($semesterCredits); ?></p>
            <p>Grade Points: <?php echo studentH($semesterPoints); ?></p>
            <p>GPA: <?php echo studentH($semesterGpa); ?></p>
        </div>
        <div class="student-summary-card">
            <h3>Cumulative</h3>
            <p>Credit Hours: <?php echo studentH($cumulativeCredits); ?></p>
            <p>Grade Points: <?php echo studentH($cumulativePoints); ?></p>
            <p>GPA: <?php echo studentH($cumulativeGpa); ?></p>
        </div>
    </div>

    <div class="student-inline-card-grid">
        <div class="student-inline-card">
            <h3>Student Information</h3>
            <p>Name: <?php echo studentH(trim(($studentInfo['FName'] ?? '') . ' ' . ($studentInfo['mname'] ?? '') . ' ' . ($studentInfo['LName'] ?? ''))); ?></p>
            <p>Temo ID: <?php echo studentH($studentId); ?></p>
            <p>Sex: <?php echo studentH($studentInfo['Sex'] ?? ''); ?></p>
            <p>Department: <?php echo studentH($studentInfo['Department'] ?? ''); ?></p>
            <p>Year: <?php echo studentH($studentInfo['year'] ?? ''); ?></p>
            <p>Semester: <?php echo studentH($studentInfo['semister'] ?? ''); ?></p>
            <p>Section: <?php echo studentH($studentInfo['section'] ?? ''); ?></p>
        </div>
    </div>

    <?php if (empty($courseRows)) { ?>
        <div class="student-empty-state">No approved course-result rows were found for this grade report.</div>
    <?php } else { ?>
        <div class="student-table-wrap">
            <table cellpadding="1" cellspacing="1" id="resultTable">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Credit Hour</th>
                        <th>Grade</th>
                        <th>Grade Point</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($courseRows as $courseRow) {
                    $creditHours = (float) ($courseRow['chour'] ?? 0);
                    $grade = trim((string) ($courseRow['Grade'] ?? ''));
                    $gradePoints = $creditHours * studentGradePointValue($grade);
                    ?>
                    <tr>
                        <td><?php echo studentH($courseRow['C_Code'] ?? ''); ?></td>
                        <td><?php echo studentH($creditHours); ?></td>
                        <td><?php echo studentH($grade); ?></td>
                        <td><?php echo studentH($gradePoints); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
<?php } ?>
<?php
studentRenderPageEnd();
?>
