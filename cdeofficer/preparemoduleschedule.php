<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $scheduleRows = array();
    $sql = mysqli_query($conn, "SELECT * FROM module_schedule");
    if ($sql instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $scheduleRows[] = $row;
        }
        mysqli_free_result($sql);
    }
    $c = count($scheduleRows);
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
	<div id="contentindex5">
    <div class="admin-page-shell">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-kicker">CDE Officer</span>
                <h1 class="admin-page-title">Module Preparation Schedule</h1>
                <p class="admin-page-copy">Review the current schedule text and update it through the popup editor when needed.</p>
            </div>
        </div>
        <div class="admin-page-panel">
            <div class="admin-page-toolbar">
                <span class="page-stat-chip"><?php echo (int) $c; ?> saved schedule record<?php echo $c == 1 ? '' : 's'; ?></span>
                <a rel="facebox" href="insertschedule.php" class="page-nav-link is-primary"><?php echo $c >= 1 ? 'Update Module Preparation Schedule' : 'Prepare Module Preparation Schedule'; ?></a>
            </div>
            <?php if ($c >= 1) {
            foreach ($scheduleRows as $row) {
            ?>
            <div class="admin-page-status-card" style="white-space: pre-wrap;"><?php echo htmlspecialchars((string) ($row['information'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
            <?php
            }
            } else {
            ?>
            <div class="admin-page-empty">No module preparation schedule has been posted yet.</div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
?>
 </div></div>
	 <div id="sidebar">
<?php
    require("officer_sidebar.php");
?>
	 </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>

<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
