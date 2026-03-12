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
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php } ?>
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