<?php
include '../connection.php';
include("deptheadpage.php");
$id=$_POST['uid'];
$id1=$_POST['cid'];
$name=$_POST['tn'];
$rk=$_POST['rk'];
$cs=$_POST['cs'];
$cr=$_POST['cr'];
$dept=$_POST['dept'];
$year=$_POST['year'];
$sec=$_POST['sec'];
$nhr=$_POST['nhr'];
$st='no';
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}

$sql="INSERT INTO payment_table(UID,c_code,Instructors_Name,Rank,Course_Code,CrHr,Department,Year,Section,No_of_hours_she_he_gave_tutorial,unread,type) VALUES('$id','$id1','$name','$rk','$cs','$cr','$dept','$year','$sec','$nhr','$st','tutorial')";
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