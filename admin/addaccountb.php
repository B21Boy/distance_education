<?php
session_start();
include(__DIR__ . '/../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
.account-shell {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
}
.account-shell-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 22px;
}
.account-shell-kicker {
    display: inline-block;
    margin-bottom: 8px;
    padding: 4px 10px;
    border-radius: 999px;
    background: #d9e9fb;
    color: #174a7c;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.account-shell-header h1 {
    margin: 0;
    color: #12395f;
    font-size: 28px;
}
.account-shell-header p {
    margin: 10px 0 0;
    max-width: 720px;
    color: #4a6480;
    line-height: 1.6;
}
@media (max-width: 720px) {
    .account-shell {
        padding: 16px;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
?>
<div id="container">
<div id="header"><?php require('header.php'); ?></div>
<div id="menu"><?php require('menu.php'); ?></div>
<div class="main-row">
<div id="left"><?php require('sidemenu.php'); ?></div>
<div id="content">
<div id="contentindex5">
<div class="account-shell">
    <div class="account-shell-header">
        <div>
            <span class="account-shell-kicker">Admin</span>
            <h1>Account Access Control</h1>
            <p>Review account records, filter users quickly, and block or unblock login access using the same standard admin page layout.</p>
        </div>
    </div>
    <?php require('createaccountb.php'); ?>
</div>
</div>
</div>
<div id="sidebar"><?php require('rightsidebar.php'); ?></div>
</div>
<div id="footer"><?php include('../footer.php'); ?></div>
</div>
<?php
} else {
    header('location:../index.php');
    exit;
}
?>
</body>
</html>
