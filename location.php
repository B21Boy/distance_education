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


			<div class="portfolio-area" style=" width:820px;">	
				<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?q=Bahir Dar &amp;z=14&amp;output=embed&amp;hl=en-GB&amp;t=h;output=embed"></iframe><br />
				<small><a href="http://maps.google.com/?q=Bahir Dar &amp;z=14&amp;hl=en-GB&amp;t=h" style="color:#0000FF;text-align:left">View Larger Map</a></small>
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