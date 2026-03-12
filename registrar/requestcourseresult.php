<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Registrar Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menuro.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenuro.php");
?>
	
</td><td>
	<div id="contentindex5">
<?php
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
?>	

		<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
?>
<?php

$query = "select * from course_result where status='approved' and reject=' '";
	$pager = new PS_Pagination($conn, $query, 5, 1);
	$rs = $pager->paginate();

$result = mysql_query($query);
$count2=mysql_num_rows($result);
if($count2>'0')
{
	?>
		<table width="100%">
<td  width="100px" align="center"><a href="viewgrade.php"  style="color: #ffffff;font-size: 30px;text-decoration: none;"></a></td>
<td></td><td></td>
<td  bgcolor="#003366" width="120px" align="center"><a href="approve.php"  style="color: #ffffff;font-size: 20px;text-decoration: none;">Approve All</a></td></table>
<?php
if (!$result) 
{
	$message = 'ERROR:' . mysql_error();
	return $message;
}
else
{
	$i = 0;
	echo '<form action=" " method=post><table cellpadding="1" cellspacing="1" id="resultTable"><tr>';	
	while ($i < mysql_num_fields($result))
	{
		$meta = mysql_fetch_field($result, $i);
		if($meta->name=='status')
		break;
		echo '<th>' . $meta->name . '</th>';
		$i = $i + 1;
	}
	echo '</tr>';
	
	$i = 1;
	while ($row = mysql_fetch_row($result)) 
	{	
		echo '<tr>';
		$count = count($row);
		$y = 1;
		while ($y < $count)
		{
			$c_row = current($row);
			if($c_row=='approved')
			break;
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
	if($row1 = mysql_fetch_array($rs))
		echo '</tr>';
		$i = $i + 1;
	}
	echo '</table></form>';
	
}
						
?>							 
	<?php
		echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
				 
}
else
echo" No new request";
                 ?>
                                        <!-- /block -->
</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#e70f0a>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Another link 
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
include("../footer.php");
?>
</td></tr>

</div>
</table>

<?php
}
else
header("location:../index.php");
?>
</body>
</html>