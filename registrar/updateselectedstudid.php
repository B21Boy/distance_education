<?php
session_start();
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
$id=$_GET['id'];
$conn=mysql_connect("localhost","root","") or die(mysql_error());
	$sdb=mysql_select_db("cde",$conn) or die(mysql_error()); 
$query3=mysql_query("select * from student where department='$dept' and year='$yea' and semister='$sem' and S_ID='$id'");

if($row=mysql_fetch_assoc($query3))
{
	$y=$row['year'];
	$s=$row['semister'];
		
$query1=mysql_query("update student set unread='not' where  department='$dept' and year='$yea' and semister='$sem' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Cleared!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
		}	
?>