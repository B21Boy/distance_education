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

	
	<h4>How to Apply</h4>
<p style="text-transform: capitalize;">
self sponsored summer students are requested to apply in person at the main campus whereas government sponsored students are advised to communicate their employers in advance.
a student who is attending for his/her undergraduate degree program at the summer program of the University should have the following documents in his/her file.
Letter stating working experience
Certificate and transcript
University application form
Bank receipt for private students
Registration slip</p>
<h4>After the Application</h4>
<p style="text-transform: capitalize;">
Keep with you registration slip that you have been given during registration at least until you graduate
Private students keep either the original or the copy of the bank receipt with you at least until you graduate
</p>
<h4>New Student Orientation</h4>
<p style="text-transform: capitalize;">
the directorate will arrange a discussion forum at which all the responsible bodies of the university will meet new entrants to let them know the rules and regulations of the university
	
</p>


	 </div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
	Login Here
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