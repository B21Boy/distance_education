<?php
include '../connection.php';
session_start();
 $n=$_POST['faname'];
$e=$_POST['em'];
$content=$_POST['feedback'];

$con= mysql_connect('localhost','root','');
if(!$con)
{
die('could not be connect :' .mysql_error());
}

$sql="INSERT INTO feed_back(name,email,role,Comment,date) VALUES('$n','$e','student','$content',Now())";
$result=mysql_query($sql,$con);
if(!$result)
{
die("<script>alert('Error! your feedback is not sended!');
window.location=\'feedback.php\';</script>" . mysql_error());
}
else

$x='<script type="text/javascript">alert("Your Information Is Successfully sended !!!");
window.location=\'feedback.php\';</script>';
echo $x;
mysql_close($con);
?>