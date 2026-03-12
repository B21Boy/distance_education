<?php
include '../connection.php';
$no=$_POST['no'];
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
$sql="update postss set dates='$date',Ex_date='$exdate',start_date='$sdate',end_date='$edate',info='$infor' where no='$no'";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not updated!");
window.location=\'updatepost.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Succssfully updated!!!");
window.location=\'updatepost.php\';</script>';
echo $x;
}
mysql_close($con);
?>

