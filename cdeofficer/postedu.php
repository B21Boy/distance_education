<?php
include '../connection.php';
$title=$_POST['title'];
$typ=$_POST['typ'];
$infor=$_POST['infor'];
$date=$_POST['date'];
$exdate=$_POST['edate'];
$pb=$_POST['pb'];
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO postss (Title,types,dates,Ex_date,info,posted_by)VALUES('$title','$typ','$date','$exdate','$infor','$pb')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Posted!");
window.location=\'updateposti.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Succssfully Posted!!!");
window.location=\'updateposti.php\';</script>';
echo $x;
}
mysql_close($con);
?>

