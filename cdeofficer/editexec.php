<?php
include '../connection.php';
	$ccode =$_POST["cc"];
	$cname =$_POST["cn"];
	$dpt =$_POST["combo"];
	$scy =$_POST["combo1"];
	$sem =$_POST["sem"];
	$ch =$_POST["ch"];
	$ay =$_POST["ay"];

$update=mysql_query("Update course SET s_c_year='$scy',semister='$sem',other_department_takes='$dpt',status='yes',unread='no' where course_code='$ccode'");
if($update)
{
$x='<script type="text/javascript">alert("Successfully Uploded !!!");window.location=\'viewuploadmodule.php\';</script>';
echo $x;	
}
else
			{
			die("<script>alert('Error! not Uploded!');
			window.location=\'viewuploadmodule.php\';</script>" . mysql_error());
			}

	
?>
