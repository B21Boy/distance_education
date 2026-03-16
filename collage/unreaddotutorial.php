<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
collage dean page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body class="light-theme">
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
    require("menufstaf.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenufstaf.php");
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
$id=$_SESSION['suid'];
$s=mysql_query("select*from user where UID='$id'");
$rr=mysql_fetch_array($s);
$cc=$rr['c_code'];

?>
<form action="" method="post">									
<?php
$query = mysql_query("select * from payment_table where unread='no' and status=' ' and type='tutorial' and c_code='$cc'")
or die(mysql_error());
$coun = mysql_num_rows($query);
?>		
										
<a href="unreaddotutorial.php"><i class="icon-check"></i><font size="4px"> Unseen Request[&nbsp;<?php echo $coun?>&nbsp;]</font></a>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										
<a href="messageddotutorial.php"><i class="icon-envelope-alt"></i><font size="4px">Seen Request</font></a>
										
									<font size="3px">
<?php
$sql = "select * from payment_table where unread='no' and status=' ' and type='tutorial' and c_code='$cc'";
	 
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn, $sql, 10, 1);
 	//The paginate() function returns a mysql result set for the current page
	$rs = $pager->paginate();									
$query1 = mysql_query("select * from payment_table where unread='no' and status=' ' and type='tutorial' and c_code='$cc'")
or die(mysql_error());
$count = mysql_num_rows($query1);	
if ($count != '0'){?>
<table border="1" id="resultTable" cellspacing="0" style="margin-left: -20px;">
<tr bgcolor="#CAE8EA">
<th rowspan="2">No</th>
<th rowspan="2">Sender<br>UID</th>
<th rowspan="2">Tutors<br>Name</th>
<th rowspan="2">Rank</th>
<th rowspan="2">Course<br>he/she<br>tutored</th>
<th rowspan="2">Cr<br>Hr</th>
<th colspan="3">Students Who have taken the course</th>
<th rowspan="2">No_of<br>hours<br>she/he<br>gave<br>tutorial</th>
<th rowspan="2">Action</th>
</tr>
<tr bgcolor="#CAE8EA">
<th>Department</th>
<th>Year</th>
<th>Section</th>	
	
</tr>
        <?php
while($row = mysql_fetch_array($rs)){	
$id=$row["no"]; 
						 
	?>
<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row["no"]; ?></td>
<td><?php echo $row["UID"]; ?></td>
<td><?php echo $row["Instructors_Name"]; ?></td>
<td><?php echo $row["Rank"]; ?></td>
<td><?php echo $row["Course_Code"]; ?></td>
<td><?php echo $row["CrHr"]; ?></td>
<td><?php echo $row["Department"]; ?></td>
<td><?php echo $row["Year"]; ?></td>
<td><?php echo $row["Section"]; ?></td>
<td><?php echo $row["No_of_hours_she_he_gave_tutorial"]; ?></td>										
											
	<?php }
	?>
	<td rowspan="<?php echo $count; ?>"><?php echo '<a  href="offeringtutorial.php">Send All To CDEO</a>';?></td>
	</div></tr></table>

	<?php
		echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
	}						
	else{ ?>
<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php } ?>
										
								</form>		
                               
                        <!-- /block -->
                   
 </div>
  </td>
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