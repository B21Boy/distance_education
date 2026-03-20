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
Instructor page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
    require("menuins.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenuins.php");
?>
	
</div><div id="content">
	<div id="contentindex5">

				<div class="clearfix"> 
				
<p>List of assigned courses  </p>
					
					<table cellpadding="1" cellspacing="1" id="resultTable" style="margin-left: -20px">
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
								
								<th> Upload asignmnt </th>
							</tr>
						</thead>
						<tbody>
						<?php
							include('../connection.php');
							$uid=$_SESSION['suid'];
							$result = mysql_query("SELECT * FROM assign_instructor where uid='$uid'");
							while($row = mysql_fetch_array($result))
								{
									$cc=$row['corse_code'];
									$result1 = mysql_query("SELECT * FROM course where course_code='$cc'");
							         $row1 = mysql_fetch_array($result1);
						
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['corse_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Iname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['section'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['semister'].'</td>';
							
									echo '<td><div align="right">'.$row1['chour'].'</div></td>';
									echo '<td><div align="right">'.$row1['ayear'].'</div></td>';
		        echo '<td><div align="center"><a rel="facebox" href="uploadassignment.php?id='.$row['no'].'">Upload</a></div></td>';
									echo '</tr>';
								}
							?> 
						</tbody>
					</table>
					
					
				</div>
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
