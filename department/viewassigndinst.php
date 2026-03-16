
<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
Department head page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
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
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
	
	$dept=$_GET['id'];
	$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
?>
<br/>
<table cellpadding="1" cellspacing="1" id="resultTable" >
						<thead>
							<tr>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>Title </th>
								<th  style="border-left: 1px solid #C1DAD7">instructor<br>name</th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>section</th>
								<th>Student<br>class<br>year</th>
								<th>semister</th>
								<th>Credit<br>Hour</th>
								<th>Year</th>
								<th>Update</th>
							</tr>
						</thead>
						<tbody>
						<?php
							
							$result =mysql_query("SELECT * FROM course where department='$dcode'");
							while($row = mysql_fetch_array($result))
								{
									$cc=$row['course_code'];
									$result1 = mysql_query("SELECT * FROM assign_instructor where corse_code='$cc'");
							       while($row1 = mysql_fetch_array($result1))
						          {
							
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['corse_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['Iname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['section'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['semister'].'</td>';
							
									echo '<td><div align="right">'.$row['chour'].'</div></td>';
									echo '<td><div align="right">'.$row['ayear'].'</div></td>';
echo '<td><div align="center"><a rel="facebox" href="assign_course_instructorSu.php?id='.$row1['corse_code'].'">Update</a></div></td>';
									echo '</tr>';
								}
								}
				
							?> 
						</tbody>
					</table>
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