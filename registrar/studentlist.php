<?php
session_start();
require_once("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

function registrarStudentListStatusMeta(array $student): array
{
    $unread = strtolower(trim((string) ($student['unread'] ?? '')));
    if ($unread === 'yes') {
        return array('label' => 'Ready To Update', 'class' => 'warning');
    }

    if ($unread === 'not') {
        return array('label' => 'Cleared', 'class' => 'info');
    }

    return array('label' => 'Processed', 'class' => 'success');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $_SESSION['dpt'] = trim((string) ($_POST['dpt'] ?? ''));
    $_SESSION['yea'] = trim((string) ($_POST['scy'] ?? ''));
    $_SESSION['sem'] = trim((string) ($_POST['sem'] ?? ''));
}

$department = isset($_SESSION['dpt']) ? trim((string) $_SESSION['dpt']) : '';
$year = isset($_SESSION['yea']) ? trim((string) $_SESSION['yea']) : '';
$semester = isset($_SESSION['sem']) ? trim((string) $_SESSION['sem']) : '';

if ($department === '' || $year === '' || $semester === '') {
    header("location:updatestud.php");
    exit;
}

$searchStudentId = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $searchStudentId = trim((string) ($_POST['search_file'] ?? ''));
}

$pageError = '';
$students = array();
$totalCount = 0;
$readyCount = 0;
$clearedCount = 0;
$filteredCount = 0;
$statusMessage = '';
$statusClass = 'info';

if (isset($_SESSION['studentlist_status']) && is_array($_SESSION['studentlist_status'])) {
    $statusMessage = trim((string) ($_SESSION['studentlist_status']['message'] ?? ''));
    $statusClass = trim((string) ($_SESSION['studentlist_status']['class'] ?? 'info'));
    unset($_SESSION['studentlist_status']);
}

$baseCountStmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS total
     FROM student
     WHERE Department = ?
       AND year = ?
       AND semister = ?
       AND unread = 'yes'"
);

if ($baseCountStmt) {
    mysqli_stmt_bind_param($baseCountStmt, 'sss', $department, $year, $semester);
    mysqli_stmt_execute($baseCountStmt);
    $countResult = mysqli_stmt_get_result($baseCountStmt);
    if ($countResult instanceof mysqli_result) {
        $countRow = mysqli_fetch_assoc($countResult);
        $totalCount = (int) ($countRow['total'] ?? 0);
        mysqli_free_result($countResult);
    }
    mysqli_stmt_close($baseCountStmt);
}

if ($searchStudentId !== '') {
    $studentStmt = mysqli_prepare(
        $conn,
        "SELECT S_ID, FName, LName, Sex, College, Department, year, semister, unread
         FROM student
         WHERE Department = ?
           AND year = ?
           AND semister = ?
           AND S_ID = ?
         ORDER BY S_ID ASC"
    );
} else {
    $studentStmt = mysqli_prepare(
        $conn,
        "SELECT S_ID, FName, LName, Sex, College, Department, year, semister, unread
         FROM student
         WHERE Department = ?
           AND year = ?
           AND semister = ?
           AND unread = 'yes'
         ORDER BY S_ID ASC"
    );
}

