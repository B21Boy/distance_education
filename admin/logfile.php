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

            <?php
                //Include the PS_Pagination id
                    include('ps_pagination.php');

                // Use centralized mysqli connection
                include('../connection.php'); // provides $conn (mysqli)
                if (!($conn instanceof mysqli)) {
                    die("Database connection failed or not available.");
                }
            ?>
            <form method="post" action="" name="form1" id="form1">
            <p style="font-size:18px; margin-left:100px;">Search log user  <input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" id="textboxid" placeholder="username/usertype"/>
                            <input type="submit"  id="btn btn-primary" name="submit" style="height: 30px;width: 100px;background-color: #2773d8;" value="Filter"></p>
            </form>
            <?php
            if (isset($_POST['submit']) and isset($_POST['search_file'])) {
                $search_file = $_POST['search_file'];

                $sql = "SELECT * FROM logfile where logid like '%$search_file%' or role like '%$search_file%'  Order by start_time desc";
                $try = mysqli_query($conn, $sql);


            if (mysqli_num_rows($try) >= 1) {
                $pager = new PS_Pagination($conn, $sql, 4, 1);
                $rs = $pager->paginate();

                 ?>
            <form name="frmUser" method="post" action="" id="frm1">
            <table  width="600" cellpadding="1"  id="resultTable">
            <tr >
            <th colspan=7 align="center" style="background-color: #767889;color: blue"  ><font style="margin-left: 200px;font-size: 20px"> Log users in the site</font></th></tr>
            <tr>
            <th>UserName</th>
            <th>UserType</th>
            <th>Login time</th>
            <th>activity type</th>
            <th>activity performed</th>
            <th>ip address</th>
            <th>Logout time</th>

            </tr>
            <?php
            $i=0;
            while($myrow = mysqli_fetch_array($rs)) {
            echo "<tr  style=height: 400px;>";
            echo "<td>" . $myrow[1]. "</td>";
            echo "<td>" . $myrow[2]. "</td>";
            echo "<td>" . $myrow[4]. "</td>";
            echo "<td>" . $myrow[5]. "</td>";
            echo "<td>" . $myrow[6]. "</td>";
            echo "<td>" . $myrow[8]. "</td>";
            echo "<td>" . $myrow[9]. "</td>";
            echo "</tr>";

            $i++;
            }
            ?>
            </table>
            </form>
            <?php
            echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
            }
            else{

            echo "no result found!!";

             }

             }
             else
             {
                $sql = "SELECT * FROM logfile ORDER BY logid desc ";
                $pager = new PS_Pagination($conn, $sql, 4, 1);
                $rs = $pager->paginate();
            ?>
            <form name="frmUser" method="post" action="" id="frm1">
            <table  width="600px" cellpadding="1" id="resultTable">
            <tr>
            <th colspan=7 align="center" style="background-color: #767889;color: blue"  ><font style="margin-left: 200px;font-size: 20px"> Log users in the site</font></th></tr>
            <tr>
            <th>UserName</th>
            <th>UserType</th>
            <th>Login time</th>
            <th>activity type</th>
            <th>activity performed</th>
            <th>ip address</th>
            <th>Logout time</th>

            </tr>

            <?php
            $i=0;
            while($myrow = mysqli_fetch_array($rs)) {
            echo "<tr  style=height: 400px;>";
            echo "<td>" . $myrow[1]. "</td>";
            echo "<td>" . $myrow[2]. "</td>";
            echo "<td>" . $myrow[4]. "</td>";
            echo "<td>" . $myrow[5]. "</td>";
            echo "<td>" . $myrow[6]. "</td>";
            echo "<td>" . $myrow[8]. "</td>";
            echo "<td>" . $myrow[9]. "</td>";
            echo "</tr>";
            $i++;
            }
            ?>
            </table>
            </form>
            <?php
                echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
                }
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
