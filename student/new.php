<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
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
        <?php require("menustud.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenustud.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">
		<?php
		include('ps_pagination.php');
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
?>

	<fieldset><legend>Notice Bored</legend>
<?php

	$date=date('Y-m-d');
	$sql1=mysql_query("SELECT * from postss where Ex_date>='$date' ORDER BY dates ASC") or die(mysql_error());	
	$ro=mysql_num_rows($sql1);
	if($ro!='0')
	{
		
	$sql="SELECT * from postss where Ex_date>='$date' ORDER BY dates DESC";
	$pager = new PS_Pagination($conn,$sql,1,1);
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
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>


                <?php
                echo "<b><br><font color=blue>Welcome:</font><font color=#c02918>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
                ?>
                <div id="sidebarr">
                    <ul>
                        <li><a href="updateprofilephoto.php">Change Photo</a></li>
                        <li><a href="changepass.php">Change password</a></li>
                    </ul>
                </div>
            </div>
            <div id="siderightindexadational">
                <div id="siderightindexadational1">
                    Social link
                </div>
                <div id="siderightindexadational12">
                    <table>
                        <tr><td><div id="facebook"></div></td><td>
                        <p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
                        <tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
                        <tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
                        <tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>
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