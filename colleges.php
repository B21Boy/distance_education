<?php
session_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Colleges</title>
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
            <strong><i>The colleges in Bahir Dar University are: </i><br></strong>
            <ol type="1">
            <li><h4>Agriculture and Natural resource</h4></li>
            <ul type="disc">
            <li>Rural Development</li>
            <li>Plant Science</li>
            <li>Animal Science</li>
            <li>Natural Res.Management</li>
            <li>Horticulture</li>
            </ul>

            <li><h4>Natural and Computational Science</h4></li>
            <ul type="square">
            <li>Chemistry</li>
            <li>Physics</li>
            <li>Mathematics</li>
            <li>Biology</li>
            <li>Sport Science</li>
            <li>Statistics</li>
            </ul>

            <li> <h4>Business and Economics</h4></li>
            <ol type="i">
            <li>Economics</li>
            <li>Accounting</li>
            <li>Management</li>
            </ol>

            <li><h4>Health Science</h4></li>
            <ol type="1">
            <li>Nursing</li>
            <li>Public health science</li>
            <li>Midwifery</li>
            <li>NIMEI</li>
            </ol>

            <li><h4>Social Science and Humanities</h4></li>
            <ol type="a">
            <li>English</li>
            <li>Amharic</li>
            <li>History</li>
            <li>Geography</li>
            <li>Psychology</li>
            <li>Sociology</li>
            </ol>
            </ol>
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