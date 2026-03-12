<?php
include '../connection.php';
include("deptheadpage.php");
$id=$_POST['uid'];
$id1=$_POST['cid'];
$name=$_POST['nm'];
$rk=$_POST['rk'];
$cr=$_POST['cr'];
$cs=$_POST['cs'];

$dept=$_POST['dept'];
$year=$_POST['year'];
$no=$_POST['nem'];
$st='no';
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}

$sql="INSERT INTO payment_table(UID,c_code,Instructors_Name,Rank,Course_Code,CrHr,Department,Year,No_of_Assignment_Marked,unread,type) VALUES('$id','$id1','$name','$rk','$cs','$cr','$dept','$year','$no','$st','massignment')";
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