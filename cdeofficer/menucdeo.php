<?php
if (!function_exists('cdeofficer_safe_count')) {
	function cdeofficer_safe_count(mysqli $conn, string $sql): int
	{
		$result = mysqli_query($conn, $sql);
		if ($result instanceof mysqli_result) {
			$count = mysqli_num_rows($result);
			mysqli_free_result($result);
			return $count;
		}

		return 0;
	}
}

if (!isset($conn)) {
	require_once("../connection.php");
}
?>
<!--sa poip up-->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
   <script src="lib/jquery.js" type="text/javascript"></script>
  <script src="src/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'src/loading.gif',
        closeImage   : 'src/closelabel.png'
      })
    })
  </script>

<table>
<tr><td>
  <div id="menubar1">
  <ul>
             	<?php
$count = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='tutorial'");
$couni = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='iexam'");
$counmea = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexamassign'");
$counma = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='massignment'");
$counme = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexam'");
$counpe = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='pexam'");

$total=$count+$couni+$counmea+$counma+$counme+$counpe;
?>
  <li><a href="cdeofficerpage.php">Calculate Employee Worked Fee<span style="color: #dbf428">[<?php echo $total; ?>] </span></a> </li>
<li><a href="preparemoduleschedule.php">Post module Preparation schedule</a> </li>

  				
					<?php
					$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
	$count = 0;
	if ($user_id !== '') {
		$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
		$result = mysqli_query($conn, $sql);
		if ($result instanceof mysqli_result) {
			$count = mysqli_num_rows($result);
			mysqli_free_result($result);
		}
	}
	if($count>='1')
	{
					?>
					<li>
						<a href="usernotification.php">
							
							<span style="color: #dbf428">Notification[<?php echo $count; ?>] </span>
						</a></li>
						<?php
						}
						else
						{
						?>
						<li><a href="usernotification.php">
							
							<span >Notification[<?php echo $count; ?>] </span>
						</a></li>
						<?php
						}
						?>
					
<li>                  
<a href="../logout.php">
							
							<span>Log out</span></a></li></ul>
</div>
</td></tr></table>
