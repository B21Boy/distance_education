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

<h1>Scope Of The Project<br></h1>
				-Online application service to admit new and senior students.<br>
				-Online academic services like:<br>
			  - Resource downloading <br>   
				-Online communication<br>  
				-Advertisement<br>
				-Resource uploading <br>
				-View grade<br>
<h1> Purpose/Significance<br></h1>
	-Since users can access the system everywhere they  can get different services at the same time and hence the system saves time.<br>
	-The newly developed system is web based and gives online services. Since every activity is done by computer.<br>
	-It minimizes the workload of both students and workers. Because students can be admitted wherever they are and can communicate with their teacher online. Since they can download modules, they save the time to copy it. <br>-The system can perform every activity that can be done by the workers.<br>
	-Since every information and document is stored on the database, there will not be any redundancy and losing of data.<br>
	-The system allows searching and updating any selective information easily if it is already on the database. It does not take time to retrieve data as the existing system.<br>
	-It also minimizes material wastage that can be lost for printing and copying bulk of modules. And since one person can perform different activities using the system, it can also minimize man power.<br>
	-The system is easy to use and its interface is user friendly.<br><br>
							
				
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