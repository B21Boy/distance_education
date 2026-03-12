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

<style>
/* Social links column styling for this page only */
#siderightindexadational12 .social-links {
	display:flex;
	flex-direction:column;
	gap:10px;
	padding:10px 18px;
}
#siderightindexadational12 .social-links a {
	text-decoration:none;
	color:#000;
	background:transparent;
}
/* Hide overlapping main menu items inside the social block on this page only */
#siderightindexadational a[href="index.php"],
#siderightindexadational a[href="about.php"] {
	display:none !important;
}
</style>

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

<p><strong>Distance Education</strong></p>
<p><strong>Service Fees</strong></p>
<p>All students in Bahir Dar University of the continuing and distance studies benefit from a reduced tuition rate—a rate set with the realities of the learners in mind. This is more affordable than comparable universities, and considerably less than the actual cost incurred in rendering the services.</p>
<table width="100%" border="1">
<tbody>
<tr>
<td rowspan="2" width="6%">&nbsp;<p></p>
<p>No.</p></td>
<td rowspan="2" width="35%">&nbsp;<p></p>
<p>Type of service</p></td>
<td rowspan="2" width="23%">&nbsp;<p></p>
<p>Unit</p></td>
<td colspan="2" width="34%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amount of payment</td>
</tr>
<tr>
<td width="15%">Main campus</td>
<td width="18%">Branches</td>
</tr>
<tr>
<td width="6%">1</td>
<td width="35%">Application</td>
<td width="23%">Once only</td>
<td width="15%">50.00</td>
<td width="18%">50.00</td>
</tr>
<tr>
<td width="6%">2</td>
<td width="35%">Registration</td>
<td width="23%">Per semester</td>
<td width="15%">70.00</td>
<td width="18%">70.00</td>
</tr>

</tbody>
</table>
<p>&nbsp;</p>


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
 		<div class="social-links">
 			<a href="https://www.facebook.com/">Facebook</a>
 			<a href="https://www.twitter.com/">Twitter</a>
 			<a href="https://www.youtube.com/">Youtube</a>
 			<a href="https://plus.google.com/">Google++</a>
 		</div>
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