<?php
session_start();
require_once("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

function registrarViewGradeFilterValue(string $key): string
{
    return isset($_SESSION[$key]) ? trim((string) $_SESSION[$key]) : '';
}

function registrarViewGradePointValue(string $grade): float
{
    $grade = strtoupper(trim($grade));
    $map = array(
        'A+' => 4.00,
        'A' => 4.00,
        'A-' => 3.75,
        'B+' => 3.50,
        'B' => 3.00,
        'B-' => 2.75,
        'C+' => 2.50,
        'C' => 2.00,
        'C-' => 1.75,
        'D' => 1.00,
        'F' => 0.00,
    );

    return $map[$grade] ?? 0.00;
}

function registrarViewGradeNumber(float $value): string
{
    if (abs($value - round($value)) < 0.00001) {
        return (string) (int) round($value);
    }

    return number_format($value, 2, '.', '');
}

function registrarViewGradeStudentInfo(mysqli $conn, string $studentId): ?array
{
    $stmt = mysqli_prepare(
        $conn,
        "SELECT S_ID, FName, mname, LName, Sex, Department, year, semister, section
         FROM student
         WHERE S_ID = ?
         LIMIT 1"
    );
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, 's', $studentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;

    if ($result instanceof mysqli_result) {
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);

    return $row ?: null;
}

function registrarViewGradeCourseRows(mysqli $conn, array $filter, string $studentId): array
{
    $rows = array();
    $stmt = mysqli_prepare(
        $conn,
        "SELECT cr.C_Code, cr.Grade, COALESCE(c.chour, 0) AS chour
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
    if (!$stmt) {
        return $rows;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'sssss',
        $filter['department'],
        $filter['year'],
        $filter['semester'],
        $filter['section'],
        $studentId
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function registrarViewGradePendingStudentIds(mysqli $conn, array $filter): array
{
    $ids = array();
    $stmt = mysqli_prepare(
        $conn,
        "SELECT DISTINCT S_ID
         FROM course_result
         WHERE department = ?
           AND year = ?
           AND semister = ?
           AND section = ?
           AND status = 'approved'
           AND status2 = 'pending'
         ORDER BY S_ID ASC"
    );
    if (!$stmt) {
        return $ids;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $filter['department'],
        $filter['year'],
        $filter['semester'],
        $filter['section']
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentId = trim((string) ($row['S_ID'] ?? ''));
            if ($studentId !== '') {
                $ids[] = $studentId;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $ids;
}

function registrarViewGradeSavedDraftRows(mysqli $conn, array $filter): array
{
    $rows = array();
    $stmt = mysqli_prepare(
        $conn,
        "SELECT no, sid, stcrh, stgpoint, sgpa, ptcrh, ptgpoint, pgpa, ncgpa
         FROM grade
         WHERE department = ?
           AND year = ?
           AND semister = ?
           AND section = ?
           AND status = 'approve'
           AND checking = 'pending'
         ORDER BY sid ASC"
    );
    if (!$stmt) {
        return $rows;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $filter['department'],
        $filter['year'],
        $filter['semester'],
        $filter['section']
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function registrarViewGradePreviousApprovedRow(mysqli $conn, array $filter, string $studentId): ?array
{
    $stmt = mysqli_prepare(
        $conn,
        "SELECT no, stcrh, stgpoint, sgpa
         FROM grade
         WHERE sid = ?
           AND department = ?
           AND year = ?
           AND section = ?
           AND status = 'approved'
           AND checking = 'pending'
         ORDER BY no DESC
         LIMIT 1"
    );
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $studentId,
        $filter['department'],
        $filter['year'],
        $filter['section']
    );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;

    if ($result instanceof mysqli_result) {
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);

    return $row ?: null;
}

function registrarViewGradeBuildRow(mysqli $conn, array $filter, string $studentId, ?array $savedDraft = null): ?array
{
    $student = registrarViewGradeStudentInfo($conn, $studentId);
    if (!$student) {
        return null;
    }

    $courseRows = registrarViewGradeCourseRows($conn, $filter, $studentId);
    $semesterCredits = 0.0;
    $semesterPoints = 0.0;

    foreach ($courseRows as &$courseRow) {
        $creditHours = (float) ($courseRow['chour'] ?? 0);
        $grade = trim((string) ($courseRow['Grade'] ?? ''));
        $gradePoints = $creditHours * registrarViewGradePointValue($grade);

        $courseRow['chour'] = $creditHours;
        $courseRow['grade_point'] = $gradePoints;

        $semesterCredits += $creditHours;
        $semesterPoints += $gradePoints;
    }
    unset($courseRow);

    $semesterGpa = $semesterCredits > 0 ? round($semesterPoints / $semesterCredits, 2) : 0.0;
    $previousGradeId = 0;

    if ($savedDraft) {
        $previousCredits = (float) ($savedDraft['ptcrh'] ?? 0);
        $previousPoints = (float) ($savedDraft['ptgpoint'] ?? 0);
        $previousGpa = (float) ($savedDraft['pgpa'] ?? 0);
        $cumulativeGpa = (float) ($savedDraft['ncgpa'] ?? 0);
        $existingDraftId = (int) ($savedDraft['no'] ?? 0);
    } else {
        $previousRow = registrarViewGradePreviousApprovedRow($conn, $filter, $studentId);
        $previousCredits = (float) ($previousRow['stcrh'] ?? 0);
        $previousPoints = (float) ($previousRow['stgpoint'] ?? 0);
        $previousGpa = (float) ($previousRow['sgpa'] ?? 0);
        $previousGradeId = (int) ($previousRow['no'] ?? 0);
        $existingDraftId = 0;
        $totalCredits = $previousCredits + $semesterCredits;
        $totalPoints = $previousPoints + $semesterPoints;
        $cumulativeGpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0.0;
    }

    $fullName = trim(
        (string) ($student['FName'] ?? '') . ' ' .
        (string) ($student['mname'] ?? '') . ' ' .
        (string) ($student['LName'] ?? '')
    );

    return array(
        'student_id' => $studentId,
        'student' => $student,
        'student_name' => $fullName,
        'course_rows' => $courseRows,
        'semester_credits' => $semesterCredits,
        'semester_points' => $semesterPoints,
        'semester_gpa' => $semesterGpa,
        'previous_credits' => $previousCredits,
        'previous_points' => $previousPoints,
        'previous_gpa' => $previousGpa,
        'cumulative_credits' => $previousCredits + $semesterCredits,
        'cumulative_points' => $previousPoints + $semesterPoints,
        'cumulative_gpa' => $cumulativeGpa,
        'previous_grade_id' => $previousGradeId,
        'existing_draft_id' => $existingDraftId,
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $_SESSION['dpt'] = trim((string) ($_POST['dpt'] ?? ''));
    $_SESSION['yea'] = trim((string) ($_POST['scy'] ?? ''));
    $_SESSION['sem'] = trim((string) ($_POST['sem'] ?? ''));
    $_SESSION['sec'] = trim((string) ($_POST['sec'] ?? ''));
}

$shouldAutoPrint = $_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['search']) || isset($_POST['auto_print']));

$filter = array(
    'department' => registrarViewGradeFilterValue('dpt'),
    'year' => registrarViewGradeFilterValue('yea'),
    'semester' => registrarViewGradeFilterValue('sem'),
    'section' => registrarViewGradeFilterValue('sec'),
);

if ($filter['department'] === '' || $filter['year'] === '' || $filter['semester'] === '' || $filter['section'] === '') {
    header("location:viewgrade.php");
    exit;
}

$flash = isset($_SESSION['viewgradeall_status']) && is_array($_SESSION['viewgradeall_status'])
    ? $_SESSION['viewgradeall_status']
    : null;
unset($_SESSION['viewgradeall_status']);

$savedDraftRows = registrarViewGradeSavedDraftRows($conn, $filter);
$reportRows = array();
$reportMode = !empty($savedDraftRows) ? 'saved' : 'preview';

if ($reportMode === 'saved') {
    foreach ($savedDraftRows as $savedDraftRow) {
        $studentId = trim((string) ($savedDraftRow['sid'] ?? ''));
        if ($studentId === '') {
            continue;
        }

        $reportRow = registrarViewGradeBuildRow($conn, $filter, $studentId, $savedDraftRow);
        if ($reportRow) {
            $reportRows[] = $reportRow;
        }
    }
} else {
    $studentIds = registrarViewGradePendingStudentIds($conn, $filter);
    foreach ($studentIds as $studentId) {
        $reportRow = registrarViewGradeBuildRow($conn, $filter, $studentId);
        if ($reportRow) {
            $reportRows[] = $reportRow;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_report'])) {
    if ($reportMode === 'saved') {
        $_SESSION['viewgradeall_status'] = array(
            'type' => 'info',
            'message' => 'This grade report has already been saved and is waiting for department approval.',
        );
        header("location:viewgradeall.php");
        exit;
    }

    if (empty($reportRows)) {
        $_SESSION['viewgradeall_status'] = array(
            'type' => 'error',
            'message' => 'No approved course results were found to save for this grade report.',
        );
        header("location:viewgradeall.php");
        exit;
    }

    $findDraftStmt = mysqli_prepare(
        $conn,
        "SELECT no
         FROM grade
         WHERE sid = ?
           AND department = ?
           AND year = ?
           AND semister = ?
           AND section = ?
           AND status = 'approve'
           AND checking = 'pending'
         LIMIT 1"
    );
    $insertDraftStmt = mysqli_prepare(
        $conn,
        "INSERT INTO grade
            (sid, department, year, semister, section, stcrh, stgpoint, sgpa, ptcrh, ptgpoint, pgpa, ncgpa, status, checking)
         VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'approve', 'pending')"
    );
    $updateDraftStmt = mysqli_prepare(
        $conn,
        "UPDATE grade
         SET stcrh = ?, stgpoint = ?, sgpa = ?, ptcrh = ?, ptgpoint = ?, pgpa = ?, ncgpa = ?
         WHERE no = ?"
    );
    $markPreviousStmt = mysqli_prepare($conn, "UPDATE grade SET checking = 'ok' WHERE no = ?");

    if (!$findDraftStmt || !$insertDraftStmt || !$updateDraftStmt || !$markPreviousStmt) {
        if ($findDraftStmt) {
            mysqli_stmt_close($findDraftStmt);
        }
        if ($insertDraftStmt) {
            mysqli_stmt_close($insertDraftStmt);
        }
        if ($updateDraftStmt) {
            mysqli_stmt_close($updateDraftStmt);
        }
        if ($markPreviousStmt) {
            mysqli_stmt_close($markPreviousStmt);
        }

        $_SESSION['viewgradeall_status'] = array(
            'type' => 'error',
            'message' => 'The database connection is available, but the grade report could not be prepared for saving.',
        );
        header("location:viewgradeall.php");
        exit;
    }

    $savedCount = 0;
    mysqli_begin_transaction($conn);

    try {
        foreach ($reportRows as $reportRow) {
            $studentId = (string) $reportRow['student_id'];
            $semesterCredits = (float) $reportRow['semester_credits'];
            $semesterPoints = (float) $reportRow['semester_points'];
            $semesterGpa = (float) $reportRow['semester_gpa'];
            $previousCredits = (float) $reportRow['previous_credits'];
            $previousPoints = (float) $reportRow['previous_points'];
            $previousGpa = (float) $reportRow['previous_gpa'];
            $cumulativeGpa = (float) $reportRow['cumulative_gpa'];
            $previousGradeId = (int) $reportRow['previous_grade_id'];

            mysqli_stmt_bind_param(
                $findDraftStmt,
                'sssss',
                $studentId,
                $filter['department'],
                $filter['year'],
                $filter['semester'],
                $filter['section']
            );
            if (!mysqli_stmt_execute($findDraftStmt)) {
                throw new RuntimeException(mysqli_stmt_error($findDraftStmt));
            }
            $existingResult = mysqli_stmt_get_result($findDraftStmt);
            $existingDraft = $existingResult instanceof mysqli_result ? mysqli_fetch_assoc($existingResult) : null;
            if ($existingResult instanceof mysqli_result) {
                mysqli_free_result($existingResult);
            }

            if ($existingDraft) {
                $draftId = (int) ($existingDraft['no'] ?? 0);
                mysqli_stmt_bind_param(
                    $updateDraftStmt,
                    'dddddddi',
                    $semesterCredits,
                    $semesterPoints,
                    $semesterGpa,
                    $previousCredits,
                    $previousPoints,
                    $previousGpa,
                    $cumulativeGpa,
                    $draftId
                );
                if (!mysqli_stmt_execute($updateDraftStmt)) {
                    throw new RuntimeException(mysqli_stmt_error($updateDraftStmt));
                }
            } else {
                mysqli_stmt_bind_param(
                    $insertDraftStmt,
                    'sssssddddddd',
                    $studentId,
                    $filter['department'],
                    $filter['year'],
                    $filter['semester'],
                    $filter['section'],
                    $semesterCredits,
                    $semesterPoints,
                    $semesterGpa,
                    $previousCredits,
                    $previousPoints,
                    $previousGpa,
                    $cumulativeGpa
                );
                if (!mysqli_stmt_execute($insertDraftStmt)) {
                    throw new RuntimeException(mysqli_stmt_error($insertDraftStmt));
                }
            }

            if ($previousGradeId > 0) {
                mysqli_stmt_bind_param($markPreviousStmt, 'i', $previousGradeId);
                if (!mysqli_stmt_execute($markPreviousStmt)) {
                    throw new RuntimeException(mysqli_stmt_error($markPreviousStmt));
                }
            }

            $savedCount++;
        }

        if (!mysqli_commit($conn)) {
            throw new RuntimeException(mysqli_error($conn));
        }
        $_SESSION['viewgradeall_status'] = array(
            'type' => 'success',
            'message' => $savedCount . ' student grade report(s) were saved successfully and are ready for department approval.',
        );
    } catch (Throwable $exception) {
        mysqli_rollback($conn);
        $_SESSION['viewgradeall_status'] = array(
            'type' => 'error',
            'message' => 'The grade report could not be saved. ' . trim($exception->getMessage()),
        );
    }

    mysqli_stmt_close($findDraftStmt);
    mysqli_stmt_close($insertDraftStmt);
    mysqli_stmt_close($updateDraftStmt);
    mysqli_stmt_close($markPreviousStmt);

    header("location:viewgradeall.php");
    exit;
}

$photoPath = registrarCurrentPhotoPath();
$canAutoPrint = $shouldAutoPrint && !empty($reportRows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
<style>
.registrar-report-shell {
    display: grid;
    gap: 22px;
}
.registrar-filter-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.registrar-filter-chip {
    padding: 10px 14px;
    border-radius: 999px;
    background: #edf5ff;
    border: 1px solid #c6d8f0;
    color: #1e4d87;
    font-size: 14px;
    font-weight: 700;
}
.registrar-filter-chip strong {
    color: #173a63;
}
.registrar-report-meta {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
}
.registrar-meta-card {
    padding: 18px;
    border-radius: 16px;
    border: 1px solid #dbe5f0;
    background: #f7fbff;
}
.registrar-meta-card span {
    display: block;
    color: #5d738e;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.registrar-meta-card strong {
    display: block;
    margin-top: 8px;
    color: #143c67;
    font-size: 24px;
}
.registrar-student-report {
    padding: 24px;
    border-radius: 18px;
    border: 1px solid #d7e1ee;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(17, 52, 84, 0.08);
}
.registrar-student-report + .registrar-student-report {
    margin-top: 18px;
}
.registrar-student-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.registrar-student-title {
    margin: 0;
    color: #173a63;
    font-size: 22px;
}
.registrar-student-subtitle {
    margin: 8px 0 0;
    color: #607790;
    font-size: 14px;
}
.registrar-summary-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin: 18px 0 22px;
}
.registrar-summary-card {
    padding: 18px;
    border-radius: 16px;
    background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 100%);
    border: 1px solid #d7e3f1;
}
.registrar-summary-card h3 {
    margin: 0 0 12px;
    color: #153b63;
    font-size: 16px;
}
.registrar-summary-card p {
    margin: 6px 0;
    color: #4d6682;
    font-size: 14px;
}
.registrar-student-grid {
    display: grid;
    grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);
    gap: 18px;
    align-items: start;
}
.registrar-info-card,
.registrar-table-card {
    padding: 20px;
    border-radius: 16px;
    border: 1px solid #dbe4f0;
    background: #fbfdff;
}
.registrar-info-card h3,
.registrar-table-card h3 {
    margin: 0 0 14px;
    color: #173a63;
    font-size: 17px;
}
.registrar-info-list {
    display: grid;
    gap: 10px;
}
.registrar-info-list div {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e8eef6;
    color: #45607c;
    font-size: 14px;
}
.registrar-info-list strong {
    color: #173a63;
}
.registrar-table-wrap {
    width: 100%;
    overflow-x: auto;
}
.registrar-grade-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 520px;
}
.registrar-grade-table th,
.registrar-grade-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e2eaf4;
    text-align: left;
    font-size: 14px;
}
.registrar-grade-table th {
    background: #eaf3ff;
    color: #173a63;
}
.registrar-grade-table tbody tr:nth-child(even) {
    background: #f9fbfe;
}
.registrar-grade-table tfoot th,
.registrar-grade-table tfoot td {
    background: #f3f8ff;
    color: #163a62;
    font-weight: 700;
}
.registrar-report-actions {
    display: flex;
    justify-content: flex-end;
    gap: 14px;
    flex-wrap: wrap;
    padding-top: 10px;
    border-top: 1px solid #e0e9f3;
}
@media (max-width: 980px) {
    .registrar-report-meta,
    .registrar-summary-grid,
    .registrar-student-grid {
        grid-template-columns: 1fr;
    }
}
@media print {
    #menu,
    #left,
    #sidebar,
    #footer,
    .registrar-report-actions,
    .registrar-page-toolbar {
        display: none !important;
    }
    #container,
    #content,
    #contentindex5 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        overflow: visible !important;
    }
    .registrar-page-card,
    .registrar-student-report {
        box-shadow: none !important;
        border: 1px solid #d7e1ee !important;
    }
}
</style>
</head>
<body class="student-portal-page light-theme" data-auto-print="<?php echo $canAutoPrint ? '1' : '0'; ?>" data-has-report="<?php echo !empty($reportRows) ? '1' : '0'; ?>" onload="if (window.registrarAutoPrintPage) { window.registrarAutoPrintPage(); }">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Grade Report</span>
                    <h1 class="registrar-page-title">Student Grade Report Preview</h1>
                    <p class="registrar-page-copy">Review the generated semester report, then save it once to create the grade records that will be forwarded for department approval.</p>
                </div>

                <?php if ($flash): ?>
                    <div class="registrar-status <?php echo registrarH($flash['type'] ?? 'info'); ?>">
                        <?php echo registrarH($flash['message'] ?? ''); ?>
                    </div>
                <?php endif; ?>

                <div class="registrar-page-toolbar">
                    <div class="registrar-filter-summary">
                        <div class="registrar-filter-chip"><strong>Department:</strong> <?php echo registrarH($filter['department']); ?></div>
                        <div class="registrar-filter-chip"><strong>Year:</strong> <?php echo registrarH($filter['year']); ?></div>
                        <div class="registrar-filter-chip"><strong>Semester:</strong> <?php echo registrarH($filter['semester']); ?></div>
                        <div class="registrar-filter-chip"><strong>Section:</strong> <?php echo registrarH($filter['section']); ?></div>
                    </div>
                    <div class="registrar-actions">
                        <a href="viewgrade.php" class="registrar-link-btn">Back</a>
                        <?php if (!empty($reportRows)): ?>
                            <button type="button" class="registrar-btn-secondary" onclick="window.print()">Print</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="registrar-report-shell">
                    <div class="registrar-report-meta">
                        <div class="registrar-meta-card">
                            <span>Students</span>
                            <strong><?php echo registrarH((string) count($reportRows)); ?></strong>
                        </div>
                        <div class="registrar-meta-card">
                            <span>Report Status</span>
                            <strong><?php echo registrarH($reportMode === 'saved' ? 'Saved' : 'Preview'); ?></strong>
                        </div>
                        <div class="registrar-meta-card">
                            <span>Database Mode</span>
                            <strong><?php echo registrarH($reportMode === 'saved' ? 'Read' : 'Ready'); ?></strong>
                        </div>
                        <div class="registrar-meta-card">
                            <span>Approval Flow</span>
                            <strong>Registrar to Dept</strong>
                        </div>
                    </div>

                    <?php if ($reportMode === 'saved'): ?>
                        <div class="registrar-status info">
                            This report is already saved in the database and is waiting for department approval. Saving again will not create duplicate grade rows.
                        </div>
                    <?php endif; ?>

                    <?php if (empty($reportRows)): ?>
                        <div class="registrar-empty">
                            No approved course-result rows were found for the selected department, year, semester, and section.
                        </div>
                    <?php else: ?>
                        <?php foreach ($reportRows as $reportRow): ?>
                            <section class="registrar-student-report">
                                <div class="registrar-student-header">
                                    <div>
                                        <h2 class="registrar-student-title"><?php echo registrarH($reportRow['student_name']); ?></h2>
                                        <p class="registrar-student-subtitle">
                                            ID: <?php echo registrarH($reportRow['student_id']); ?> |
                                            Sex: <?php echo registrarH($reportRow['student']['Sex'] ?? ''); ?>
                                        </p>
                                    </div>
                                    <div class="registrar-inline-note">
                                        Current semester GPA: <strong><?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_gpa'])); ?></strong>
                                    </div>
                                </div>

                                <div class="registrar-summary-grid">
                                    <div class="registrar-summary-card">
                                        <h3>Previous Total</h3>
                                        <p>Credit Hours: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['previous_credits'])); ?></p>
                                        <p>Grade Points: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['previous_points'])); ?></p>
                                        <p>GPA: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['previous_gpa'])); ?></p>
                                    </div>
                                    <div class="registrar-summary-card">
                                        <h3>Semester Total</h3>
                                        <p>Credit Hours: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_credits'])); ?></p>
                                        <p>Grade Points: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_points'])); ?></p>
                                        <p>GPA: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_gpa'])); ?></p>
                                    </div>
                                    <div class="registrar-summary-card">
                                        <h3>Cumulative</h3>
                                        <p>Credit Hours: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['cumulative_credits'])); ?></p>
                                        <p>Grade Points: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['cumulative_points'])); ?></p>
                                        <p>GPA: <?php echo registrarH(registrarViewGradeNumber((float) $reportRow['cumulative_gpa'])); ?></p>
                                    </div>
                                </div>

                                <div class="registrar-student-grid">
                                    <div class="registrar-info-card">
                                        <h3>Student Information</h3>
                                        <div class="registrar-info-list">
                                            <div><span>Name</span><strong><?php echo registrarH($reportRow['student_name']); ?></strong></div>
                                            <div><span>ID Number</span><strong><?php echo registrarH($reportRow['student_id']); ?></strong></div>
                                            <div><span>Department</span><strong><?php echo registrarH($reportRow['student']['Department'] ?? ''); ?></strong></div>
                                            <div><span>Year</span><strong><?php echo registrarH($reportRow['student']['year'] ?? ''); ?></strong></div>
                                            <div><span>Semester</span><strong><?php echo registrarH($reportRow['student']['semister'] ?? ''); ?></strong></div>
                                            <div><span>Section</span><strong><?php echo registrarH($reportRow['student']['section'] ?? ''); ?></strong></div>
                                        </div>
                                    </div>

                                    <div class="registrar-table-card">
                                        <h3>Course Breakdown</h3>
                                        <?php if (empty($reportRow['course_rows'])): ?>
                                            <div class="registrar-empty">No course rows were found for this student in the selected semester.</div>
                                        <?php else: ?>
                                            <div class="registrar-table-wrap">
                                                <table class="registrar-grade-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Course Code</th>
                                                            <th>Credit Hour</th>
                                                            <th>Grade</th>
                                                            <th>Grade Point</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($reportRow['course_rows'] as $courseRow): ?>
                                                            <tr>
                                                                <td><?php echo registrarH($courseRow['C_Code'] ?? ''); ?></td>
                                                                <td><?php echo registrarH(registrarViewGradeNumber((float) ($courseRow['chour'] ?? 0))); ?></td>
                                                                <td><?php echo registrarH($courseRow['Grade'] ?? ''); ?></td>
                                                                <td><?php echo registrarH(registrarViewGradeNumber((float) ($courseRow['grade_point'] ?? 0))); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <td><?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_credits'])); ?></td>
                                                            <td></td>
                                                            <td><?php echo registrarH(registrarViewGradeNumber((float) $reportRow['semester_points'])); ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </section>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="registrar-report-actions">
                        <a href="viewgrade.php" class="registrar-btn-secondary">Cancel</a>
                        <?php if (!empty($reportRows) && $reportMode !== 'saved'): ?>
                            <form action="viewgradeall.php" method="post">
                                <button type="submit" name="save_report" class="registrar-btn">Save Report</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photoPath); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
