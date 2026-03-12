<?php
include '../connection.php';

$infor=$_POST['infor'];
$pbay=$_POST['pb'];
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO module_schedule VALUES(' ','$infor','$pbay')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Posted!");
window.location=\'preparemoduleschedule.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Succssfully Posted!!!");
window.location=\'preparemoduleschedule.php\';</script>';
echo $x;
}
mysql_close($con);
?>

