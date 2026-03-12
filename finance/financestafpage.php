<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Finance Staff page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
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
    require("menufstaf.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenufstaf.php");
?>
	
</td><td>
	<div id="contentindex5">

<center>Well Come To Finance Staff Page</center>

	 	
	 </div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	<?php
	$sfn = isset($_SESSION['sfn']) ? htmlspecialchars($_SESSION['sfn']) : '';
	$sln = isset($_SESSION['sln']) ? htmlspecialchars($_SESSION['sln']) : '';
	$sphoto = isset($_SESSION['sphoto']) && !empty($_SESSION['sphoto']) ? htmlspecialchars($_SESSION['sphoto']) : '../userphoto/default.jpg';
	echo "<b><br><span style='color:blue'>Welcome:</span> <span style='color:#f9160b'>($sfn&nbsp;&nbsp;&nbsp;$sln)</span></b><br>";
	echo "<b><img src='".$sphoto."' width='180' height='160' alt='Profile photo'></b>";
	?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="#.html">Change password</a></li>
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
	</table>
	</div>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>