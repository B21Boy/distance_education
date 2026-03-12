<?php
session_start();
include("../connection.php");
?>

<?php
if(isset($_POST['submit'])){
	$uid=$_SESSION['suid'];
	     $ptmploc=$_FILES["photo"]["tmp_name"];
	$pname=$_FILES["photo"]["name"];
	$psize=$_FILES["photo"]["size"];
	$ptype=$_FILES["photo"]["type"];

				
				
					
						if($psize<=2000000&&$ptype=="image/jpeg")
						{
							if(!file_exists("userphoto"))
								mkdir("userphoto");
							$photopath="userphoto/$pname";
							$sq=mysql_query("update user set photo='$photopath' where UID='$uid'");
							if($sq)
							{
		$x='<script type="text/javascript">alert("Successfully Changed !!!");window.location=\'updateprofilephoto.php\';</script>';
			echo $x;	
							}

						}
						}
?>