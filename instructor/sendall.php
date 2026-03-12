
<?php
	include('../connection.php');
	session_start();
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
$dept=$_SESSION['sdpt'];
$yea=$_SESSION['sscy'];
$sem=$_SESSION['ssem'];
$sec=$_SESSION['ssec'];
$co=$_SESSION['scc'];	
$dcc=$_SESSION['sddc'];
$query3=mysql_query("select * from course_result where status='post' and Department='$dept' and year='$yea' and semister='$sem' and section='$sec' and C_Code='$co'");
if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("UPDATE course_result SET status='posted',send_to='$dcc' where Department='$dept' and year='$yea' and semister='$sem' and section='$sec' and status='post' and C_Code='$co'");
$x='<script type="text/javascript">alert("Succssfully Sended to department!!!");
window.location=\'viewcourseresult.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Already Posted");
window.location=\'viewcourseresult.php\';</script>';
echo $x;	
}
}

?>