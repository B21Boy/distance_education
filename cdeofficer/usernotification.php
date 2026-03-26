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
$user_id = $_SESSION['suid'];
$messages = array();
$sql = "SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
while ($row = mysql_fetch_array($result)) {
    $sender_id = $row['M_sender'];
    $result1 = mysql_query("select * from user where UID='$sender_id'") or die(mysql_error());
    $row1 = mysql_fetch_array($result1);
    $row['sender_name'] = trim($row1['fname'] . ' ' . $row1['lname']);
    $messages[] = $row;
}
?>
    <div class="admin-page-shell">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-kicker">CDE Officer</span>
                <h1 class="admin-page-title">View and Send Messages</h1>
                <p class="admin-page-copy">Review unread messages and open the popup composer to send a new internal message.</p>
            </div>
        </div>
        <div class="admin-page-panel">
            <div class="admin-page-toolbar">
                <span class="page-stat-chip"><?php echo (int) $count; ?> unread message<?php echo $count == 1 ? '' : 's'; ?></span>
                <a rel="facebox" href="newnotification1.php" class="page-nav-link is-primary">New Message</a>
            </div>
            <?php if ($count < 1) { ?>
            <div class="admin-page-empty">No unread messages were found.</div>
            <?php } else { ?>
            <div style="display: grid; gap: 16px;">
                <?php foreach ($messages as $message) { ?>
                <div class="admin-page-status-card">
                    <div style="display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:10px;">
                        <strong style="color:#12395f;"><?php echo htmlspecialchars($message['sender_name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        <span style="color:#60748c;"><?php echo htmlspecialchars($message['date_sended'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div style="white-space: pre-wrap; color:#17364e;"><?php echo htmlspecialchars($message['message'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div style="margin-top:14px;">
                        <a rel="facebox" href="viewnotification1.php?M_ID=<?php echo urlencode($message['M_ID']); ?>" class="page-nav-link">Reply</a>
                    </div>
                </div>
                <?php } ?>
            </div>
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
