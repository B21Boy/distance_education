<?php
if (!isset($conn)) {
	require_once("../connection.php");
}
?>
<table>
<tr><td>
  <div id="menubar1">
  
  <ul>
 <li></li>  <li></li>
					<?php
						$id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$cc = '';
if ($id !== '') {
	$s = mysqli_query($conn, "select * from user where UID='$id'");
	if ($s instanceof mysqli_result) {
		$rr = mysqli_fetch_assoc($s);
		if ($rr) {
			$cc = $rr['c_code'];
		}
		mysqli_free_result($s);
	}
}

$coun1 = 0;
$coun2 = 0;
$coun3 = 0;
$coun4 = 0;
$coun5 = 0;
$coun6 = 0;
$coun7 = 0;
if ($cc !== '') {
	$query1 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='tutorial' and c_code='$cc'");
	if ($query1 instanceof mysqli_result) {
		$coun1 = mysqli_num_rows($query1);
		mysqli_free_result($query1);
	}
	$query2 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='mexamassign' and c_code='$cc'");
	if ($query2 instanceof mysqli_result) {
		$coun2 = mysqli_num_rows($query2);
		mysqli_free_result($query2);
	}
	$query3 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='iexam' and c_code='$cc'");
	if ($query3 instanceof mysqli_result) {
		$coun3 = mysqli_num_rows($query3);
		mysqli_free_result($query3);
	}
	$query4 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='massignment' and c_code='$cc'");
	if ($query4 instanceof mysqli_result) {
		$coun4 = mysqli_num_rows($query4);
		mysqli_free_result($query4);
	}
	$query5 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='mexam' and c_code='$cc'");
	if ($query5 instanceof mysqli_result) {
		$coun5 = mysqli_num_rows($query5);
		mysqli_free_result($query5);
	}
	$query6 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='pexam' and c_code='$cc'");
	if ($query6 instanceof mysqli_result) {
		$coun6 = mysqli_num_rows($query6);
		mysqli_free_result($query6);
	}
	$query7 = mysqli_query($conn, "select * from payment_table where status=' ' and unread='no' and type='module' and c_code='$cc'");
	if ($query7 instanceof mysqli_result) {
		$coun7 = mysqli_num_rows($query7);
		mysqli_free_result($query7);
	}
}

$total=$coun1+$coun2+$coun3+$coun4+$coun5+$coun6+$coun7;
if($total>='1')
{
?>									
<li><a href="allrequest.php"><font size="4px" color="#f0e459">New Request From Department[<?php echo $total?>]</font></a></li>
		<?php
		}
		else
		{
			?>
<li><a href="allrequest.php">Request For Employee worked Time</a></li>
			<?php
		}
		?>
		<li><a href="viewacadamicschedul.php">View Acadamic Schedule</a></li>
		
					<li>
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
						<a href="usernotification.php">
							
							<span style="color: #dbf428">Notification[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						else
						{
						?>
						<a href="usernotification.php">
							
							<span >Notification[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						?>
					</li>
					<li>
						<a href="../logout.php">
							
							<span>Log out</span>
						</a>
					</li>
					
					
					<div class="clearfix"></div>
				</ul>             
	</div>					
</td></tr></table>
