<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photoPath = instructorCurrentPhotoPath();
$selected = [
    'dpt' => isset($_SESSION['sdpt']) ? trim((string) $_SESSION['sdpt']) : '',
    'scy' => isset($_SESSION['sscy']) ? trim((string) $_SESSION['sscy']) : '',
    'sec' => isset($_SESSION['ssec']) ? trim((string) $_SESSION['ssec']) : '',
    'sem' => isset($_SESSION['ssem']) ? trim((string) $_SESSION['ssem']) : '',
    'cc' => isset($_SESSION['scc']) ? trim((string) $_SESSION['scc']) : '',
];

if (isset($_POST['search'])) {
    foreach ($selected as $key => $value) {
        $selected[$key] = isset($_POST[$key]) ? trim((string) $_POST[$key]) : '';
    }
    $_SESSION['sdpt'] = $selected['dpt'];
    $_SESSION['sscy'] = $selected['scy'];
    $_SESSION['ssec'] = $selected['sec'];
    $_SESSION['ssem'] = $selected['sem'];
    $_SESSION['scc'] = $selected['cc'];
}

$hasSelection = $selected['dpt'] !== '' && $selected['scy'] !== '' && $selected['sec'] !== '' && $selected['sem'] !== '' && $selected['cc'] !== '';
$existingRows = [];
$studentRows = [];

if ($hasSelection) {
    $stmt = mysqli_prepare($conn, "SELECT no, S_ID, Assignment, Final, Total, Grade
                                   FROM course_result
                                   WHERE Department = ? AND year = ? AND semister = ? AND section = ? AND C_Code = ?
                                   ORDER BY S_ID");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssss', $selected['dpt'], $selected['scy'], $selected['sem'], $selected['sec'], $selected['cc']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $existingRows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }

    if (!$existingRows) {
        $studentStmt = mysqli_prepare($conn, "SELECT S_ID
                                              FROM student
                                              WHERE Department = ? AND year = ? AND semister = ? AND section = ?
                                              ORDER BY S_ID");
        if ($studentStmt) {
            mysqli_stmt_bind_param($studentStmt, 'ssss', $selected['dpt'], $selected['scy'], $selected['sem'], $selected['sec']);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            if ($studentResult instanceof mysqli_result) {
                while ($row = mysqli_fetch_assoc($studentResult)) {
                    $studentRows[] = $row;
                }
                mysqli_free_result($studentResult);
            }
            mysqli_stmt_close($studentStmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="instructor-page.css" type="text/css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menuins.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenuins.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="instructor-page-shell">
                    <div class="instructor-page-header">
                        <div>
                            <span class="instructor-page-kicker">Course Result</span>
                            <h1 class="instructor-page-title">Add Course Result</h1>
                            <p class="instructor-page-copy">Enter assignment scores for the selected batch, or complete final scores for records that already exist in the course result table.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <div class="instructor-note-card">
                            <div>
                                <strong>Selected Batch</strong>
                                <div class="instructor-selection-summary">
                                    <span>Department: <?php echo instructorH($selected['dpt'] !== '' ? $selected['dpt'] : 'Not selected'); ?></span>
                                    <span>Year: <?php echo instructorH($selected['scy'] !== '' ? $selected['scy'] : 'Not selected'); ?></span>
                                    <span>Semister: <?php echo instructorH($selected['sem'] !== '' ? $selected['sem'] : 'Not selected'); ?></span>
                                    <span>Section: <?php echo instructorH($selected['sec'] !== '' ? $selected['sec'] : 'Not selected'); ?></span>
                                    <span>Course: <?php echo instructorH($selected['cc'] !== '' ? $selected['cc'] : 'Not selected'); ?></span>
                                </div>
                            </div>
                            <a class="instructor-secondary-btn" href="postresult.php">Back To Filters</a>
                        </div>

                        <?php if (!$hasSelection) { ?>
                            <div class="instructor-empty-state">Choose the department, year, semister, section, and course code first from the posting filter page.</div>
                        <?php } elseif ($existingRows) { ?>
                            <form action="insertcourse.php" method="post">
                                <div class="instructor-table-wrap">
                                    <table cellpadding="1" cellspacing="1" id="resultTable">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Assignment</th>
                                                <th>Final</th>
                                                <th>Current Total</th>
                                                <th>Current Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($existingRows as $row) { ?>
                                                <?php
                                                $assignment = isset($row['Assignment']) ? (string) $row['Assignment'] : '0';
                                                $final = isset($row['Final']) ? (string) $row['Final'] : '';
                                                $total = isset($row['Total']) ? (string) $row['Total'] : $assignment;
                                                $grade = isset($row['Grade']) && trim((string) $row['Grade']) !== '' ? (string) $row['Grade'] : 'Pending';
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input class="instructor-score-input" type="text" name="id[]" readonly value="<?php echo instructorH($row['S_ID'] ?? ''); ?>">
                                                    </td>
                                                    <td>
                                                        <input class="instructor-score-input" type="number" name="a1[]" readonly value="<?php echo instructorH($assignment); ?>">
                                                        <input type="hidden" name="t[]" value="<?php echo instructorH($assignment); ?>">
                                                    </td>
                                                    <td>
                                                        <input class="instructor-score-input" type="number" name="f[]" min="0" max="100" step="0.01" required value="<?php echo instructorH($final); ?>">
                                                    </td>
                                                    <td><?php echo instructorH($total); ?></td>
                                                    <td><?php echo instructorH($grade); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="instructor-table-actions">
                                    <button type="submit" class="instructor-btn" name="submit2">Save Final Scores</button>
                                    <button type="reset" class="instructor-secondary-btn">Clear</button>
                                </div>
                            </form>
                        <?php } elseif ($studentRows) { ?>
                            <form action="insertcourse.php" method="post">
                                <div class="instructor-table-wrap">
                                    <table cellpadding="1" cellspacing="1" id="resultTable">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Assignment</th>
                                                <th>Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($studentRows as $row) { ?>
                                                <tr>
                                                    <td>
                                                        <input class="instructor-score-input" type="text" name="id[]" readonly value="<?php echo instructorH($row['S_ID'] ?? ''); ?>">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="cc[]" value="<?php echo instructorH($selected['cc']); ?>">
                                                        <input class="instructor-score-input" type="number" name="a1[]" min="0" max="100" step="0.01" required placeholder="Assignment score">
                                                    </td>
                                                    <td>
                                                        <input class="instructor-score-input" type="number" name="f[]" value="0" readonly>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="instructor-table-actions">
                                    <button type="submit" class="instructor-btn" name="submit1">Save Assignment Scores</button>
                                    <button type="reset" class="instructor-secondary-btn">Clear</button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="instructor-empty-state">No student rows were found for the selected batch, so there is nothing to post yet.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php instructorRenderSidebar($photoPath); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php instructorRenderIconScripts(); ?>
</body>
</html>
