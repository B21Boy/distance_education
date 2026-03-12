
<?php
	include('../connection.php');
	session_start();
	$con= mysql_connect('localhost','root','');
if($_GET['id']){
$type=$_GET['id'];
$query11=mysql_query("select * from payment_table  where type='$type' and unread='yes' and status='no' and payment=' '");
 $row=mysql_fetch_array($query11);
 $t=$row['Total_Payment'];
 if($t=='0')
 {
 			$x='<script type="text/javascript">alert("First Calculate Total Payment!!!");
			window.location=\'cdeofficerpage.php\';</script>';
			echo $x;	
 }
 else{

$query1=mysql_query("UPDATE payment_table SET unread='yes',status='yes',payment='check' where type='$type' and unread='yes' and status='no' and payment=' '")or die(mysql_error());
	
			if(!$query1)
			{
			die("<script>alert('Error! not Updated!');
			window.location=\'cdeofficerpage.php\';</script>" . mysql_error());
			}
			else
			{
			$x='<script type="text/javascript">alert("Your Information Is Successfully Send !!!");
			window.location=\'cdeofficerpage.php\';</script>';
			echo $x;	
			}
          	
 }   
}
?>