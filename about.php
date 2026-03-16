<?php
session_start();
ob_start();
include("connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
Home page
</title>	
<link rel="stylesheet" type="text/css" href="setting.css">
<script type="text/javascript" src="javascript\date_time.js"></script>

</head>
<body class="light-theme">
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
<h2>About Us</h2>
<h3>If you want further information about DMU distance education </h3>
<h4> we provide distance education in different field of studies </h4>
<h2><u>Motto of the distance education</u></h2>
<h4>1.To provide quality education</h4>
<h4>2.Undertaking a problem solving research work, which focuses on national 
need and benefiting the community with the outcome</h4>
<font color="black" face="monotype corsiva" size="5">DMU Continuing and distance Office  works for change!!</font><br>
<p>DMU Continuing and distance Office plays a great role 
in producing a well knowledgeable citizen
 for the development of our country.</p>
DMU CDE OFFICE!!!<br>
<font face="Times New Roman" color="#101f30" size="3">DMU CDE OFFICE &copy; 2010 E.C.</font>
</div>
 
	 </div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
User	Login
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