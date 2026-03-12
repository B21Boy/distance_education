
<?php
	include('../connection.php');
	session_start();
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
	$dp=$_SESSION['ddd'];
$query3=mysql_query("select * from student where year='1st' and semister='I' and unread=' ' and Department='$dp'");
if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("UPDATE student SET unread='no' where unread=' ' and year='1st' and semister='I' and Department='$dp'");
$x='<script type="text/javascript">alert("Succssfully Send !!!");
window.location=\'sendstudentlist.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Alredy Send");
window.location=\'sendstudentlist.php\';</script>';
echo $x;	
}
}

?>