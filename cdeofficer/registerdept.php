<?php
include '../connection.php';
//include("cdeofficerpage.php");
$id=mysql_real_escape_string($_POST['dc']);
$name=mysql_real_escape_string($_POST['dn']);
$no=mysql_real_escape_string($_POST['loc']);
$an=mysql_real_escape_string($_POST['cc']);
$sql="INSERT INTO department VALUES('$id','$name','$no','$an')";
$result=mysql_query($sql);
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
?>
