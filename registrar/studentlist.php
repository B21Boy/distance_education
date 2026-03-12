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
	

if(isset($_POST['search']))
{
	$dept1=$_POST['dpt'];
	$scy1=$_POST['scy'];
	$sem1=$_POST['sem'];

	
$_SESSION['dpt']=$dept1;
$_SESSION['yea']=$scy1;
$_SESSION['sem']=$sem1;

}
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
?>

<form action="" method="post">


<p style="font-size:18px; margin-left:5px;">Search Student
<input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" id="textboxid"placeholder="student ID" required/> 

<input type="submit"  id="btn btn-primary" name="submit" style="height: 30px;width: 100px;background-color: #4b80b4;" value="Filter"></p>

<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">  Total Number of record:<?php 
$count_item=mysql_query("select * from student where department='$dept' and year='$yea' and semister='$sem' and unread='yes'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?>	&nbsp;&nbsp;&nbsp;
						 <a href="updateall.php"  style="color: blue;font-size: 20px;text-decoration: none;">Update All</a></p>
									<?php
$query1 = mysql_query("select * from student where department='$dept' and year='$yea' and semister='$sem' and unread='yes'")
or die(mysql_error());
?>

<?php	
	if(isset($_POST['search_file']) and isset($_POST['submit']))
	{
		$id=$_POST['search_file'];			
	$sql = "select * from student where department='$dept' and year='$yea' and semister='$sem' and S_ID='$id'";		
		$pager = new PS_Pagination($conn, $sql, 10, 1);
	$rs = $pager->paginate();	
$sql11 = mysql_query("select * from student where department='$dept' and year='$yea' and semister='$sem' and S_ID='$id'");			
	$count_my_message = mysql_num_rows($sql11);
if ($count_my_message != '0'){
?>
<table border="1" id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
<tr>
<th>Student ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>College</th>
<th>Department</th>
<th>year</th>
<th>Semister</th>
<th>Action</th>
</tr>
<?php
while($row1 = mysql_fetch_array($rs)){	
$id=$row1["S_ID"]; 
									
?>

<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row1["S_ID"]; ?></td>
<td><?php echo $row1["FName"]; ?></td>
<td><?php echo $row1["LName"]; ?></td>
<td><?php echo $row1["Sex"]; ?></td>
<td><?php echo $row1["College"]; ?></td>
<td><?php echo $row1["Department"]; ?></td>
<td><?php echo $row1["year"]; ?></td> 
<td><?php echo $row1["semister"]; ?></td>  
<td><?php echo '<a  href="updateallstudid.php?id='.$row1["S_ID"].'">Update</a>' ?></td> 
</div>		
								<?php }
								?>		
				</tr>
				</table>
								<?php
								echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
								}else{ ?>
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php }
								} 
else{
		$sql = "select * from student where department='$dept' and year='$yea' and semister='$sem' and unread='yes'";		
		$pager = new PS_Pagination($conn, $sql, 10, 1);
	$rs = $pager->paginate();					
	$count_my_message = mysql_num_rows($query1);
if ($count_my_message != '0'){
?>
<table border="1" id="resultTable" width="100%" cellspacing="0" style="margin-left: -20px">
<tr>
<th>Student ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>College</th>
<th>Department</th>
<th>year</th>
<th>Semister</th>
<th>Action</th>
</tr>
<?php
while($row1 = mysql_fetch_array($rs)){	
$id=$row1["S_ID"]; 
									
?>

<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row1["S_ID"]; ?></td>
<td><?php echo $row1["FName"]; ?></td>
<td><?php echo $row1["LName"]; ?></td>
<td><?php echo $row1["Sex"]; ?></td>
<td><?php echo $row1["College"]; ?></td>
<td><?php echo $row1["Department"]; ?></td>
<td><?php echo $row1["year"]; ?></td> 
<td><?php echo $row1["semister"]; ?></td>  
<td><?php echo '<a  href="updateselectedstudid.php?id='.$row1["S_ID"].'">Clear</a>' ?></td> 
</div>		
								<?php }
								?>		
				</tr>
				</table>
								<?php
								echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
								}else{ ?>
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php }
}
								?>
									
                        <!-- /block -->
                </form>	

 

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

<?php
}
else
header("location:../index.php");
?>
</body>
</html>