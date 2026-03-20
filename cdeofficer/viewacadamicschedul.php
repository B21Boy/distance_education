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
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
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
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
	<div id="contentindex5">
<?php	
$con=mysql_connect("localhost","root","");	
$result = mysql_query("SELECT * FROM acadamic_calender WHERE semister='Semister one'");
$result1 = mysql_query("SELECT * FROM acadamic_calender WHERE semister='Semister two'");
echo "<table border='1' style='width:590px;' align='center'><font color=white>
<tr>
<th bgcolor='#408c70' colspan='3'><font color='white' size='5'>Semister One</th></tr>
<tr>
<th bgcolor='#336699'><font color='white' size='5'>No</th>
<th bgcolor='#336699'><font color=white size='5'>Dates</th>
<th bgcolor='#336699'><font color=white size='5'>Activities</th>
</tr>";
echo'</font>';
while($row = mysql_fetch_array($result))
  {
  print ("<tr>");
  print ("<td><font size='2'>" . $row['no'] . "</td>");
 print ("<td><font size='2'>" . $row['dates'] . "</td>");
 print ("<td><font size='2'>" . $row['activities'] . "</td>");
  
print ("</tr>");
  }
echo"<tr>
<th bgcolor='#408c70' colspan='3'><font color='white' size='5'>Semister Two</th></tr>";
while($row1 = mysql_fetch_array($result1))
  {
  print ("<tr>");
  print ("<td><font size='2'>" . $row1['no'] . "</td>");
 print ("<td><font size='2'>" . $row1['dates'] . "</td>");
 print ("<td><font size='2'>" . $row1['activities'] . "</td>");
  
print ("</tr>");
  }
print( "</table>");

mysql_close($con);
?>

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
