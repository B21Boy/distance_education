<?php
include('../connection.php');


if (!isset($_FILES['image']['tmp_name'])) {
	echo "";
	}else{
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);

	
		
			
			move_uploaded_file($_FILES["image"]["tmp_name"],"students3k/" . $_FILES["image"]["name"]);
			
			$location=$_FILES["image"]["name"];
			$id=$_POST['id'];
			

			
			$update=mysql_query("UPDATE assign_instructor SET fileName='$location' where corse_code='$id'");
			
			
			header("location: uploadmoduleto.php");
			exit();
		
			
	}


?>
