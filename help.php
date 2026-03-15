<?php
session_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Help</title>
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

            <h1>Scope Of The Project<br></h1>
                            -Online application service to admit new and senior students.<br>
                            -Online academic services like:<br>
                          - Resource downloading <br>
                            -Online communication<br>
                          -Advertisement<br>
                            -Resource uploading <br>
                            -View grade<br>
            <h1> Purpose/Significance<br></h1>
                -Since users can access the system everywhere they  can get different services at the same time and hence the system saves time.<br>
                -The newly developed system is web based and gives online services. Since every activity is done by computer.<br>
                -It minimizes the workload of both students and workers. Because students can be admitted wherever they are and can communicate with their teacher online. Since they can download modules, they save the time to copy it. <br>-The system can perform every activity that can be done by the workers.<br>
                -Since every information and document is stored on the database, there will not be any redundancy and losing of data.<br>
                -The system allows searching and updating any selective information easily if it is already on the database. It does not take time to retrieve data as the existing system.<br>
                -It also minimizes material wastage that can be lost for printing and copying bulk of modules. And since one person can perform different activities using the system, it can also minimize man power.<br>
                -The system is easy to use and its interface is user friendly.<br><br>


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