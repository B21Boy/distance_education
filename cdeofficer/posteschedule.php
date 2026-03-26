<?php
include '../connection.php';

$infor=mysql_real_escape_string($_POST['infor']);
$pbay=mysql_real_escape_string($_POST['pb']);
$sql="INSERT INTO module_schedule VALUES(' ','$infor','$pbay')";
$result=mysql_query($sql);
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
?>

