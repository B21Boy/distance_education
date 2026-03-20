<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
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
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
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
	$sql1=mysql_query("SELECT * from postss where status='apply' ORDER BY dates ASC") or die(mysql_error());	
	$ro=mysql_num_rows($sql1);
	$sql="SELECT * from postss where status='apply' ORDER BY dates DESC";
	$pager = new PS_Pagination($conn,$sql,1,10);
	$rs = $pager->paginate();
	if($ro!='0')
	{
	while($row=mysql_fetch_array($rs))
	{
            echo"<p align='right'><b>Date:</b>"."<u>".$row['dates']."</u>"."</p>";
            echo"<font face='monotype corsiva' size='7' color='#347098'><center>"."<u>".$row['Title']."</u>"."</center>"."</p>";
             
           	
			echo"<font face='monotype corsiva' size='5' color='#0c395f'><center>".$row['types']."</center>"."</p>"."</font>";
			echo "<font  size='3' color='#00000b'>".$row['info'];
           echo"<font size='4' color='#1046a0'><center>".$row['posted_by']."</center>"."</p>";
echo '<div align="right"><a style=font-size:30px rel="facebox" href="updatepostapplicant.php?id='.$row['no'].'">Update Application date</a></div>';	

	}
	}
	else
	{
		echo "There No Post Notice!!!";
		?>
		<a rel="facebox" href="postapplicant.php" style="margin-left: 400px">Post Application date</a>
		<?php
		
	}
echo '<div style="text-align:center;font-size:25px;color:red;bgcolor:blue">'.$pager->renderFullNav().'</div>';
?>
</fieldset>
</div></div>
	 <div id="sidebar">
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
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
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>
<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
