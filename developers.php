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
<div style="height:500px; width:500px;">
<section id="contact">
 <h3 class="slanted">Contact Me</h3>
      
	 <h4>Section&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A</h4>
	
	  <table width="430px" height="320px" border="4" cellspacing="8" cellpadding="8"  style="text-align:left;color:black;">
						<font align="center"><i><h4>GROUP 10 MEMBERS LIST</h4></i></font>
						<tr bgcolor="#80998e;">
							<td>ID Number</td>
							<td>Name</td>
							<td>Sex</td>
							<td>E-Mail</td>
							<td>Photo</td>
						</tr>
						<tr>
							<td allign="center">TER/4641/07</td>
							<td allign="center">Abebaw Addis</td>
							<td allign="center">M</td>
							<td>abebawaddis@gmail.com</td>
							<td><img src="jb2/abie.jpg" height="50" width="100%"></td>
						</tr>
						<tr>
							<td allign="center">TER/4656/07</td>
							<td allign="center">Dessie Techane</td>
						    <td allign="center">M</td>
						    <td>dessietechane@gmail.com</td>
							<td><img src="jb2/dess.jpg" height="50" width="100%"></td>
							
						</tr>
						<tr>
							<td allign="center">TER/4645/07</td>
							<td allign="center">Assefa Adamu</td>
							<td allign="center">M</td>
							<td>assefaadamu@gmail.com</td>
							<td><img src="jb2/asse.jpg" height="50" width="100%"></td>
							
						</tr>
						<tr>
							<td allign="center">TER/4657/07</td>
							<td allign="center">Emebiet Andualem</td>
							<td allign="center">F</td>
							<td>emebietandualem@gmail.com</td>
							<td><img src="jb2/emeb.jpg" height="50" width="100%"></td>
							
						</tr>
						<tr>
							<td allign="center">TER/1237/06</td>
							<td allign="center">Kassahun Tsegaw</td>
							<td allign="center">M</td>
							<td>kassahuntsegaw@gmail.com</td>
							<td><img src="jb2/kass.jpg" height="50" width="100%"></td>
							
						</tr>
					</table>
			</section>
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