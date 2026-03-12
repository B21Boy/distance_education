	
	 
<?php
session_start();
include("connection.php");
?>
<html>
<head>
<title>
Home page
</title>	
<link rel="stylesheet" type="text/css" href="setting.css">
<script type="text/javascript" src="javascript\date_time.js"></script>
<script src="js/validation.js" type="text/javascript"></script>
</head>
<body>
<div id="container">

<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="2">
<?php
    require("menu.php");
?>
</td></tr>
<tr><td>
<?php
		include("left.php");
	?>				

</td><td>
	<div id="contentindex5">
<form method="post" >
<table bgcolor="#f9fbf9" cellpadding="12" border="0" width="370px" >
<tr><td colspan="2" ><center><b><h3>Forgot password</h3></b>
</center></td></tr>
<tr>
<td>Enter UserName</td><td><input type="text" name="query" id="text" style="height: 30px;" required/>&nbsp;</td>
</tr>
<tr><td></td><td><input type="submit" name="submit" value="Search" style="height: 30px;width: 150px;"/></td></tr><br/>
</table>
</form>
<?php

if(isset($_POST['submit']))
{
$query = $_POST['query'];	
$min_length = 1;
if(strlen($query) >= $min_length)
{
	
$query = htmlspecialchars($query);
$query = mysql_real_escape_string($query);
$raw_results =mysql_query("SELECT * FROM  account WHERE UserName='$query'");

if(mysql_num_rows($raw_results)>0)
{
while($query2 = mysql_fetch_array($raw_results))
{
	$stat=$query2['status'];
	if($stat=='yes')
	{
?>

<form action="" method="post" >
	<table bgcolor="#f9fbf9" cellpadding="12" border="0"   ><tr><td>UserName</td><td> <input type="text" name="UserName" size="20" style="height: 30px;" value="<?php echo $query2['UserName']; ?>"  readonly=""/>
	</td></tr>
	<tr><td>New Password:</td><td> <input type="password" name="password" required size="20" style="height: 30px;" /><br />
<script type="text/javascript">
				    var f1 = new LiveValidation('password');
				   f1.add(Validate.Presence,{failureMessage: " It cannot be empty Password"});
				   f1.add(Validate.Format,{pattern: /^[0-9a-zA-Z]+$/ ,failureMessage: " It allows String and numbers"});
				   f1.add( Validate.Length, { minimum: 6, maximum: 12 } );
				   </script>	
</td></tr>
<tr><td>Confirm Password:</td><td> <input type="password" name="confirmpassword" required size="20" style="height: 30px;"/><br />
	<td>
	<script type="text/javascript">
				    var f1 = new LiveValidation('confirmpassword');
				   f1.add(Validate.Presence,{failureMessage: " It cannot be empty Password"});
				   f1.add(Validate.Format,{pattern: /^[0-9a-zA-Z]+$/ ,failureMessage: " It allows String and numbers"});
				   f1.add( Validate.Length, { minimum: 6, maximum: 12 } );
				   </script>	
	</td></tr>
	<tr><td></td><td><input type="submit" name="Reset" value=" Change Password " style="height: 30px;width: 150px" />
	</td></tr>
	</table>
	</form>
	
<?php
}else
echo "<h3 style='margin-left:100px;color:red'>Your account is Blocked!!!</h3";
}
}
else{
echo "<h3 style='margin-left:100px;color:red'>Incorect UserName Please Try Agian!!!</h3";

}
}

}
else{
//echo "Minimum length is greater than one";
}
?>

<?php


	if (isset($_POST["Reset"]))
	{
function encryptIt( $q ) 
{
$cryptKey='qJB0rGtIn5UB1xG03efyCp';
$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
return( $qEncoded );
}
	    $user = $_POST["UserName"];
	    $password = $_POST["password"];
	    $confirm = $_POST["confirmpassword"];
			 $np= encryptIt($password);
			 $cp= encryptIt($confirm);
			  if(empty($password)||empty($confirm)){
			echo"invalid password";
			  }
			  else{
			  $sql="select * from account WHERE UserName='$user'";
	     $result = mysql_query($sql);
       $records = mysql_num_rows($result);
       $myrow = mysql_fetch_array($result);
       $staa=$myrow['Password'];
	 
			  if($password==$confirm)
			  {
				  $sql="update account set Password='$np' WHERE UserName='$user'";
				  			 if( mysql_query($sql)){
echo " Reset password sucessfull!";
			  }}
			  			  else{
echo" password is not matched!try again";
	}}}
	?>

	
	
	 </div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
	 User Login
	 </div>
	 
	 <?php 
	require("leftlogin.php");
     ?>
	 
	 
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
include("footer.php");
?>
</td></tr>

</div>
</table>
</body>
</html>
