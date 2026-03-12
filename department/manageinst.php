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
				<div id="content" class="clearfix">

<?php 
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
echo '<a  href="viewassigndinst.php?id='.$dept.'" style="margin-left: 400px">View Assigned Instructor</a>';?>
				
					
					<table cellpadding="1" cellspacing="1" id="resultTable">
						<thead>
							<tr>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>name</th>
								<th  style="border-left: 1px solid #C1DAD7">chour</th> 
								<th>ayear</th>
								<th>department</th>
								<th>Assign Instructor</th>
								
							</tr>
						</thead>
						<tbody>
						<?php
							include('../connection.php');
							$result = mysql_query("SELECT * FROM course where department='$dcode'");
							while($row = mysql_fetch_array($result))
								{
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['course_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['chour'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['ayear'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['department'].'</td>';
echo '<td><div align="center"><a rel="facebox" href="assign_course_instructorS.php?id='.$row['course_code'].'">Assign</a></div></td>';
									echo '</tr>';
								}
							?> 
						</tbody>
					</table>
				</div>
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