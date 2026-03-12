<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
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
    require("menustud.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenustud.php");
?>
	
</td><td>
	<div id="contentindex5">
<form action="1.php"method="POST" >
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Send feedback Form</center></td></tr>
<tr><td>User Type:</td><td><input type="text" name="ut" id="ut" readonly style="height: 30px;width: 200px;" value="student"/>
</td></tr>
<tr><td> Name:</td><td><input type="text" name="faname" id="faname" style="height: 30px;width: 200px;" required="required"  placeholder="name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('faname');
				    f1.add(Validate.Presence,{failureMessage: " Please enter  name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>
<tr><td> Email:</td><td><input type="email" name="em" id="emial" style="height: 30px;width: 200px;" required="required"  placeholder="email" />
</td></tr>

<tr><td>Comment:</td><td><textarea  name="feedback" id="feedback"  ROWS="15" COLS="24"  placeholder="Text" wrap="warp" required="" style="height: 100px;width: 200px;text-align: left;"></textarea>
         
       <script type="text/javascript">
				    var f1 = new LiveValidation('feedback');
				    f1.add(Validate.Presence,{failureMessage: " Please enter feedback "});
				     f1.add(Validate.Format,{pattern: /^[0-9a-zA-Z&nbsp; ]+$/ ,failureMessage: " It allows only String"});
				      f1.add( Validate.Length, { minimum: 10, maximum: 10000 } );
				 </script>  	
         </td></tr>
<tr><td></td><td><input type="submit"  name="submit" value="Send" style="height: 40px;width: 120px;"id="m">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="m"> </td>
</tr>
	</table>
	</form>
</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#ee342f>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="updateprofilephoto.php">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Social link 
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