if (!$studentStmt) {
    $pageError = 'The student list could not be loaded right now. Please check the database connection and try again.';
} else {
    if ($searchStudentId !== '') {
        mysqli_stmt_bind_param($studentStmt, 'ssss', $department, $year, $semester, $searchStudentId);
    } else {
        mysqli_stmt_bind_param($studentStmt, 'sss', $department, $year, $semester);
    }

    mysqli_stmt_execute($studentStmt);
    $result = mysqli_stmt_get_result($studentStmt);

    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
            $unread = strtolower(trim((string) ($row['unread'] ?? '')));
            if ($unread === 'yes') {
                $readyCount++;
            } elseif ($unread === 'not') {
                $clearedCount++;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($studentStmt);
    $filteredCount = count($students);
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
.registrar-progress-toolbar {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 20px;
}
.registrar-progress-chip-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.registrar-progress-chip {
    padding: 10px 14px;
    border-radius: 999px;
    background: #edf5ff;
    border: 1px solid #c6d8f0;
    color: #1b4f86;
    font-size: 14px;
    font-weight: 700;
}
.registrar-progress-chip strong {
    color: #143a64;
}
.registrar-progress-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.registrar-progress-stat {
    padding: 18px 20px;
    border-radius: 16px;
    border: 1px solid #dae4f0;
    background: linear-gradient(180deg, #fbfdff 0%, #eef5ff 100%);
}
.registrar-progress-stat span {
    display: block;
    color: #5f7893;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.registrar-progress-stat strong {
    display: block;
    margin-top: 8px;
    color: #173a63;
    font-size: 26px;
}
.registrar-progress-search {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 14px;
    margin-bottom: 22px;
}
.registrar-progress-panel {
    padding: 22px;
    border-radius: 18px;
    border: 1px solid #d9e4f0;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(17, 52, 84, 0.08);
}
.registrar-progress-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    align-items: flex-start;
    margin-bottom: 18px;
}
.registrar-progress-title {
    margin: 0;
    color: #173a63;
    font-size: 22px;
}
.registrar-progress-copy {
    margin: 8px 0 0;
    color: #5d748e;
    font-size: 14px;
    line-height: 1.7;
    max-width: 820px;
}
.registrar-progress-table-wrap {
    width: 100%;
    overflow-x: auto;
}
.registrar-progress-table {
    width: 100%;
    min-width: 980px;
    border-collapse: collapse;
}
.registrar-progress-table th,
.registrar-progress-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #e3ebf4;
    text-align: left;
    font-size: 14px;
}
.registrar-progress-table th {
    background: #ecf4ff;
    color: #173a63;
}
.registrar-progress-table tbody tr:nth-child(even) {
    background: #f9fbfe;
}
.registrar-progress-badge {
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
.registrar-progress-badge.success {
    background: #e8f7ea;
    color: #1e6a33;
}
.registrar-progress-badge.info {
    background: #e9f2ff;
    color: #1c4f84;
}
.registrar-progress-badge.warning {
    background: #fff3e2;
    color: #8b5a12;
}
.registrar-progress-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.registrar-progress-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 38px;
    padding: 0 14px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}
.registrar-progress-link.primary {
    background: #1f6fb2;
    color: #ffffff;
}
.registrar-progress-link.secondary {
    background: #edf2f7;
    color: #26415d;
    border: 1px solid #d8e1eb;
}
@media (max-width: 980px) {
    .registrar-progress-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 720px) {
    .registrar-progress-stats {
        grid-template-columns: 1fr;
    }
    .registrar-progress-toolbar,
    .registrar-progress-head,
    .registrar-progress-search {
        grid-template-columns: 1fr;
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
                    <span class="registrar-page-eyebrow">Student Promotion</span>
                    <h1 class="registrar-page-title">Student Progress Review</h1>
                    <p class="registrar-page-copy">Review the selected class, filter by student ID when needed, and use the linked actions to clear selected records or update the full student group.</p>
                </div>

                <?php if ($statusMessage !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($statusClass); ?>"><?php echo registrarH($statusMessage); ?></div>
                <?php endif; ?>

                <?php if ($pageError !== ''): ?>
                    <div class="registrar-status error"><?php echo registrarH($pageError); ?></div>
                <?php endif; ?>

                <div class="registrar-progress-toolbar">
                    <div class="registrar-progress-chip-row">
                        <div class="registrar-progress-chip"><strong>Department:</strong> <?php echo registrarH($department); ?></div>
                        <div class="registrar-progress-chip"><strong>Year:</strong> <?php echo registrarH($year); ?></div>
                        <div class="registrar-progress-chip"><strong>Semester:</strong> <?php echo registrarH($semester); ?></div>
                        <div class="registrar-progress-chip"><strong>Database:</strong> <?php echo $conn instanceof mysqli ? 'Connected' : 'Unavailable'; ?></div>
                    </div>
                    <div class="registrar-actions">
                        <a href="updatestud.php" class="registrar-link-btn">Back</a>
                        <a href="updateall.php" class="registrar-btn">Update All</a>
                    </div>
                </div>

                <div class="registrar-progress-stats">
                    <div class="registrar-progress-stat">
                        <span>Ready Records</span>
                        <strong><?php echo registrarH((string) $totalCount); ?></strong>
                    </div>
                    <div class="registrar-progress-stat">
                        <span>Filtered Rows</span>
                        <strong><?php echo registrarH((string) $filteredCount); ?></strong>
                    </div>
                    <div class="registrar-progress-stat">
                        <span>Ready To Update</span>
                        <strong><?php echo registrarH((string) $readyCount); ?></strong>
                    </div>
                    <div class="registrar-progress-stat">
                        <span>Cleared Results</span>
                        <strong><?php echo registrarH((string) $clearedCount); ?></strong>
                    </div>
                </div>

                <form action="studentlist.php" method="post" class="registrar-progress-search">
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="studentlist-search-id">Search Student by ID</label>
                        <input type="text" name="search_file" id="studentlist-search-id" class="registrar-input" placeholder="Enter student ID" value="<?php echo registrarH($searchStudentId); ?>">
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="studentlist-search-action">Apply Filter</label>
                        <div class="registrar-actions" id="studentlist-search-action">
                            <button type="submit" name="submit" class="registrar-btn">Filter</button>
                            <a href="studentlist.php" class="registrar-btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="registrar-progress-panel">
                    <div class="registrar-progress-head">
                        <div>
                            <h2 class="registrar-progress-title">Student List</h2>
                            <p class="registrar-progress-copy">This page is connected to the `student` table and uses the current department, year, and semester session filter. When a single student is filtered, the row keeps the targeted update action. The default list keeps the clear action for records that are ready to be processed.</p>
                        </div>
                    </div>

                    <?php if (empty($students)): ?>
                        <div class="registrar-empty">No student records were found for the selected filter. Try another student ID or return to the student-progress filter page.</div>
                    <?php else: ?>
                        <div class="registrar-progress-table-wrap">
                            <table class="registrar-progress-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>College</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php $statusMeta = registrarStudentListStatusMeta($student); ?>
                                        <tr>
                                            <td><?php echo registrarH($student['S_ID'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['FName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['LName'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Sex'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['College'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['Department'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['year'] ?? ''); ?></td>
                                            <td><?php echo registrarH($student['semister'] ?? ''); ?></td>
                                            <td><span class="registrar-progress-badge <?php echo registrarH($statusMeta['class']); ?>"><?php echo registrarH($statusMeta['label']); ?></span></td>
                                            <td>
                                                <div class="registrar-progress-actions">
                                                    <?php if ($searchStudentId !== ''): ?>
                                                        <a class="registrar-progress-link primary" href="updateallstudid.php?id=<?php echo urlencode((string) ($student['S_ID'] ?? '')); ?>">Update</a>
                                                    <?php else: ?>
                                                        <a class="registrar-progress-link secondary" href="updateselectedstudid.php?id=<?php echo urlencode((string) ($student['S_ID'] ?? '')); ?>">Clear</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
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
