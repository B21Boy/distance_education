<?php
$include_path = '../connection.php';
include $include_path;
$uid=$_POST['uid'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$sex=$_POST['sex'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$loc=$_POST['loc'];
$role=$_POST['ct'];
	$ptmploc = isset($_FILES["photo"]["tmp_name"]) ? $_FILES["photo"]["tmp_name"] : '';
	$pname = isset($_FILES["photo"]["name"]) ? $_FILES["photo"]["name"] : '';
	$psize = isset($_FILES["photo"]["size"]) ? $_FILES["photo"]["size"] : 0;
	$pupload_error = isset($_FILES['photo']['error']) ? $_FILES['photo']['error'] : UPLOAD_ERR_NO_FILE;

	// Determine whether a photo was uploaded. Photo is optional.
	$photo_uploaded = ($pupload_error !== UPLOAD_ERR_NO_FILE) && !empty($ptmploc);

	if ($photo_uploaded) {
		// check upload error
		if ($pupload_error !== UPLOAD_ERR_OK) {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Photo upload error (code: ' . $pupload_error . ')");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}

		// size check (2 MB)
		if ($psize > 2000000) {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Photo size should not be greater than 2 MB!");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}

		// verify image contents
		$imginfo = @getimagesize($ptmploc);
		if ($imginfo === false) {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Uploaded file is not a valid image");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}
		$mime = isset($imginfo['mime']) ? $imginfo['mime'] : '';
		$allowed = array('image/jpeg', 'image/pjpeg', 'image/png');
		if (!in_array($mime, $allowed)) {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Photo should be JPEG or PNG format");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}

		// ensure upload directory exists and is writable
		if (!file_exists("userphoto")) {
			mkdir("userphoto", 0755, true);
		}
		// generate unique filename to avoid collisions
		$extension = ($mime === 'image/png') ? 'png' : 'jpg';
		$newname = uniqid('user_', true) . '.' . $extension;
		$photopath = "userphoto/" . $newname;
		if (!move_uploaded_file($ptmploc, $photopath)) {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Unable to upload the photo!");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}
	} else {
		// no photo uploaded; use empty string (database can accept empty photo)
		$photopath = '';
	}

	if (true) {
		if ($role == 'collage_dean') {
			$co = isset($_POST['ac']) ? $_POST['ac'] : '';
			$sql = "INSERT INTO user(UID,fname,lname,sex,Email,phone_No,location,photo,c_code) VALUES('$uid','$fname','$lname','$sex','$email','$phone','$loc','$photopath','$co')";
			$inserted = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		} elseif ($role == 'department_head' || $role == 'instructor') {
			$co = isset($_POST['ac']) ? $_POST['ac'] : '';
			$dd = isset($_POST['dc']) ? $_POST['dc'] : '';
			$sql = "INSERT INTO user(UID,fname,lname,sex,Email,phone_No,location,photo,d_code,c_code) VALUES('$uid','$fname','$lname','$sex','$email','$phone','$loc','$photopath','$dd','$co')";
			$inserted = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		} else {
			$sql = "INSERT INTO user(UID,fname,lname,sex,Email,phone_No,location,photo) VALUES('$uid','$fname','$lname','$sex','$email','$phone','$loc','$photopath')";
			$inserted = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}

		if ($inserted) {
			// determine IP address safely
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ipaddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
			}
			// ensure session is active for logging
			if (session_status() !== PHP_SESSION_ACTIVE) {
				session_start();
			}
			$time = time();
			$actual_time = date('d M Y @ H:i:s', $time);
			$user = isset($_SESSION['suid']) ? $_SESSION['suid'] : '';
			$status = 'yes';
			$da = date('y-m-d');
			mysqli_query($conn, "INSERT INTO logfile (logid,username,role,status,start_time,activity_type,activity_performed,date,ip_address,end)  VALUES(' ','Admin','system admin','$status','$actual_time','add user',concat('uid[','$uid','] ','name[','$fname','] ','father name[','$lname','] ','sex[','$sex','] ','user id[','$uid','] ','phone[','$phone','] '),'$da','$ipaddress','')") or die (mysqli_error($conn));
			// Return a small HTML page that shows an alert then navigates back to the form.
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Registered</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Your Information Is Successfully Registered !!!");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		} else {
			echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title>';
<script src="theme.js"></script>
			echo '<script type="text/javascript">alert("Unable to register the user");window.location="adduser.php";</script>';
			echo '</head><body class="light-theme"></body></html>';
			exit;
		}
	}
?>
