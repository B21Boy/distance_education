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
</td><td>
	<div id="contentindex5">
<div id="bodydivision">

<h1>Contact Us</h1>
<table border=0>
		<tr>
<td>Department Head Office</td></tr>
<tr>
<td>10,  Ground</td></tr>
<tr>
<td><strong>Tel:</strong> (+251)-011-9-54-10-18/15</td></tr>
<tr>
<td><strong>Fax:</strong> (+251)-011-290-79-44</td></tr>
<tr>
<td><strong>E-mail:</strong> <a href="a@gmail.com">Head.gmail.com</a></td></tr>
<tr>
<td>&nbsp;</td></tr>
<tr>
<td>Registrar </td></tr>
<tr>
<td>Ato xx yy</td></tr>
<tr>
<td>205, 2<sup>nd</sup> Floor, Father Block</td></tr>
<tr>
<td><strong>Tel:</strong> (+251)-011-6-90-10-18/15</td></tr>
<tr>
<td><strong>Fax:</strong> (+251)-011-290-79-44</td></tr>
<tr>
<td><strong>E-mail:</strong> <a href="a@gmail.com">registrar.gmail.com</a></td></tr>
<tr>
<td>&nbsp;</td></tr>
<tr>
<td>Instructors </td></tr>
<tr>
<td>Ato AA BB </td></tr>
<tr>
<td></td></tr>
<tr>
<td><strong>Tel:</strong> (+251)-011-6-54-10-10</td></tr>
<tr>
<td><strong>Fax:</strong> (+251)-011-275-79-10</td></tr>
<tr>
<td><p>E-mail: <a href="mailto:abebawaddis2015@gmail.com"><span style="font-family: arial, helvetica, sans-serif;"><strong><span style="font-size: 10pt;">DMU-Distance-Education-service@gmail.com</span></strong></span></a></p></td></tr>
<tr>
<td>&nbsp;</td></tr>

<tr><td></td></tr>
</table>

							
				
</div>


	 </div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
	User Login
	 </div>
	 
	 <?php 
	require("leftlogin.php");
     ?>
	 
	 
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
include("footer.php");
?>
</td></tr>

</div>
</table>
</body>
</html>