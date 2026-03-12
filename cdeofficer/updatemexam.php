
<?php
	include('../connection.php');
$roomid = $_POST['roomid'];
$pe=$_POST['ppe'];
$tp=$_POST['total'];
$sql=mysql_query("UPDATE payment_table SET Payment_per='$pe',Total_Payment='$tp' where no='$roomid'");
//$query1=mysql_query("UPDATE payment_table SET unread='yes',status='yes',payment='check' where no='$roomid'");
$query2=mysql_query("select * from payment_table where unread='yes' and status='no' and no='$roomid'");

$count = mysql_num_rows($query2);	
if ($count != '0')
{
			if(!$sql)
			{
			die("<script>alert('Error! not Updated!');
			window.location=\'unreaddmexam.php\';</script>" . mysql_error());
			}
			else
			{
			$x='<script type="text/javascript">alert("Your Information Is Successfully Calculated !!!");
			window.location=\'unreaddmexam.php\';</script>';
			echo $x;	
			}
}
else{
            if(!$sql)
			{
			die("<script>alert('Error! not Updated!');
			window.location=\'unreaddmexam.php\';</script>" . mysql_error());
			}
			else
			{
			$x='<script type="text/javascript">alert("Your Information Is Successfully Calculated !!!");
			window.location=\'unreaddmexam.php\';</script>';
			echo $x;	
			}	
}
?>