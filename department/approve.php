<?php
session_start();
    $cc=$_SESSION['scode'];
    $d=$_SESSION['sdepartment'];
     $y=$_SESSION['syear'];
      $id=$_SESSION['siid'];
       $s=$_SESSION['ssection'];
$conn=mysql_connect("localhost","root","") or die(mysql_error());
	$sdb=mysql_select_db("cde",$conn) or die(mysql_error()); 
$query3=mysql_query("select * from course_result where status='posted' and reject=' ' and Department='$d' and uid='$id' and section='$s' and year='$y' and C_Code='$cc'");

if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("update course_result set status='approved',status2='pending' where status='posted' and reject=' ' and Department='$d' and uid='$id' and section='$s' and year='$y' and C_Code='$cc'");
$x='<script type="text/javascript">alert("Succssfully Approved!!!");
window.location=\'allrequest.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Already approved");
window.location=\'allrequest.php\';</script>';
echo $x;	
}
?>