<?php
session_start();
include '../connection.php';
$uid=$_SESSION['suid'];
$cc=$_POST['ccode'];
$in=$_POST['in'];
$mname=$_POST['mn'];
$ch=$_POST['ch'];
$np=$_POST['np'];
$pp=$_POST['pp'];
$tp=$_POST['total'];
$sn=$_SESSION['sname'];
$un='yes';
$st='yes';
$pa='check';
$typ='module';
$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}
$sql="INSERT INTO payment_table(UID,Instructors_Name,Course_Code,CrHr,No_of_pages_prepared,Payment_per,Total_Payment,unread,status,payment,type) VALUES('$uid','$sn','$mname','$ch','$np','$pp','$tp','$un','$st','$pa','$typ')";
$result=mysql_query($sql,$con);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Sended!");
window.location=\'viewuploadmodule.php\';</script>';
echo $x;
}
else
{
	$update=mysql_query("Update course SET status='yes' where course_code='$cc'");
$x='<script type="text/javascript">alert("Your Information Is Successfully Sended !!!");
window.location=\'viewuploadmodule.php\';</script>';
echo $x;
}
mysql_close($con);
?>