
<?php
	include('../connection.php');
	session_start();
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
$dept=$_SESSION['dd'];
$sec=$_SESSION['ss'];
$year=$_SESSION['yy'];

$query3=mysql_query("select * from grade where status='approve' and checking='pending' and department='$dept' and year='$year' and section='$sec'");
if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("UPDATE grade SET status='approved' where department='$dept' and year='$year' and section='$sec'");
$x='<script type="text/javascript">alert("Succssfully Approved and Posted to Student!!!");
window.location=\'allrequestgr.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Already approved");
window.location=\'allrequestgr.php\';</script>';
echo $x;	
}
}

?>