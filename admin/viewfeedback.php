<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css"/>
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
<script src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
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
            <?php require("sidemenu.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">

            <?php
                //Include the PS_Pagination id
                    include('ps_pagination.php');

                //Connect to mysql db
                $conn = mysql_connect('localhost','root','');
                if(!$conn) die("Failed to connect to database!");
                $status = mysql_select_db('cde', $conn);
                if(!$status) die("Failed to select database!");
            ?>

            <p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php include '../connection.php'; $count_item=mysql_query("select * from feed_back " ) or die(mysql_error());
            $count=mysql_num_rows($count_item);
            //$a=count($sql2);
            if($count>=1)
            {
            echo"<font color='red'>".($count)."</font>"; ?></p>
            <?php

                 $sql = "SELECT * FROM feed_back  ORDER BY date DESC";
                $pager = new PS_Pagination($conn, $sql, 10, 1);
                $rs = $pager->paginate();
            ?>
            <form name="frmUser" method="post" action="" id="frm1">
            <table border="0" width="600px"cellpadding="1" id="resultTable">
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th>UserType</th>
            <th>comment</th>
            <th>date</th>
            <th>delete</th>
            </tr>
            </tr>
            <?php
            $i=0;
            while($row = mysql_fetch_array($rs)) {
                $id=$row['fbid'];
            ?>
            <tr>

            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["role"]; ?></td>
            <td><?php echo $row["Comment"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo '<a href="deletefeedback.php?id='.$row['email'].'">Delete</a>';?></td>
            </tr>
            <?php
            }
            ?>
            </table>
            <?php
                echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
                }
                else
                echo"<br/>no comment";
            ?>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
                        echo "<b><br><font color=blue>Welcome:</font><font color=#f9160b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
                    ?>
                    <div id="sidebarr">
                        <ul>
                            <li><a href="updateprofilephoto.php">Change Photo</a></li>
                            <li><a href="changepass.php">Change password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
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
        <?php include("../footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
