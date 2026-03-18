<?php
if (!function_exists('finance_safe_count')) {
	function finance_safe_count(mysqli $conn, string $sql): int
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
  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li></li>  <li></li>
<?php
$coun1 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='tutorial'");
$coun2 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexamassign'");
$coun3 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='iexam'");
$coun4 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='massignment'");
$coun5 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexam'");
$coun6 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='pexam'");
$coun7 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='module'");

$total=$coun1+$coun2+$coun3+$coun4+$coun5+$coun6+$coun7;
if($total>='1')
{
?>									
<li><a href="allrequest.php"><font size="4px" color="#f0e459">New Request From CDE Officer[<?php echo $total?>]</font></a></li>
		<?php
		}
		else
		{
			?>
<li><a href="allrequest.php">Request For Employee Worked pay</a></li>
			<?php
		}
		?>
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
							
							<span>Log out</span>
						</a>
					</li>
					
					
					<div class="clearfix"></div>
				</ul>             
	</div>					
</td></tr></table>
