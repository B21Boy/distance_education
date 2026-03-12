

<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">

<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menustud.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenustud.php");
?>
	
</td><td>
	<div id="contentindex5">

<?php

$uid=$_SESSION['suid'];
$un=$_SESSION['sun'];
$dpt=$_SESSION['sdpt'];
$sem=$_SESSION['ssemister'];
$sec=$_SESSION['ssection'];
$yea=$_SESSION['syear'];

$y=date('Y');
$query = "select * from entrance_exam where year='$y' and S_ID='$uid'";
$result = mysql_query($query);
$c=mysql_num_rows($result);
if($c>='1')
{
$query1 = "select * from student where S_ID='$uid'";
$result1 = mysql_query($query1);
$row1=mysql_fetch_array($result1)
?>
Students Entrance Exam result
<table cellpadding="1" cellspacing="1" id="resulttable">
	<tr>
		<th>Temo_ID</th>
		<th>Result</th>
		<th>Department</th>
		<th>Year</th>
		<th>Status</th>
		<th>Section</th>
	</tr><tr>
	<?php
	while($row=mysql_fetch_array($result))
	{
?>
<td><?php echo $row['S_ID'];?></td>
<td><?php echo $row['result'];?></td>
<td><?php echo $dpt;?></td>
<td><?php echo $row['year'];?></td>
<td><?php echo $row['status'];?></td>
<td><?php echo $row1['section'];?></td>
<?php
	}								
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ipaddress=$http_client_ip;
		}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ipaddress=$http_x_forwarded_for;	
		}else{
			$ipaddress=$_SERVER['REMOTE_ADDR'];
		}
				$time = time();
			$actual_time = date('d M Y @ H:i:s', $time);
			$user=$_SESSION['suid'];
			$status='yes';
			$da=date('y-m-d');
			mysql_query("update entrance_exam set account='seen' where S_ID='$uid'");
	?>
</tr></table>
<?php
}
else
echo'Not Found';
?>
</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#e70f0a>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
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
	  </td>
	 </tr>
	 <tr><td>
<?php
include("../footer.php");
?>
</td></tr>
</table>
</div>

<?php
}
else
header("location:../index.php");
?>
</body>
</html>