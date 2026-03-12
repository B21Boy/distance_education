<?php
include '../connection.php';
include("registrarpage.php");
$semister=$_POST['semister'];
$date=$_POST['date'];
$activ=$_POST['activ'];
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}

$sql="INSERT INTO acadamic_calender VALUES('','$semister','$date','$activ')";
$result=mysql_query($sql,$con);
if(!$result)
{
die("<script>alert('Error! not registerd!');
window.location=\'acadamic_calender.php\';</script>" . mysql_error());
}
else
{
$x='<script type="text/javascript">alert("Your Information Is Successfully Registerd !!!");
window.location=\'acadamic_calender.php\';</script>';
echo $x;
}
mysql_close($con);
?>