<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
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
                    include('ps_pagination.php');
                    // use centralized mysqli connection from ../connection.php

                ?>
                <form action="" method="post">

                <?php
                    $sql = "SELECT * FROM student where unread='no'";
                        $pager = new PS_Pagination($conn, $sql, 12, 1);
                    $rs = $pager->paginate();

                        $sql2 = "SELECT * FROM entrance_exam where status='unsatisfactory' and (account=' ' or account='seen')";
                        $pager2 = new PS_Pagination($conn, $sql2, 12, 1);
                    $rs2 = $pager2->paginate();

                    $query = mysqli_query($conn, "select * from student where unread='no' ORDER BY Department ASC")or die(mysqli_error($conn));
                    $coun = mysqli_num_rows($query);

                    $query1 = mysqli_query($conn, "select * from entrance_exam where status='unsatisfactory' and (account=' '  or account='seen') ORDER BY S_ID ASC")or die(mysqli_error($conn));
                    $coun1 = mysqli_num_rows($query1);
                $total=$coun+$coun1;
                if ($total != '0'){
                    if($coun!=0)
                    {
                ?>
                List of students Create Account for All Students<a href="generatepassword.php"  style="color: blue;background-color:pink; font-size: 20px;text-decoration: none;">Create Account For All Students</a>
                <table  id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
                <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Sex</th>
                <th>Email</th>
                <th>PhoneNo</th>
                <th>College</th>
                <th>Department</th>


                </tr>
                <?php
                $i=0;
                while($row1 = mysqli_fetch_array($rs)){
                $id=$row1["S_ID"];

                ?>

                <tr>
                <div class="post"  id="del<?php echo $id; ?>">
                <td><?php echo $row1["S_ID"]; ?></td>
                <td><?php echo $row1["FName"]; ?></td>
                <td><?php echo $row1["LName"]; ?></td>
                <td><?php echo $row1["Sex"]; ?></td>
                <td><?php echo $row1["Email"]; ?></td>
                <td><?php echo $row1["Phone_No"]; ?></td>
                <td><?php echo $row1["College"]; ?></td>
                <td><?php echo $row1["Department"]; ?></td>

                </div>
                                        <?php
                                        }
                                        ?>
                                        </tr>
                                        </table>
                                        </form>
                                        <?php
                                        echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
                                        }
                if($coun1!=0)
                    {
                ?>
                List of students Block Account
                <table  id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
                <tr>
                <th>Student ID</th>
                <th>Department</th>
                <th>Status</th>
                <th>Status2</th>
                <th>Action</th>
                </tr>
                <?php
                while($row11 = mysqli_fetch_array($rs2)){
                $id=$row11["S_ID"];
                $query0 = mysqli_query($conn, "select * from student where S_ID='$id'")or die(mysqli_error($conn));
                    $row110 = mysqli_fetch_array($query0);
                    $dpt=$row110['Department'];
                ?>

                <tr>
                <div class="post"  id="del<?php echo $id; ?>">
                <td><?php echo $row11["S_ID"]; ?></td>
                <td><?php echo $dpt; ?></td>
                <td><?php echo $row11["status"]; ?></td>
                <td style="color: green;font-size: 20px"><?php echo $row11["account"]; ?></td>
                <td><a href="ACTIONs.php?status=<?php echo $row11['S_ID'];?>"
                 id="btn" onchange="Block" onclick="return confirm('Are you sure <?php echo $id?>');">
                 <?php
                        $select=mysqli_query($conn, "select * from account WHERE UID='$id' ");
                        $row=mysqli_fetch_object($select);
                        $status_var=$row->status;
                    ?>
                     <input type="button" value="Block" style="background-color: #243cdb;color: #fffbfb;height: 25px;width: 100px; text-decoration: none;"/> </a></td>


                </div>
                                        <?php
                                        }
                                        ?>
                                        </tr>
                                        </table>

                                        <?php
                                        echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
                                        }
                                        }else{ ?>
                <div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</font></div>
                                        <?php } ?>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
                        echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
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
