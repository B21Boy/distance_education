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
<strong><i>The colleges in Bahir Dar University are: </i><br></strong>
<ol type="1">
<li><h4>Agriculture and Natural resource</h4></li>
<ul type="disc">
<li>Rular Development</li>
<li>Plant Science</li>
<li>Animal Science</li>
<li>Natural Res.Management</li>
<li>Horticulture</li>
</ul>

<li><h4>Natural and Computational Science</h4></li>
<ul type="square">
<li>Chemistry</li>
<li>Physics</li>
<li>Mathematics</li>
<li>Biology</li>
<li>Sport Science</li>
<li>Statistcs</li>
</ul>

<li> <h4>Business and Economics</h4></li>
<ol type="i">
<li>Economics</li>
<li>Accounting</li>
<li>Management</li>
</ol>

<li><h4>Health Science</h4></li>
<ol type="1">
<li>Nursing</li>
<li>Public health science</li>
<li>Midwifery</li>
<li>NIMEI</li>
</ol>

<li><h4>Social Science and Humanities</h4></li>
<ol type="a">
<li>English</li>
<li>Amharic</li>
<li>History</li>
<li>Geography</li>
<li>Psycology</li>
<li>Sociology</li>
</ol>
</ol>
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