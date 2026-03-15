<?php
session_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>News</title>
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
            <?php
            include('ps_pagination.php');
            $conn = mysql_connect('localhost','root','');
            if(!$conn) die("Failed to connect to database!");
            $status = mysql_select_db('cde', $conn);
            if(!$status) die("Failed to select database!");
            ?>

            <fieldset><legend>Notice Board</legend>
            <?php

            $date=date('Y-m-d');
            $sql1=mysql_query("SELECT * from postss where Ex_date>='$date' ORDER BY dates ASC") or die(mysql_error());
            $ro=mysql_num_rows($sql1);
            if($ro!='0')
            {

            $sql="SELECT * from postss where Ex_date>='$date' ORDER BY dates DESC";
            $pager = new PS_Pagination($conn,$sql,1,10);
            $rs = $pager->paginate();
            while($row=mysql_fetch_array($rs))
            {

                        echo"<p align='right'><b>Date:</b>"."<u>".$row['dates']."</u>"."</p>";
                        echo"<font face='monotype corsiva' size='7' color='#347098'><center>"."<u>".$row['Title']."</u>"."</center>"."</p>";

                        echo"<font face='monotype corsiva' size='5' color='#0c395f'><center>".$row['types']."</center>"."</p>"."</font>";
                        echo "<font  size='3' color='#00000b'>".$row['info'];
                       echo"<font size='4' color='#1046a0'><center>".$row['posted_by']."</center>"."</p>";


            }
            }
            else
            {
                echo '<script type="text/javascript">alert("There No Post Notice!!!");</script>';

            }
            echo '<div style="text-align:center;font-size:25px;color:red;bgcolor:blue">'.$pager->renderFullNav().'</div>';
            ?>
            </fieldset>
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