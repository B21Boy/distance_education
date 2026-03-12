<?php
include('../connection.php');
if(isset($_POST['submit']))
{
$roomid = $_POST['roomid'];
$a1=$_POST['as1'];
$f=$_POST['fin'];
$total=$a1+$f;
if($total>=90)
		$grade='A+';
		else if($total<90 && $total>=85)
		$grade='A';
		else if($total<85 && $total>=80)
		$grade='A-';
		else if($total<80 && $total>=75)
		$grade='B+';
		else if($total<75 && $total>=70)
		$grade='B';
		else if($total<70 && $total>=65)
		$grade='B-';
		else if($total<65 && $total>=60)
		$grade='C+';
		else if($total<60 && $total>=50)
		$grade='C';
		else if( $total<50 && $total>=45)
		$grade='C-';
		else if($total<45 && $total>=40)
		$grade='D';
		else if($total<40 && $total>=30)
		$grade='FX';
		else
		$grade='F';

$sql=mysql_query("UPDATE course_result SET Assignment='$a1',Final='$f',Total='$total',Grade='$grade' where no='$roomid'");	

			if(!$sql)
			{
			die("<script>alert('Error! not Updated!');
			window.location=\'courseresultrequest.php\';</script>" . mysql_error());
			}
			else
			{
			$x='<script type="text/javascript">alert("Your Information Is Successfully Updated !!!");
			window.location=\'courseresultrequest.php\';</script>';
			echo $x;	
			}
}
?>