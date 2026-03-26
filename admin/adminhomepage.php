<?php
session_start();
include(__DIR__ . '/../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<script src="../javascript/date_time.js"></script>
<style>
.admin-home-grid {
    display: grid;
    gap: 20px;
}
.admin-home-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
.admin-home-card {
    padding: 20px;
    border-radius: 16px;
    border: 1px solid #dce6f2;
    background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
}
.admin-home-card h3 {
    margin: 0 0 10px;
    color: #12395f;
    font-size: 18px;
}
.admin-home-card p {
    margin: 0;
    color: #4a6480;
    line-height: 1.6;
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
                <div class="admin-home-grid">
                    <div class="admin-page-shell">
                        <div class="admin-page-header">
                            <div>
                                <span class="admin-page-kicker">Admin</span>
                                <h1 class="admin-page-title">Welcome to the Admin Page</h1>
                                <p class="admin-page-copy">Use the administrator dashboard to manage users, student accounts, backups, feedback, and the rest of the system with the same standard layout used across the admin pages.</p>
                            </div>
                        </div>
                        <div class="admin-page-panel">
                            <div class="admin-home-summary">
                                <div class="admin-home-card">
                                    <h3>User Management</h3>
                                    <p>Add users, review records, and control account access from the admin tools.</p>
                                </div>
                                <div class="admin-home-card">
                                    <h3>Database Tasks</h3>
                                    <p>Create backups, restore the backup database, and monitor logs from the admin section.</p>
                                </div>
                                <div class="admin-home-card">
                                    <h3>System Review</h3>
                                    <p>Check feedback, blocked users, and student account requests in one consistent workspace.</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
