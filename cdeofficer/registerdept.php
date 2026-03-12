<?php
include '../connection.php';
//include("cdeofficerpage.php");
$id=$_POST['dc'];
$name=$_POST['dn'];
$no=$_POST['loc'];
$an=$_POST['cc'];
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO department VALUES('$id','$name','$no','$an')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not registerd!");
window.location=\'managedept.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Successfully Registerd !!!");
window.location=\'managedept.php\';</script>';
echo $x;
}
mysql_close($con);
?>