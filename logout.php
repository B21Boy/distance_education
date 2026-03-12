
	   <?php
	   session_start();
	    unset($_SESSION['sfn']);
		unset($_SESSION['sln']);
		unset($_SESSION['sun']);
		unset($_SESSION['spw']);
		unset($_SESSION['srole']);
		if(!isset($_SESSION['sun'])||!isset($_SESSION['spw'])||!isset($_SESSION['sfn'])||!isset($_SESSION['sln'])||!isset($_SESSION['srole']))
			header("location:../index.php");
		?>
<?php
$time = time();
$actual = date('d M Y @ H:i:s', $time);
include 'connection.php';	 
mysql_query("UPDATE logfile SET end = '$actual' WHERE end = ''") or die(mysql_error());
header('location:index.php');
?>
