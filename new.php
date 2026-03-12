
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
		<?php
		include('ps_pagination.php');
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
?>

	<fieldset><legend>Notice Bored</legend>
<?php

	$date=date('Y-m-d');
	$sql1=mysql_query("SELECT * from postss where Ex_date>='$date' ORDER BY dates ASC") or die(mysql_error());	
	$ro=mysql_num_rows($sql1);
	if($ro!='0')
	{
		
	$sql="SELECT * from postss where Ex_date>='$date' ORDER BY dates DESC";
	$pager = new PS_Pagination($conn,$sql,1,10);
	$rs = $pager->paginate();
	while($row=mysql_fetch_array($rs))
	{
	
            echo"<p align='right'><b>Date:</b>"."<u>".$row['dates']."</u>"."</p>";
            echo"<font face='monotype corsiva' size='7' color='#347098'><center>"."<u>".$row['Title']."</u>"."</center>"."</p>";
             
           	
			echo"<font face='monotype corsiva' size='5' color='#0c395f'><center>".$row['types']."</center>"."</p>"."</font>";
			echo "<font  size='3' color='#00000b'>".$row['info'];
           echo"<font size='4' color='#1046a0'><center>".$row['posted_by']."</center>"."</p>";
         		

	}
	}
	else
	{
		echo '<script type="text/javascript">alert("There No Post Notice!!!");</script>';
		
	}
	echo '<div style="text-align:center;font-size:25px;color:red;bgcolor:blue">'.$pager->renderFullNav().'</div>';
?>
</fieldset>
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