
<?php
	include('../connection.php');
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
$query3=mysql_query("select * from student where unread=' '");
if($row=mysql_fetch_assoc($query3))
{
$query1=mysql_query("UPDATE student SET unread='no' where unread=' '");
$x='<script type="text/javascript">alert("Succssfully Send !!!");
window.location=\'studentlist.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Alredy Send");
window.location=\'studentlist.php\';</script>';
echo $x;	
}
}

?>