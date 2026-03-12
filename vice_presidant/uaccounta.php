<?php
session_start();
include("../connection.php");
 $dd=$_SESSION['suid'];
if(isset($_POST['submit']))
			  {
function encryptIt( $q ) 
{
$cryptKey='qJB0rGtIn5UB1xG03efyCp';
$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
return( $qEncoded );
}
			  $opass=encryptIt($_POST['opass']);
			  $npass=$_POST['npass'];
			  $rnpass=$_POST['rnpass'];
			  $npa=encryptIt($npass);
			  $rnpa=encryptIt($rnpass);
			  if(empty($opass)||empty($npass)||empty($rnpass)){
			echo"invalid password";
			}
	 $sql="select * from account WHERE UID='$dd'";
	     $result = mysql_query($sql);
       $records = mysql_num_rows($result);
       $myrow = mysql_fetch_array($result);
       $staa=$myrow['Password'];
			  $ps=$staa;
			  if($npass==$rnpass)
			  {
			  	if($ps==$opass){
			  		    	if($rnpass==$ps){
echo '<script type="text/javascript">alert("the old password not used as the new password!");
window.location=\'changepass.php\';</script>';
				}
				else
				 {
		$sql="update account set Password='$npa' WHERE UID='$dd'";
			  
			 if( mysql_query($sql)){
echo '<script type="text/javascript">alert("password changed sucessfull!");
window.location=\'changepass.php\';</script>';
			  }
			  }}
			  else{
echo '<script type="text/javascript">alert("old password is incorrect");
window.location=\'changepass.php\';</script>';
			  }
			    if(!$sql){
			  	echo '<script type="text/javascript">alert("old password is incorrect");
window.location=\'changepass.php\';</script>';
			  }
			  }
			  else{
echo '<script type="text/javascript">alert("password not mached");
window.location=\'changepass.php\';</script>';
			  }
}
echo mysql_error();
?>