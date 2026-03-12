
<?php
	include('../connection.php');
	session_start();
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
$idd=$_SESSION['suid'];
$query3=mysql_query("select * from course_result where status='not' and uid='$idd'");
if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("UPDATE course_result SET status='posted',reject=' ' where status='not' and uid='$idd'");
$x='<script type="text/javascript">alert("Succssfully Posted!!!");
window.location=\'courseresultrequest.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Already Posted");
window.location=\'courseresultrequest.php\';</script>';
echo $x;	
}
}

?>