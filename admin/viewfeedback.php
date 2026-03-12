<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Administrator page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css"/>
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
    require("menu.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenu.php");
?>
	
</td><td>
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
</div>
</table>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
