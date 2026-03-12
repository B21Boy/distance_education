<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Administrator page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
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
    require("menu.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenu.php");
?>
	
</td><td>
	<div id="contentindex5">

<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	// Use centralized mysqli connection
	include('../connection.php'); // provides $conn (mysqli)
	if (!($conn instanceof mysqli)) {
		die("Database connection failed or not available.");
	}
?>                                         
<form method="post" action="" name="form1" id="form1">   
<p style="font-size:18px; margin-left:100px;">Search log user  <input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" id="textboxid" placeholder="username/usertype"/> 
				<input type="submit"  id="btn btn-primary" name="submit" style="height: 30px;width: 100px;background-color: #2773d8;" value="Filter"></p> 
</form>
<?php 
if (isset($_POST['submit']) and isset($_POST['search_file'])) {
	$search_file = $_POST['search_file'];
	
	$sql = "SELECT * FROM logfile where logid like '%$search_file%' or role like '%$search_file%'  Order by start_time desc";
	$try = mysqli_query($conn, $sql);


if (mysqli_num_rows($try) >= 1) {
	$pager = new PS_Pagination($conn, $sql, 4, 1);
	$rs = $pager->paginate();
		
	 ?>
<form name="frmUser" method="post" action="" id="frm1">
<table  width="600" cellpadding="1"  id="resultTable">
<tr >
<th colspan=7 align="center" style="background-color: #767889;color: blue"  ><font style="margin-left: 200px;font-size: 20px"> Log users in the site</font></th></tr>
<tr>
<th>UserName</th>
<th>UserType</th>
<th>Login time</th>
<th>activity type</th>
<th>activity performed</th>
<th>ip address</th>
<th>Logout time</th>

</tr>
<?php
$i=0;
while($myrow = mysqli_fetch_array($rs)) {
echo "<tr  style=height: 400px;>";
echo "<td>" . $myrow[1]. "</td>";
echo "<td>" . $myrow[2]. "</td>";
echo "<td>" . $myrow[4]. "</td>";
echo "<td>" . $myrow[5]. "</td>";
echo "<td>" . $myrow[6]. "</td>";
echo "<td>" . $myrow[8]. "</td>";
echo "<td>" . $myrow[9]. "</td>";
echo "</tr>";

$i++;
}
?>
</table>
</form>
<?php
echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
}
else{
	
echo "no result found!!";

 }
 
 }
 else
 {
	$sql = "SELECT * FROM logfile ORDER BY logid desc ";
	$pager = new PS_Pagination($conn, $sql, 4, 1);
	$rs = $pager->paginate();
?>
<form name="frmUser" method="post" action="" id="frm1">
<table  width="600px" cellpadding="1" id="resultTable">
<tr>
<th colspan=7 align="center" style="background-color: #767889;color: blue"  ><font style="margin-left: 200px;font-size: 20px"> Log users in the site</font></th></tr>
<tr>
<th>UserName</th>
<th>UserType</th>
<th>Login time</th>
<th>activity type</th>
<th>activity performed</th>
<th>ip address</th>
<th>Logout time</th>

</tr>

<?php
$i=0;
while($myrow = mysqli_fetch_array($rs)) {
echo "<tr  style=height: 400px;>";
echo "<td>" . $myrow[1]. "</td>";
echo "<td>" . $myrow[2]. "</td>";
echo "<td>" . $myrow[4]. "</td>";
echo "<td>" . $myrow[5]. "</td>";
echo "<td>" . $myrow[6]. "</td>";
echo "<td>" . $myrow[8]. "</td>";
echo "<td>" . $myrow[9]. "</td>";
echo "</tr>";
$i++;
}
?>
</table>
</form>
<?php
	echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
	}
?>
</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#f9160b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="updateprofilephoto.php">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
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
