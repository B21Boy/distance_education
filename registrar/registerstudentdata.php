<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Registrar Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
	#btn
	{
		background-color: #2684d9;
		height: 30px;
		width: 100px;
		color: white;
		cursor: pointer;
		border: none;
		font-family: Times New Roman;
		font-size: 20px;
		margin-top: 20px;
		border-radius: 5px;
	}
#file{
   position: relative;
   font-family: calibri;
   width: 250px;
   padding: 10px;
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border: 1px solid #468ed0; 
   text-align: center;
   background-color: #DDD;
   cursor:pointer;
  }
  .l
  {
  
  	 width: 250px;
  }
	</style>
</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menuro.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenuro.php");
?>
	
</td><td>
	<div id="contentindex5">
<center>
<form method="post" enctype="multipart/form-data">
<fieldset style="border: none;">
<legend style="color: black;margin-left: 0px;font-size: 30px;">Student Data Register Page</legend>
<br/><br/><br/>
	 Select Data:
	 <label id="file">Choose File
	 <input type="file" name="file" class="l" required/></label> <br/><br/>
	 	<input type="submit" name="submit" value="Register" id="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="Cancel" id="btn"/>
	 	<br>
	 <?php
$con=mysqli_connect("localhost","root","","cde");
if(isset($_POST["submit"]))
{
	if($_FILES['file']['name'])
	{
		$filename=explode(".",$_FILES['file']['name']);
		if($filename[1]=='csv')
		{
			$handle=fopen($_FILES['file']['tmp_name'],"r");
			while($data=fgetcsv($handle))
			{
					$id=mysqli_real_escape_string($con,$data[0]);
					$fname=mysqli_real_escape_string($con,$data[1]);
					$mname=mysqli_real_escape_string($con,$data[2]);
					$lname=mysqli_real_escape_string($con,$data[3]);
					$sex=mysqli_real_escape_string($con,$data[4]);
					$email=mysqli_real_escape_string($con,$data[5]);
					$pno=mysqli_real_escape_string($con,$data[6]);
					$coll=mysqli_real_escape_string($con,$data[7]);
					$dept=mysqli_real_escape_string($con,$data[8]);
					$year=mysqli_real_escape_string($con,$data[9]);
					$sem=mysqli_real_escape_string($con,$data[10]);
					$program=mysqli_real_escape_string($con,$data[11]);
					$date=mysqli_real_escape_string($con,$data[12]);
$sql="insert into student(S_ID,FName,mname,LName,Sex,Email,Phone_No,College,Department,year,semister,program,Date) values('$id','$fname','$mname','$lname','$sex','$email','$pno','$coll','$dept','$year','$sem','$program','$date')";
				$result=mysql_query($sql);
			}
			if($result)
          	print "Successfully Registerd";
          	else
          	print"Not Registerd";
		}
		else
		print "<font color=red>file is not csv type</font>";
	}
}
?>
	 </fieldset>
</form>
</center>





 </div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#db0b0b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Another link 
	 </div>
	 <div id="siderightindexadational12">
	 <table>
	 <tr><td><div id="facebook"></div></td><td>
	<p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
	<tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
	<tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
	<tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>
	</div>
	 </div>
	  </td>
	 </tr>
	 <tr><td>
<?php
include("../footer.php");
?>
</td></tr>

</div>
</table>

<?php
}
else
header("location:../index.php");
?>
</body>
</html>