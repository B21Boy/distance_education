<?php
session_start();
include('../connection.php');
$id=$_GET['id'];
    $user_id=$_SESSION['suid'];
    $sqll=mysql_query("select * from payment_table where no='$id'");
    $roww=mysql_fetch_array($sqll);
    $M_Reciever=$roww['Instructors_Name'];
	$message='Well come To finance and take payement for Inviglating Final worked time';
mysql_query("INSERT INTO message(M_sender ,M_Reciever,message,date_sended,status)VALUES('$user_id','$M_Reciever','$message',NOW(),'no')");
$query1=mysql_query("UPDATE payment_table SET payment='checked' where no='$id'");
if($query1)
{
			$x='<script type="text/javascript">alert("Successfully Paid !!!");
			window.location=\'unreaddifexam.php\';</script>';
			echo $x;		
}
else
{
			$x='<script type="text/javascript">alert("Not Paid !!!");
			window.location=\'unreaddifexam.php\';</script>';
			echo $x;	
	
}
?>