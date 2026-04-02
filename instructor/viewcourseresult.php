<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photoPath = instructorCurrentPhotoPath();

if (isset($_POST['search'])) {
    $_SESSION['sdpt'] = isset($_POST['dpt']) ? trim((string) $_POST['dpt']) : '';
    $_SESSION['sscy'] = isset($_POST['scy']) ? trim((string) $_POST['scy']) : '';
    $_SESSION['ssec'] = isset($_POST['sec']) ? trim((string) $_POST['sec']) : '';
    $_SESSION['ssem'] = isset($_POST['sem']) ? trim((string) $_POST['sem']) : '';
    $_SESSION['scc'] = isset($_POST['cc']) ? trim((string) $_POST['cc']) : '';
    $_SESSION['sddc'] = isset($_POST['uu']) ? trim((string) $_POST['uu']) : '';
}

$selected = [
    'dpt' => isset($_SESSION['sdpt']) ? trim((string) $_SESSION['sdpt']) : '',
    'scy' => isset($_SESSION['sscy']) ? trim((string) $_SESSION['sscy']) : '',
    'sec' => isset($_SESSION['ssec']) ? trim((string) $_SESSION['ssec']) : '',
    'sem' => isset($_SESSION['ssem']) ? trim((string) $_SESSION['ssem']) : '',
    'cc' => isset($_SESSION['scc']) ? trim((string) $_SESSION['scc']) : '',
    'dcc' => isset($_SESSION['sddc']) ? trim((string) $_SESSION['sddc']) : '',
];

$hasSelection = $selected['dpt'] !== '' && $selected['scy'] !== '' && $selected['sec'] !== '' && $selected['sem'] !== '' && $selected['cc'] !== '';
$rows = [];
$columns = [];

if ($hasSelection) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM course_result
                                   WHERE status = 'post' AND Department = ? AND year = ? AND semister = ? AND section = ? AND C_Code = ?
                                   ORDER BY no DESC");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssss', $selected['dpt'], $selected['scy'], $selected['sem'], $selected['sec'], $selected['cc']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            foreach (mysqli_fetch_fields($result) as $field) {
                if ($field->name === 'status') {
                    break;
                }
                $columns[] = $field->name;
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
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
                            <h1 class="instructor-page-title">View Course Result</h1>
                            <p class="instructor-page-copy">Review the posted result rows for the selected course batch, update any line that needs correction, or send the full batch onward.</p>
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
                                    <span>Send To: <?php echo instructorH($selected['dcc'] !== '' ? $selected['dcc'] : 'Not selected'); ?></span>
                                </div>
                            </div>
                            <div class="instructor-form-actions">
                                <a class="instructor-secondary-btn" href="viewgrade.php">Back</a>
                                <?php if ($rows && $selected['dcc'] !== '') { ?>
                                    <a class="instructor-btn" href="sendall.php">Send All</a>
                                <?php } ?>
                            </div>
                        </div>

                        <?php if (!$hasSelection) { ?>
                            <div class="instructor-empty-state">Open this page from the result filter form so the department, year, semister, section, and course code are available.</div>
                        <?php } elseif (!$rows) { ?>
                            <div class="instructor-empty-state">No posted result rows were found for the selected course batch.</div>
                        <?php } else { ?>
                            <div class="instructor-table-wrap">
                                <table cellpadding="1" cellspacing="1" id="resultTable">
                                    <thead>
                                        <tr>
                                            <?php foreach ($columns as $column) { ?>
                                                <th><?php echo instructorH($column); ?></th>
                                            <?php } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row) { ?>
                                            <tr>
                                                <?php foreach ($columns as $column) { ?>
                                                    <td><?php echo instructorH($row[$column] ?? ''); ?></td>
                                                <?php } ?>
                                                <td>
                                                    <a class="instructor-inline-link" rel="facebox" href="calculategrade.php?id=<?php echo urlencode((string) ($row['no'] ?? '')); ?>">Update</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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
