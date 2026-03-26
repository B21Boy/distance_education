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
    $departments = array();
    $d_program = mysql_query("SELECT * FROM department ORDER BY DName ASC");
    while ($getDprog = mysql_fetch_array($d_program)) {
        $departments[] = $getDprog['DName'];
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
                            <p class="admin-page-copy">Select a department first, then continue to the result-entry page to post first-year entrance exam results.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-toolbar">
                            <span class="page-stat-chip"><?php echo count($departments); ?> department<?php echo count($departments) === 1 ? '' : 's'; ?></span>
                        </div>
                        <form action="addcourseresult.php" method="post" class="admin-page-form-row">
                            <label for="dpt" style="font-weight:700;color:#173a5e;">Select Department</label>
                            <select name="dpt" id="dpt" class="admin-page-select" required>
                                <option value="">--select department--</option>
                                <?php foreach ($departments as $department_name) { ?>
                                <option value="<?php echo htmlspecialchars($department_name, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($department_name, ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" name="search" class="admin-page-btn">Search</button>
                        </form>
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
