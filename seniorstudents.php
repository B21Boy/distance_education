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
				
				
<!--body-->
<i><font color="blue"size="5px">Criteria's to attend DMU Distance Education learning system as a senior student</font></i><br> 
  <font size="3px;">1: You  have to achieve the passing grade (point) and complete full payment of the  semester to be registered<br>
	2:Senior student registering must happens at the beginning of each academic semester<br>
	3: The grading system in the DE is the same as DMU regular students.<br>
	4: The payments for the summer students are complete at once.<br>
	5: The payment for weekend students is once in each semester.<br><br></font>
<!--body-->
				
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