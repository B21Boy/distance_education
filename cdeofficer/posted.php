<?php
include '../connection.php';
$title=$_POST['title'];
$taype=$_POST['typ'];
$date=$_POST['date'];
$exdate=$_POST['exd'];
$sdate=$_POST['sd'];
$edate=$_POST['ed'];
$infor=$_POST['infor'];
$pbay=$_POST['pb'];
$st=$_POST['st'];
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO postss VALUES(' ','$title','$taype','$date','$exdate','$sdate','$edate','$infor','$pbay','$st')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Posted!");
window.location=\'updatepost.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Succssfully Posted!!!");
window.location=\'updatepost.php\';</script>';
echo $x;
}
mysql_close($con);
?>

