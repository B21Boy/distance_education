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
<title>Developers</title>
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
            <div style="height:500px; width:500px;">
            <section id="contact">
             <h3 class="slanted">Contact Us</h3>

                  <table width="430px" height="320px" border="4" cellspacing="8" cellpadding="8"  style="text-align:left;color:black;">
                                <font align="center"><i><h4>Developer Members List</h4></i></font>
                                <tr bgcolor="#80998e;">
                                    <td>ID Number</td>
                                    <td>Name</td>
                                    <td>Sex</td>
                                    <td>E-Mail</td>
                                    <td>Photo</td>
                                </tr>
                                <tr>
                                    <td align="center">TER/4641/07</td>
                                    <td align="center">Deksiyos Yismaw</td>
                                    <td align="center">M</td>
                                    <td>deksiman721@gmail.com</td>
                                    <td><img src="jb2/abie.jpg" height="50" width="100%"></td>
                                </tr>
                                <tr>
                                    <td align="center">TER/4656/07</td>
                                    <td align="center">Medhanit Melesse</td>
                                    <td align="center">F</td>
                                    <td>medihanit@gmail.com</td>
                                    <td><img src="jb2/dess.jpg" height="50" width="100%"></td>

                                </tr>
                                <tr>
                                    <td align="center">TER/4645/07</td>
                                    <td align="center">HaileMichael Melesse</td>
                                    <td align="center">M</td>
                                    <td>haile@gmail.com</td>
                                    <td><img src="jb2/asse.jpg" height="50" width="100%"></td>

                                </tr>
                                <tr>
                                    <td align="center">TER/4657/07</td>
                                    <td align="center">Rediet</td>
                                    <td align="center">F</td>
                                    <td>Rediet@gmail.com</td>
                                    <td><img src="jb2/emeb.jpg" height="50" width="100%"></td>

                                </tr>
                            
                            </table>
                    </section>
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