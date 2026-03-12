<?php
session_start();
if(isset($_POST['up']))
{
	$cc=$_SESSION['scode'];
    $d=$_SESSION['sdepartment'];
     $y=$_SESSION['syear'];
      $id=$_SESSION['siid'];
       $s=$_SESSION['ssection'];
       
	$up=$_POST['message'];
	$idu=$_POST['id'];
$conn=mysql_connect("localhost","root","") or die(mysql_error());
	$sdb=mysql_select_db("cde",$conn) or die(mysql_error()); 

$query1=mysql_query("update course_result set reject='$up',status='not' where  status='posted' and reject=' ' and Department='$d' and uid='$id' and section='$s' and year='$y' and C_Code='$cc'");
if($query1)
{
$x='<script type="text/javascript">alert("Succssfully Send!!!");
window.location=\'approvecourseresult.php\';</script>';
echo $x;	
}
else{
$x='<script type="text/javascript">alert("Not Send!!!");
window.location=\'approvecourseresult.php\';</script>';
echo $x;	
}
	
}

?>