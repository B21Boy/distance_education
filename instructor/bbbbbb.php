<?php
include('../connection.php');
session_start();
if (!isset($_FILES['image']['tmp_name'])) {
	echo "";
	}else{
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);

			move_uploaded_file($_FILES["image"]["tmp_name"],"../material/module/" . $_FILES["image"]["name"]);
			
			$location=$_FILES["image"]["name"];
			$id=$_POST['id'];
			$uid=$_SESSION['suid'];
			$update=mysql_query("UPDATE course SET Sender_name='$uid',FileName='$location',status='no' where course_code='$id'");
			if($update){
				$x='<script type="text/javascript">alert("Successfully Uploded !!!");
window.location=\'uploadmoduleto.php\';</script>';
echo $x;	
			}		
	}
?>
