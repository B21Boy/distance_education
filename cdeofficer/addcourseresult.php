<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>CDE Officer page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $student_rows = array();
    $department_name = '';

    if (isset($_POST['search'])) {
        $department_name = $_POST['dpt'];
        $_SESSION['sdpt'] = $department_name;
        $sql = mysql_query("select * from student where Department='$department_name' and year='1st' and semister='I' ORDER BY S_ID ASC");
        while ($row = mysql_fetch_array($sql)) {
            $student_rows[] = $row;
        }
    }
?>
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menucdeo.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenucdeo.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="admin-page-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">CDE Officer</span>
                            <h1 class="admin-page-title">Post Entrance Exam Results</h1>
                            <p class="admin-page-copy">Enter first-year entrance exam results for the selected department and submit them in one standard form.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <?php if (!empty($student_rows)) { ?>
                        <div class="admin-page-toolbar">
                            <span class="page-stat-chip"><?php echo count($student_rows); ?> students in <?php echo htmlspecialchars($department_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <form action="insertcourse.php" name="addem" method="post">
                            <div class="admin-page-table-wrap">
                                <table class="admin-page-table">
                                    <thead>
                                        <tr>
                                            <th>Student Temo_ID</th>
                                            <th>Result</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($student_rows as $row) { ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="id[]" value="<?php echo htmlspecialchars($row['S_ID'], ENT_QUOTES, 'UTF-8'); ?>" class="admin-page-input" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="a1[]" class="admin-page-input" min="0" step="0.01" required>
                                            </td>
                                            <td>
                                                <select name="st[]" class="admin-page-select" required>
                                                    <option value="">--Please Select--</option>
                                                    <option value="satisfactory">satisfactory</option>
                                                    <option value="unsatisfactory">unsatisfactory</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="admin-page-form-row" style="margin-top: 18px;">
                                <button type="submit" name="submit1" class="admin-page-btn">Post</button>
                                <button type="reset" class="admin-page-btn-secondary">Clear</button>
                            </div>
                        </form>
                        <?php } else { ?>
                        <div class="admin-page-empty">No department was selected, or no first-year semester I students were found for the selected department.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require("officer_sidebar.php"); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php
} else {
    header("location:../index.php");
    exit;
}
?>
</body>
</html>
