<?php
session_start();
ob_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Contact Us</title>
<link rel="stylesheet" href="setting.css">
<style>
/* inline fallback when stylesheet isn't loaded: keep columns, spacing, and proportions */
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
<script src="javascript/date_time.js"></script>
</head>
<body class="student-portal-page">

<div id="container">

    <!-- Header -->
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <!-- Menu -->
    <div id="menu">
        <?php require("menu.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php include("left.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="bodydivision">
                <h1>Contact Us</h1>
                <table border="0">
                    <tr>
                        <td>Department Head Office</td>
                    </tr>
                    <tr>
                        <td>10, Ground</td>
                    </tr>
                    <tr>
                        <td><strong>Tel:</strong> (+251)-011-9-54-10-18/15</td>
                    </tr>
                    <tr>
                        <td><strong>Fax:</strong> (+251)-011-290-79-44</td>
                    </tr>
                    <tr>
                        <td><strong>E-mail:</strong> <a href="mailto:a@gmail.com">Head.gmail.com</a></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Registrar</td>
                    </tr>
                    <tr>
                        <td>Ato xx yy</td>
                    </tr>
                    <tr>
                        <td>205, 2<sup>nd</sup> Floor, Father Block</td>
                    </tr>
                    <tr>
                        <td><strong>Tel:</strong> (+251)-011-6-90-10-18/15</td>
                    </tr>
                    <tr>
                        <td><strong>Fax:</strong> (+251)-011-290-79-44</td>
                    </tr>
                    <tr>
                        <td><strong>E-mail:</strong> <a href="mailto:a@gmail.com">registrar.gmail.com</a></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Instructors</td>
                    </tr>
                    <tr>
                        <td>Ato AA BB</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Tel:</strong> (+251)-011-6-54-10-10</td>
                    </tr>
                    <tr>
                        <td><strong>Fax:</strong> (+251)-011-275-79-10</td>
                    </tr>
                    <tr>
                        <td><p>E-mail: <a href="mailto:abebawaddis2015@gmail.com"><span style="font-family: arial, helvetica, sans-serif;"><strong><span style="font-size: 10pt;">DMU-Distance-Education-service@gmail.com</span></strong></span></a></p></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <?php require("leftlogin.php"); ?>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <?php include("footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>