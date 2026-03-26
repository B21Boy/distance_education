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
<?php
include('ps_pagination.php');
$sql1 = mysql_query("SELECT * from postss") or die(mysql_error());
$ro = mysql_num_rows($sql1);
$pager = null;
$rs = false;
if ($ro != '0') {
    $sql = "SELECT * from postss where status=' ' ORDER BY dates DESC";
    $pager = new PS_Pagination($conn, $sql, 1, 1);
    $rs = $pager->paginate();
}
?>
    <div class="admin-page-shell">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-kicker">CDE Officer</span>
                <h1 class="admin-page-title">Post Updated Information</h1>
                <p class="admin-page-copy">Manage the current notice board and publish a new announcement through the popup editor.</p>
            </div>
        </div>
        <div class="admin-page-panel">
            <div class="admin-page-toolbar">
                <span class="page-stat-chip"><?php echo (int) $ro; ?> notice record<?php echo $ro == 1 ? '' : 's'; ?></span>
                <a rel="facebox" href="posti.php" class="page-nav-link is-primary">Post Updated Information</a>
            </div>
            <?php if ($ro != '0' && $rs) {
                while ($row = mysql_fetch_array($rs)) {
            ?>
            <div class="admin-page-status-card" style="margin-bottom: 18px;">
                <p style="margin: 0 0 8px; text-align: right;"><strong>Date:</strong> <?php echo htmlspecialchars($row['dates'], ENT_QUOTES, 'UTF-8'); ?></p>
                <h2 style="margin: 0 0 10px; color: #12395f;"><?php echo htmlspecialchars($row['Title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                <p style="margin: 0 0 14px; color: #1e5788; font-weight: 700;"><?php echo htmlspecialchars($row['types'], ENT_QUOTES, 'UTF-8'); ?></p>
                <div style="white-space: pre-wrap; color: #17364e;"><?php echo htmlspecialchars($row['info'], ENT_QUOTES, 'UTF-8'); ?></div>
                <p style="margin: 14px 0 0; text-align: right; color: #1046a0; font-weight: 700;"><?php echo htmlspecialchars($row['posted_by'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <?php
                }
                if ($pager) {
            ?>
            <div class="admin-page-pagination"><?php echo $pager->renderFullNav(); ?></div>
            <?php
                }
            } else {
            ?>
            <div class="admin-page-empty">No posted notice is available yet.</div>
            <?php } ?>
        </div>
    </div>
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