<script>
(function () {
    var storageKey = 'registrar_viewgrade_autoprint';
    var printed = false;
    var body = document.body;
    var shouldAutoPrint = body && body.getAttribute('data-auto-print') === '1';
    var hasReportRows = body && body.getAttribute('data-has-report') === '1';

    if (!hasReportRows) {
        try {
            if (window.sessionStorage) {
                window.sessionStorage.removeItem(storageKey);
            }
        } catch (error) {
            // Ignore browsers that block sessionStorage.
        }
        return;
    }

    try {
        if (window.sessionStorage && window.sessionStorage.getItem(storageKey) === '1') {
            shouldAutoPrint = true;
            window.sessionStorage.removeItem(storageKey);
        }
    } catch (error) {
        // Ignore browsers that block sessionStorage.
    }

    if (!shouldAutoPrint) {
        return;
    }

    function triggerPrint() {
        if (printed || !document.body) {
            return;
        }

        printed = true;
        window.focus();
        window.setTimeout(function () {
            window.print();
        }, 80);
    }

    window.registrarAutoPrintPage = triggerPrint;

    if (document.readyState === 'complete') {
        window.setTimeout(triggerPrint, 120);
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            window.setTimeout(triggerPrint, 180);
        });

        window.addEventListener('load', function () {
            window.setTimeout(triggerPrint, 120);
        });
    }

    window.addEventListener('focus', function () {
        if (!printed) {
            window.setTimeout(triggerPrint, 120);
        }
    });

    window.addEventListener('pageshow', function () {
        if (!printed) {
            window.setTimeout(triggerPrint, 120);
        }
    });
})();
</script>
</body>
</html>
