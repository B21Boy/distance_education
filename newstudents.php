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
<title>New Students</title>
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
            <!--body-->

            <i><font color="blue" size="5px">Criteria's to attend BDU Distance Education learning system as a new student</font></i><br>
               <font style="strong" size="3px">1:The student can be admitted if and only if he/she complete grade 12 pass marks or 10+3(diploma).<br>
                2: For grade 12, the pass mark must be above based on the ministry of education.<br>
                3: To be accepted by natural science fields, the student must be natural science student.<br>
                4: For diploma students their major and minor courses must be related to the course they select to register.<br>
                5: Students must pay 100 birr in tfhe chap payment based on release the finacial staff .<br>
                6: Students must receive recite and give the recite to be admitted.<br>
                7:New student admitting must happens at the beginning of the first academic year<br></font>
                <font size="3px" color="blue"><h4><u>N.B </u>For registration ,students will pay 100 birr for the first registration weeks.If registration is passed,those students who come later
            will pay a penality of 100 birr for the campus in its internal account and submit the reciet to the registrar for renew.</h4></font>

            <!--body-->
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
