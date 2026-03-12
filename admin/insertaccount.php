<?php
include '../connection.php';
$uid=$_POST['uid'];
$un=$_POST['un'];
$pass=$_POST['pass'];
function encryptIt( $q ) 
{
$cryptKey='qJB0rGtIn5UB1xG03efyCp';
$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
return( $qEncoded );
}
 $passe = encryptIt($pass);
//$passe=md5($pass);
$role=$_POST['role'];
$st='yes';
				$sql="insert into account values('$uid','$un','$passe','$role','$st')";
						$inserted=mysqli_query($conn, $sql);
							if(mysqli_affected_rows($conn))
								{
									
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ipaddress=$http_client_ip;
		}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ipaddress=$http_x_forwarded_for;	
		}else{
			$ipaddress=$_SERVER['REMOTE_ADDR'];
		}
		session_start();
				$time = time();
			$actual_time = date('d M Y @ H:i:s', $time);
			$user=$_SESSION['suid'];
			$status='yes';
			$logid=2;
			$da=date('y-m-d');
	mysqli_query($conn, "INSERT INTO logfile (logid,username,role,status,start_time,activity_type,activity_performed,date,ip_address,end)  VALUES(' ','Admin','system admin','$status','$actual_time','create account',concat('uid[','$uid','] ','role[','$role','] ','status[','$status','] '),'$da','$ipaddress','')") or die (mysqli_error($conn));
	echo'<script type="text/javascript">alert("Account Created is Successfully Made!!!");window.location=\'addaccount.php\';</script>';

								}
								else
								{
									header("location: addaccount.php");
									echo "Unable to register the user";
								}
							
