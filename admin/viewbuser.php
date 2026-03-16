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
<script src="js/validation.js" type="text/javascript"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
                <p align="center" style="color: blue;"><b>Blocked User in the organization</b></p>
            <p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php include '../connection.php';
             $count_item=mysqli_query($conn, "select * from account WHERE status='no'" ) or die(mysqli_error($conn));
            $count=mysqli_num_rows($count_item);
            //$a=count($sql2);
            echo"<font color='red'>".($count)."</font>"; ?></p>
            <?php
            // use existing mysqli connection ($conn) from include above
            $result = mysqli_query($conn, "SELECT * FROM account WHERE status='no'");
            ?>

            <table cellpadding="1" cellspacing="1" id="resultTable" style="margin-left: -20px;">

            <tr>
            <th>UID</th>
            <th>First<br>Name</th>
            <th>Last<br>Name</th>
            <th>User<br>Type</th>
            <th>Sex</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Action</th>
            </tr>
            <?php
            while($myrow = mysqli_fetch_array($result)) {
                $id = $myrow['UID'];
                $result1 = mysqli_query($conn, "SELECT * FROM user WHERE UID='$id'");
                $myrow1 = mysqli_fetch_array($result1);
                echo "<tr>";
                echo "<td>" . $myrow['UID']. "</td>";
                echo "<td>" . $myrow1['fname']. "</td>";
                echo "<td>" . $myrow1['lname']. "</td>";
                echo "<td>" . $myrow['Role']. "</td>";
                echo "<td>" . $myrow1['sex']. "</td>";
                echo "<td>" . $myrow1['Email']. "</td>";
                echo "<td>" . $myrow1['phone_No']. "</td>";
                echo "<td>" . $myrow1['location']. "</td>";


                $data5 = $myrow['status'];
                $data3 = 'yes';
            ?>
            <?php
             $select = mysqli_query($conn, "select * from account WHERE UID='$id' ");
             $row = mysqli_fetch_assoc($select);
             $status_var = isset($row['status']) ? $row['status'] : '';
             $confirm_js = "return confirm('Are you sure $id');";
             if ($status_var == 'yes') {
                 echo '<td><a href="ACTIONVBU.php?status=' . $myrow['UID'] . '" id="btn" onclick="' . $confirm_js . '"><input type="button" value="Block" style="background-color: #243cdb;color: #fffbfb;height: 25px;width: 100px; text-decoration: none;"/></a></td>';
             } else {
                 echo '<td><a href="ACTIONVBU.php?status=' . $myrow['UID'] . '" id="btn" onclick="' . $confirm_js . '"><input type="button" value="UNBlock" style="background-color: red;color: #ffffff;height: 25px;width: 100px; text-decoration: none;"/></a></td>';
             }
            ?>
            </tr>
            <?php } ?>
            </table>
            <?php
            // do not close shared $conn (managed in connection.php)
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


