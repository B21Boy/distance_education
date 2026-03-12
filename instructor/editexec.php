<?php
session_start();
include '../connection.php';
	$ccode =$_POST["cc"];
	$cname =$_POST["cn"];
	$dpt =$_POST["dc"];
	$ay =$_POST["ay"];
$uid=$_SESSION['suid'];
			
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
			$location=$_FILES["image"]["name"];
$update=mysql_query("UPDATE course SET Sender_name='$uid',FileName='$location',status='no' where course_code='$ccode'")or die(mysql_error());	
			if($update){
				$x='<script type="text/javascript">alert("Successfully Uploded !!!");
window.location=\'uploadmoduleto.php\';</script>';
echo $x;	
			}		
	
?>
