<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Department head page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
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
    require("menudepthead.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenudepthead.php");
?>
	
</td><td>
	<div id="contentindex5">

<?php
//mag show sang information sang user nga nag login
$user_id=$_SESSION['suid'];


?>
<!--center side---->
<p align="center"><font face="Times New Roman" color="black" size="4"> View And Send Message</font></p>

<table width="635"  align="center">
    <tr>
     <td  valign="top"  width="635">
<form  method="POST" action="viewnotification.php">
<table align="center" border="0" cellpadding = "10" bgcolor="#EEEEEE">
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
	    echo "<table   width='400' height='100'/>";
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
	</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#f9160b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Another link 
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

</div>
</table>
<?php
}
else
header("location:../index.php");
?>
</body>
</html> 