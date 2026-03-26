<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
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
	$sql1=mysql_query("SELECT * from postss where status='register' ORDER BY dates ASC") or die(mysql_error());	
	$ro=mysql_num_rows($sql1);
	
		$sql="SELECT * from postss where status='register' ORDER BY dates DESC";
	$pager = new PS_Pagination($conn,$sql,1,10);
	$rs = $pager->paginate();
	if($ro!='0')
	{
	while($row=mysql_fetch_array($rs))
	{
            echo"<p align='right'><b>Date:</b>"."<u>".$row['dates']."</u>"."</p>";
            echo"<font face='monotype corsiva' size='7' color='#347098'><center>"."<u>".$row['Title']."</u>"."</center>"."</p>";
             
           	
			echo"<font face='monotype corsiva' size='5' color='#0c395f'><center>".$row['types']."</center>"."</p>"."</font>";
			echo "<font  size='3' color='#00000b'>".$row['info'];
           echo"<font size='4' color='#1046a0'><center>".$row['posted_by']."</center>"."</p>";
echo '<div align="right"><a style=font-size:30px rel="facebox" href="updatepostreg.php?id='.$row['no'].'">Update Registration Date</a></div>';	

	}
	}
	else
	{
		echo "There No Post Notice!!!";
		?>
		<a rel="facebox" href="post.php" style="margin-left: 400px">Post Registration Date</a>
	<?php	
	}
echo '<div style="text-align:center;font-size:25px;color:red;bgcolor:blue">'.$pager->renderFullNav().'</div>';
?>
</fieldset>
</div></div>
	 <div id="sidebar">
<?php
    require("officer_sidebar.php");
?>
	 </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>
<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
