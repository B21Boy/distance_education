<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
<style>
.registrar-overview-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
    margin-top: 24px;
}
.registrar-overview-item {
    padding: 20px;
    border: 1px solid #dbe5f0;
    border-radius: 16px;
    background: #ffffff;
    box-shadow: 0 12px 26px rgba(17, 52, 84, 0.08);
}
.registrar-overview-item h2 {
    margin: 0 0 10px;
    color: #163b60;
    font-size: 18px;
}
.registrar-overview-item p {
    margin: 0;
    color: #4f647d;
    line-height: 1.7;
    font-size: 14px;
}
.registrar-overview-highlight {
    margin-top: 24px;
    padding: 18px 20px;
    border-radius: 16px;
    background: linear-gradient(135deg, #e8f1ff 0%, #f5f9ff 100%);
    border: 1px solid #cfe0f5;
    color: #244765;
    line-height: 1.7;
}
@media (max-width: 760px) {
    .registrar-overview-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menuro.php"); ?></div>

    <div class="main-row">
        <div id="left"><?php require("sidemenuro.php"); ?></div>

        <div id="content">
            <div id="contentindex5">
                <div class="registrar-page-card">
                    <div class="registrar-page-header">
                        <span class="registrar-page-eyebrow">Registrar Dashboard</span>
                        <h1 class="registrar-page-title">Welcome to the Registrar Officer Page</h1>
                        <p class="registrar-page-copy">The registrar office manages student academic records, supports semester-based updates, coordinates grade and ID workflows, and keeps official student information accurate across the system.</p>
                    </div>

                    <div class="registrar-overview-grid">
                        <div class="registrar-overview-item">
                            <h2>Student Record Management</h2>
                            <p>Review student data, import registration information, and keep academic records complete and organized for each department and class year.</p>
                        </div>
                        <div class="registrar-overview-item">
                            <h2>Grade and Report Processing</h2>
                            <p>Prepare grade reports, confirm approved results, and help maintain clear academic performance records for students and departments.</p>
                        </div>
                        <div class="registrar-overview-item">
                            <h2>Semester and ID Operations</h2>
                            <p>Support semester progression, update student year and semester status, and generate student IDs for newly approved learners.</p>
                        </div>
                        <div class="registrar-overview-item">
                            <h2>Communication and Calendar Support</h2>
                            <p>Send notifications, respond to messages, and publish academic calendar information so students and staff stay informed.</p>
                        </div>
                    </div>

                    <div class="registrar-overview-highlight">
                        Use the navigation menu to manage registrar tasks quickly, including grade preparation, student data registration, notifications, password updates, and other core academic administration work.
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
    </div>

    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
