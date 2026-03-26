<?php
include '../connection.php';
//include("cdeofficerpage.php");
$id=mysql_real_escape_string($_POST['cc']);
$name=mysql_real_escape_string($_POST['cn']);
$no=mysql_real_escape_string($_POST['loc']);
$sql="INSERT INTO collage VALUES('$id','$name','$no')";
$result=mysql_query($sql);
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
?>
