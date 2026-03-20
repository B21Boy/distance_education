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
<style type="text/css">
.main-row {
display: flex !important;
flex-direction: row !important;
gap: 20px !important;
align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
.ed{
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
margin-bottom: 4px;
}
#button1{
text-align:center;
font-family:Arial, Helvetica, sans-serif;
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
background-color:#508abb;
color: white;
height: 34px;
width: 100px;
}

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
  
    mysql_connect("localhost","root","");
						mysql_select_db("cde");
						$id=$_SESSION['suid'];
?>
<fieldset style="margin-left: -12px;"><legend> Select Department To Post Entrance Result</legend>
<form action="addcourseresult.php" method="post">   
                 <table>
                    <tr>
					<td>Select Department:</td>
                  <td>
					<select name="dpt"  class="ed"  style="height:30px; width:180px;" required>
                        <option value="">--select department--</option>
                        <?php
						
					$d_program = mysql_query("SELECT * FROM department");
			
					while($getDprog = mysql_fetch_array($d_program)){
						$name = $getDprog['DName'];
				 ?>
					<option value="<?php echo $name;  ?>"><?php echo $name; ?></option>
				<?php } ?>
                    </select>
                    </td>
                    <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td rowspan="3">
					<input type="submit" value="Search"  name="search" style="font-size: 25;background-color: #003366;color: white"/></td>
                    </tr>
 						</table>
                 </form>

</fieldset>
</div></div>
	 <div id="sidebar">
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#e70f0a>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
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
