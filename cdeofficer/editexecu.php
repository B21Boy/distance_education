<?php
include '../connection.php';
	$ccode =$_POST["cc"];
	$cname =$_POST["cn"];
	$dpt =$_POST["combo"];
	$scy =$_POST["combo1"];
	$sem =$_POST["sem"];
	$ch =$_POST["ch"];
	$ay =$_POST["ay"];
	if (!isset($_FILES['image']['tmp_name'])) {
	echo "";
	}else{
	$file=$_FILES['image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);

			move_uploaded_file($_FILES["image"]["tmp_name"],"../material/module/" . $_FILES["image"]["name"]);
			
			$location=$_FILES["image"]["name"];		
$update=mysql_query("Update course SET s_c_year='$scy',semister='$sem',FileName='$location',other_department_takes='$dpt',status='yes',unread='no' where course_code='$ccode'");
if($update)
{
$x='<script type="text/javascript">alert("Successfully Uploded !!!");window.location=\'viewuploadmodule.php\';</script>';
echo $x;	
}
else
			{
			die("<script>alert('Error! not Uploded!');
			window.location=\'viewuploadmodule.php\';</script>" . mysql_error());
			}
}
	
?>
