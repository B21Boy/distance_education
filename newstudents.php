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

<i><font color="blue"size="5px">Criteria's to attend DMU Distance Education learning system as a new student</font></i><br>
   <font style="strong"size="3px">1:The student can be admitted if and only if he/she complete grade 12 pass marks or 10+3(diploma).<br>
	2: For grade 12, the pass mark must be above based on the ministry of education.<br>
	3: To be accepted by natural science fields, the student must be natural science student.<br>
	4: For diploma students their major and minor courses must be related to the course they select to register.<br>
	5: Students must pay 30 birr for application to the finance office in its internal bank account.<br>
	6: Students must receive recite and give the recite to be admitted.<br>
	7:New student admitting must happens at the beginning of the first academic year<br></font>
	<font size="3px" color="blue"><h4><u>N.B </u>For registration ,students will pay 30 birr for the first registration weeks.If registration is passed,those students who come later
will pay a penality of 70 birr for the campus in its internal account and submit the reciet to the registrar for renew.</h4></font>

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
