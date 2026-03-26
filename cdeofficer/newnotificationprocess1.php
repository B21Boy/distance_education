<?php
	include("../connection.php");
    $M_sender=mysql_real_escape_string($_POST['M_sender']);
    $M_Reciever=mysql_real_escape_string($_POST['M_Reciever']);
	$message=mysql_real_escape_string($_POST['message']);
	$date_sended=mysql_real_escape_string($_POST['date_sended']);
	mysql_query("INSERT INTO message(M_sender ,M_Reciever,message,date_sended,status)VALUES('$M_sender','$M_Reciever','$message',NOW(),'no')");
	
	header("location: usernotification.php");
