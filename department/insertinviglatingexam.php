<?php
include '../connection.php';
include("deptheadpage.php");
$id=$_POST['uid'];
$id1=$_POST['cid'];
$name=$_POST['in'];
$rk=$_POST['rk'];
$cr=$_POST['cr'];
$cpe=$_POST['icc'];
$noep=$_POST['ns'];
$st='no';
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}

$sql="INSERT INTO payment_table(UID,c_code,Instructors_Name,Rank,Course_Code,CrHr,No_of_Sections,unread,type) VALUES('$id','$id1','$name','$rk','$cpe','$cr','$noep','$st','iexam')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Sended!");
window.location=\'deptheadpage.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Your Information Is Successfully Sended !!!");
window.location=\'deptheadpage.php\';</script>';
echo $x;
}
mysql_close($con);
?>