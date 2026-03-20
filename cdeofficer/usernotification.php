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
//mag show sang information sang user nga nag login
$user_id=$_SESSION['suid'];


?>
<!--center side---->
<p align="center"><font face="Times New Roman" color="black" size="4"> View And Send Message</font></p>

<table width="635" height="600px"  align="center">
    <tr>
     <td  valign="top" height="600px" width="635">
<form  method="POST" action="viewnotification.php">
<table align="center" border="0" cellpadding = "10" WIDTH="" height="60"bgcolor="#EEEEEE">
<tr>
<td colspan="3" align="center" bgcolor="white">



<?php
	//first fetch whom u have send chats
	
		
$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	echo '<a  rel="facebox" href="newnotification1.php">'.'<font  size=3 face=Times New Roman>'."New Message"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."</font>".'</a>';
	if($count<1)
	{
	echo('<font color="black" size="3" face="Times New Roman">No New Message</font>');
	}
	else
	{
	while ($row = mysql_fetch_array($result))
	{
		$s=$row['M_sender'];
$result1=mysql_query("select * from user where UID='$s'")or die(mysql_error);
$row1=mysql_fetch_array($result1);
$FirstName=$row1['fname'];
$middleName=$row1['lname'];
	    echo "<table  width='400' height='100'/>";
		echo "<hr style='border-top:3px solid #c3c3c3; border-bottom:1px solid white'/>";
		echo "<br/><font color=black size=3 face=Times New Roman> $FirstName&nbsp;&nbsp;$middleName </br>";
		echo "<br/> $row[message]<br/>";
		echo "<br/> $row[date_sended]"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
		'<a  rel="facebox" href="viewnotification1.php?M_ID='.$row['M_ID'].'">'."Replay".'</a>';
		 echo "</table>";
	}
	}

?>
</td>
</tr>
</table>
</td>
</tr>
</table>     
<!--end of center side---->
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
