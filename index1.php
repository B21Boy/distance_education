<?php
session_start();
include("connection.php");
?>
<html>
<head>
<title>
Home page
</title>	
<link rel="stylesheet" type="text/css" href="setting.css">
<script type="text/javascript" src="javascript\date_time.js"></script>

</head>
<body>
<div id="container">

<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="2">
<?php
    require("menu.php");
?>
</td></tr>
<tr><td>

<?php
		include("left.php");
	?>				
</td>
<td>
	<div id="contentindex5">
	<table bgcolor="#F5F5F5" width="650px" style="border:1px solid lightsteelblue; border-radius:5px; border-spacing: 12px;"><tr><th style="border:2px solid lightsteelblue;">
	<?php
	require("animationimg.php");
	?>
     </th></tr></table>

<table  bgcolor="#F0F8FF" width="auto" height="240px" style="border:1px solid lightsteelblue;border-radius:5px; border-spacing: 6px;">
<tr><td bgcolor="white" style="border:1px solid lightsteelblue;">
<div id="bodydivision1">
<center>Well Come To Distance Education Managment system</center></div>
<div id="bodydivision">
Welcome to the Continuing and Distance Education Coordinating Directorate of Bahir Dar University. The Directorate is running a range of first degree programs in collaboration with hosting colleges and departments of the University on week-end and summer modalities. 
 We will continuously update our website with new program information, so be sure to check back often.

<br>

<br>

</div>
</td></tr></table>	
	 </div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
	 User Login
	 </div>
	 
	 <?php 
	require("login1.php");
     ?>
	 
	 
	 </div>
	<div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Social link
	 </div>
	 <table>
	 <tr><td><div id="facebook"></div></td><td>
	<p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
	<tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
	<tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
	<tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>

	 </div>
	  </td>
	  
	 </tr>
	 <tr><td>
<?php
include("footer.php");
?>
</td></tr>

</div>
</table>
</body>
</html>