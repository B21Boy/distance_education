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
<?php
    require("officer_sidebar.php");
?>
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
