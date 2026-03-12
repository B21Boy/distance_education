<?php
	include("../connection.php");
    $M_sender=$_POST['M_sender'];
    $M_Reciever=$_POST['M_Reciever'];
	$message=$_POST['message'];
	$date_sended=$_POST['date_sended'];
mysql_query("INSERT INTO message(M_sender ,M_Reciever,message,date_sended,status)VALUES('$M_sender','$M_Reciever','$message',NOW(),'no')");
	
	header("location: usernotification.php");