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
    function cde_general_notice_text(string $value): string
    {
        return htmlspecialchars(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
    }

    $messages = array();
    $result = mysqli_query($conn, "SELECT no, Title, types, dates, Ex_date, start_date, end_date, info, posted_by, status FROM postss WHERE status=' ' ORDER BY dates DESC, no DESC");
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
        mysqli_free_result($result);
    }

    $ro = count($messages);
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
                <h1 class="admin-page-title">Post Updated Information</h1>
                <p class="admin-page-copy">Manage the current notice board and publish a new announcement through the popup editor.</p>
            </div>
        </div>
        <div class="admin-page-panel">
            <div class="admin-page-toolbar">
                <span class="page-stat-chip"><?php echo (int) $ro; ?> notice record<?php echo $ro == 1 ? '' : 's'; ?></span>
                <a rel="facebox" href="posti.php" class="page-nav-link is-primary">Post Updated Information</a>
            </div>
            <?php if (!empty($messages)) {
                foreach ($messages as $row) {
            ?>
            <div class="admin-page-status-card" style="margin-bottom: 18px;">
                <p style="margin: 0 0 8px; text-align: right;"><strong>Date:</strong> <?php echo htmlspecialchars((string) $row['dates'], ENT_QUOTES, 'UTF-8'); ?></p>
                <h2 style="margin: 0 0 10px; color: #12395f;"><?php echo cde_general_notice_text((string) $row['Title']); ?></h2>
                <p style="margin: 0 0 14px; color: #1e5788; font-weight: 700;"><?php echo cde_general_notice_text((string) $row['types']); ?></p>
                <div style="white-space: pre-wrap; color: #17364e;"><?php echo cde_general_notice_text((string) $row['info']); ?></div>
                <p style="margin: 14px 0 0; text-align: right; color: #1046a0; font-weight: 700;"><?php echo cde_general_notice_text((string) $row['posted_by']); ?></p>
            </div>
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
