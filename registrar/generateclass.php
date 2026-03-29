<?php
session_start();
require_once("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

function registrarGenerateClassStatusLabel(string $section, string $status): array
{
    $section = trim($section);
    $status = strtolower(trim($status));

    if ($section === '') {
        return array('label' => 'Section Required', 'class' => 'warning');
    }

    if ($status === 'ok') {
        return array('label' => 'Generated', 'class' => 'success');
    }

    return array('label' => 'Ready', 'class' => 'info');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $_SESSION['idsec'] = trim((string) ($_POST['dpt'] ?? ''));
}

$department = isset($_SESSION['idsec']) ? trim((string) $_SESSION['idsec']) : '';
if ($department === '') {
    header("location:generateid.php");
    exit;
}

$statusMessage = '';
$statusClass = 'info';
if (isset($_SESSION['generateclass_status']) && is_array($_SESSION['generateclass_status'])) {
    $statusMessage = trim((string) ($_SESSION['generateclass_status']['message'] ?? ''));
    $statusClass = trim((string) ($_SESSION['generateclass_status']['class'] ?? 'info'));
    unset($_SESSION['generateclass_status']);
}

$students = array();
$queryError = '';
$readyCount = 0;
$generatedCount = 0;
$needsSectionCount = 0;

$studentStmt = mysqli_prepare(
    $conn,
    "SELECT s.S_ID, s.FName, s.LName, s.Sex, s.College, s.Department, s.year, s.section, s.semister, s.status
     FROM student s
     WHERE s.Department = ?
       AND s.year = '1st'
       AND s.semister = 'I'
       AND EXISTS (
            SELECT 1
            FROM entrance_exam ee
            WHERE ee.S_ID = s.S_ID
              AND ee.status = 'satisfactory'
       )
     ORDER BY s.section ASC, s.S_ID ASC"
);

if ($studentStmt) {
    mysqli_stmt_bind_param($studentStmt, 's', $department);
    mysqli_stmt_execute($studentStmt);
    $result = mysqli_stmt_get_result($studentStmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;

            $section = trim((string) ($row['section'] ?? ''));
            $status = strtolower(trim((string) ($row['status'] ?? '')));

            if ($section === '') {
                $needsSectionCount++;
            } elseif ($status === 'ok') {
                $generatedCount++;
            } else {
                $readyCount++;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($studentStmt);
} else {
    $queryError = 'The student list could not be loaded right now. Please check the database connection and try again.';
}

$photoPath = registrarCurrentPhotoPath();
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
.registrar-generate-toolbar {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 20px;
}
.registrar-chip-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.registrar-chip {
    padding: 10px 14px;
    border-radius: 999px;
    background: #edf5ff;
    border: 1px solid #c6d8f0;
    color: #1b4f86;
    font-size: 14px;
    font-weight: 700;
}
.registrar-chip strong {
    color: #143a64;
}
.registrar-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.registrar-stat-card {
    padding: 18px 20px;
    border-radius: 16px;
    border: 1px solid #dae4f0;
    background: linear-gradient(180deg, #fbfdff 0%, #eef5ff 100%);
}
.registrar-stat-card span {
    display: block;
    color: #5f7893;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.registrar-stat-card strong {
    display: block;
    margin-top: 8px;
    color: #173a63;
    font-size: 26px;
}
.registrar-table-panel {
    padding: 22px;
    border-radius: 18px;
    border: 1px solid #d9e4f0;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(17, 52, 84, 0.08);
}
.registrar-table-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: flex-start;
    margin-bottom: 18px;
}
.registrar-table-title {
    margin: 0;
    color: #173a63;
    font-size: 22px;
}
.registrar-table-copy {
    margin: 8px 0 0;
    color: #5d748e;
    font-size: 14px;
    line-height: 1.7;
}
.registrar-table-wrap {
    width: 100%;
    overflow-x: auto;
}
.registrar-table {
    width: 100%;
    min-width: 980px;
    border-collapse: collapse;
}
.registrar-table th,
.registrar-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #e3ebf4;
    text-align: left;
    font-size: 14px;
}
.registrar-table th {
    background: #ecf4ff;
    color: #173a63;
}
.registrar-table tbody tr:nth-child(even) {
    background: #f9fbfe;
}
.registrar-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 30px;
    padding: 0 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.registrar-status-badge.success {
    background: #e8f7ea;
    color: #1e6a33;
}
.registrar-status-badge.info {
    background: #e9f2ff;
    color: #1c4f84;
}
.registrar-status-badge.warning {
    background: #fff3e2;
    color: #8b5a12;
}
.registrar-actions-inline {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}
.registrar-btn-disabled {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 20px;
    border-radius: 12px;
    border: 1px solid #d9e2ec;
    background: #eef2f6;
    color: #6d7f92;
    font-size: 15px;
    font-weight: 700;
}
@media (max-width: 980px) {
    .registrar-stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 720px) {
    .registrar-stats-grid {
        grid-template-columns: 1fr;
    }
    .registrar-generate-toolbar,
    .registrar-table-head {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Student ID</span>
                    <h1 class="registrar-page-title">Load First-Year Students</h1>
                    <p class="registrar-page-copy">Review first-year semester-I students with satisfactory entrance-exam status before generating their ID numbers.</p>
                </div>

                <?php if ($statusMessage !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($statusClass); ?>"><?php echo registrarH($statusMessage); ?></div>
                <?php endif; ?>

                <?php if ($queryError !== ''): ?>
                    <div class="registrar-status error"><?php echo registrarH($queryError); ?></div>
                <?php endif; ?>

                <div class="registrar-generate-toolbar">
                    <div class="registrar-chip-row">
                        <div class="registrar-chip"><strong>Department:</strong> <?php echo registrarH($department); ?></div>
                        <div class="registrar-chip"><strong>Database:</strong> <?php echo $conn instanceof mysqli ? 'Connected' : 'Unavailable'; ?></div>
                    </div>
                    <div class="registrar-actions-inline">
                        <a href="generateid.php" class="registrar-link-btn">Back</a>
                        <?php if ($readyCount > 0): ?>
                            <a href="idgenerate.php?id=<?php echo urlencode($department); ?>" class="registrar-btn">Generate ID Number For All Students</a>
                        <?php else: ?>
                            <span class="registrar-btn-disabled">No Students Ready</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="registrar-stats-grid">
                    <div class="registrar-stat-card">
                        <span>Satisfactory Students</span>
                        <strong><?php echo registrarH((string) count($students)); ?></strong>
                    </div>
                    <div class="registrar-stat-card">
                        <span>Ready For Generation</span>
                        <strong><?php echo registrarH((string) $readyCount); ?></strong>
                    </div>
                    <div class="registrar-stat-card">
                        <span>Already Generated</span>
                        <strong><?php echo registrarH((string) $generatedCount); ?></strong>
                    </div>
                    <div class="registrar-stat-card">
                        <span>Missing Section</span>
                        <strong><?php echo registrarH((string) $needsSectionCount); ?></strong>
                    </div>
                </div>

                <div class="registrar-table-panel">
                    <div class="registrar-table-head">
                        <div>
                            <h2 class="registrar-table-title">Eligible Student List</h2>
                            <p class="registrar-table-copy">Only students with a satisfactory entrance-exam result are shown here. A section must be assigned before the bulk ID generation action can update that student.</p>
                        </div>
                    </div>

                    <?php if (empty($students)): ?>
                        <div class="registrar-empty">No first-year semester-I students with satisfactory entrance-exam status were found for this department.</div>
                    <?php else: ?>
                        <div class="registrar-table-wrap">
                            <table class="registrar-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>College</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <th>Semester</th>
                                        <th>ID Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php $statusMeta = registrarGenerateClassStatusLabel((string) ($student['section'] ?? ''), (string) ($student['status'] ?? '')); ?>
                                        <tr>
                                            <td><?php echo registrarH($student['S_ID'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['FName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['LName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Sex'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['College'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Department'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['year'] ?? ''); ?></td>
                                            <td><?php echo registrarH(trim((string) ($student['section'] ?? '')) !== '' ? (string) $student['section'] : 'Not assigned'); ?></td>
                                            <td><?php echo registrarH($student['semister'] ?? ''); ?></td>
                                            <td><span class="registrar-status-badge <?php echo registrarH($statusMeta['class']); ?>"><?php echo registrarH($statusMeta['label']); ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photoPath); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
