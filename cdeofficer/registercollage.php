<?php
include '../connection.php';
//include("cdeofficerpage.php");
$id=$_POST['cc'];
$name=$_POST['cn'];
$no=$_POST['loc'];

$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO collage VALUES('$id','$name','$no')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not registerd!");
window.location=\'managecollage.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Successfully Registerd !!!");
window.location=\'managecollage.php\';</script>';
echo $x;
}
mysql_close($con);
?>