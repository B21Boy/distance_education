<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
  <style>
  hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 3px solid #ca3d24;
    margin: 1em 0;
    padding: 0; 
}
fieldset{
    border: 2px solid #3cb353;
}
</style>
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
    require("menustud.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenustud.php");
?>
	
</td><td>
	<div id="contentindex5">
	<fieldset><legend>View Submited Assignment</legend>
				<div id="content" class="clearfix"> 
					<hr>
					<table cellpadding="1" cellspacing="1" id="resultTable">
						<thead>
							<tr>
							<th  style="border-left: 1px solid #C1DAD7">Student<br>ID </th>
							    <th  style="border-left: 1px solid #C1DAD7">Assignment<br>Number </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>Student<br>class<br>year</th>
								<th>semister</th>
								<th>date</th>
								<th>file name </th>
								
							</tr>
						</thead>
						<tbody>
						<?php
$uid=$_SESSION['suid'];
$dpt=$_SESSION['sdpt'];
$sem=$_SESSION['ssemister'];
$sec=$_SESSION['ssection'];
$yea=$_SESSION['syear'];							
include('../connection.php');
$result = mysql_query("SELECT * FROM assignment where department='$dpt' and Student_class_year='$yea' and semister='$sem'and status='stud' and U_ID='$uid'");
							while($row = mysql_fetch_array($result))
								{
						
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['U_ID'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['asno'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['ccode'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['semister'].'</td>';
									echo '<td><div align="right">'.$row['Submission_date'].'</div></td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['fileName'].'</td>';
									
									echo '</tr>';
								}
							?> 
						</tbody>
					</table>
				</div>
				</fieldset>
				</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#b51515>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
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