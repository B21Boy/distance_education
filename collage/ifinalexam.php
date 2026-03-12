
<?php
	include('../connection.php');
	$con= mysql_connect('localhost','root','');
if(mysql_select_db('cde')){
$query1=mysql_query("UPDATE payment_table SET unread='yes',status='no' where status=' ' and unread='no' and type='iexam'");
if($query1)
{
$x='<script type="text/javascript">alert("Succssfully Send !!!");
window.location=\'unreaddifexam.php\';</script>';
echo $x;	
}
else
{
$x='<script type="text/javascript">alert("not Send");
window.location=\'unreaddifexam.php\';</script>';
echo $x;	
}
}

?>