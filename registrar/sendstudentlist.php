<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Registrar Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<style>
a.two:link {color:#0b3ff2;text-decoration: none;}
a.two:visited {color:#0000ff;}
a.two:hover {font-size:100%;text-decoration: underline;color: #ed1c16}
</style>
</head>
<body>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menuro.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenuro.php");
?>
	
</td><td>
	<div id="contentindex5">
	
	<?php
		include('ps_pagination.php');
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
	if(isset($_POST['search'])){
		$dp=$_POST['dpt'];
		$ye=$_POST['scy'];
		$se=$_POST['sem'];
		if($ye=='1st' and $se=='I')
		{
			$_SESSION['ddd']=$dp;
	?>
<form action="" method="post">
<a class="two" href="sendall.php" >Send All Students To System Adminstraror Page In Order To Get Account</a><br><center>List Of Student</center><p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Total Number of record:<?php 
$count_item=mysql_query("select * from student where year='$ye' and semister='$se' and Department='$dp'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?></p>							
<?php					
	$sql = mysql_query("select * from student where year='$ye' and semister='$se' and Department='$dp' ORDER BY S_ID ASC");						
if ($count != '0'){
?>
<table border="1" id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
<tr>
<th>Student ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>Email</th>
<th>College</th>
<th>Department</th>
<th>Year</th>
<th>Semister</th>
</tr>
<?php
while($row1 = mysql_fetch_array($sql)){	
$id=$row1["S_ID"]; 									
?>
<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row1["S_ID"]; ?></td>
<td><?php echo $row1["FName"]; ?></td>
<td><?php echo $row1["LName"]; ?></td>
<td><?php echo $row1["Sex"]; ?></td>
<td><?php echo $row1["Email"]; ?></td>
<td><?php echo $row1["College"]; ?></td>
<td><?php echo $row1["Department"]; ?></td>
<td><?php echo $row1["year"]; ?></td>
<td><?php echo $row1["semister"]; ?></td>
</div>		
								<?php }	
								?>
								</tr>
								</table>		
								</form>	
								<?php
								
								}else{ ?>
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php 
								} 
}
else{
	?>
<form action="" method="post">
<center>List Of Student</center><p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Total Number of record:<?php 
$count_item=mysql_query("select * from student where year='$ye' and semister='$se' and Department='$dp'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?></p>							
<?php					
	$sql = mysql_query("select * from student where year='$ye' and semister='$se' and Department='$dp' ORDER BY S_ID ASC");						
if ($count != '0'){
?>
<table border="1" id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
<tr>
<th>Student ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>Email</th>
<th>College</th>
<th>Department</th>
<th>Year</th>
<th>Semister</th>
</tr>
<?php
while($row1 = mysql_fetch_array($sql)){	
$id=$row1["S_ID"]; 									
?>
<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row1["S_ID"]; ?></td>
<td><?php echo $row1["FName"]; ?></td>
<td><?php echo $row1["LName"]; ?></td>
<td><?php echo $row1["Sex"]; ?></td>
<td><?php echo $row1["Email"]; ?></td>
<td><?php echo $row1["College"]; ?></td>
<td><?php echo $row1["Department"]; ?></td> 
<td><?php echo $row1["year"]; ?></td>
<td><?php echo $row1["semister"]; ?></td>

</div>		
								<?php }	
								?>
								</tr>
								</table>		
								</form>	
								<?php
								}else{ ?>
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php 
								} 	
}								
}
?>
 </div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>	
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
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
</body>
</html>