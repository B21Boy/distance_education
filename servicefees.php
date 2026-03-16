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
<title>Service Fees</title>
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
            <p><strong>Distance Education</strong></p>
            <p><strong>Service Fees</strong></p>
            <p>All students in Bahir Dar University of the continuing and distance studies benefit from a reduced tuition rate—a rate set with the realities of the learners in mind. This is more affordable than comparable universities, and considerably less than the actual cost incurred in rendering the services.</p>
            <table width="100%" border="1">
            <tbody>
            <tr>
            <td rowspan="2" width="6%">&nbsp;<p></p>
            <p>No.</p></td>
            <td rowspan="2" width="35%">&nbsp;<p></p>
            <p>Type of service</p></td>
            <td rowspan="2" width="23%">&nbsp;<p></p>
            <p>Unit</p></td>
            <td colspan="2" width="34%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amount of payment</td>
            </tr>
            <tr>
            <td width="15%">Main campus</td>
            <td width="18%">Branches</td>
            </tr>
            <tr>
            <td width="6%">1</td>
            <td width="35%">Application</td>
            <td width="23%">Once only</td>
            <td width="15%">50.00</td>
            <td width="18%">50.00</td>
            </tr>
            <tr>
            <td width="6%">2</td>
            <td width="35%">Registration</td>
            <td width="23%">Per semester</td>
            <td width="15%">70.00</td>
            <td width="18%">70.00</td>
            </tr>

            </tbody>
            </table>
            <p>&nbsp;</p>
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