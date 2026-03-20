<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if (!isset($conn)) {
	require_once("../connection.php");
}

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

if (!defined('FINANCE_FACEBOX_ASSETS_LOADED')) {
	define('FINANCE_FACEBOX_ASSETS_LOADED', true);
	?>
	<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="src/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[rel*=facebox]').facebox({
				loadingImage : 'src/loading.gif',
				closeImage   : 'src/closelabel.png'
			});
		});
	</script>
	<?php
}

$coun1 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='tutorial'");
$coun2 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexamassign'");
$coun3 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='iexam'");
$coun4 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='massignment'");
$coun5 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexam'");
$coun6 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='pexam'");
$coun7 = finance_safe_count($conn, "select * from payment_table where status='yes' and unread='yes' and payment='check' and type='module'");
$total = $coun1 + $coun2 + $coun3 + $coun4 + $coun5 + $coun6 + $coun7;

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

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$request_label = $total >= 1 ? 'New Request From CDE Officer[' . $total . ']' : 'Request For Employee Worked pay';
$request_class = trim(($total >= 1 ? 'has-alert ' : '') . ($current_page === 'allrequest.php' ? 'active' : ''));
$notification_class = trim(($count >= 1 ? 'has-alert ' : '') . ($current_page === 'usernotification.php' ? 'active' : ''));
?>
<nav id="menubar1" aria-label="Finance navigation">
	<ul>
		<li><a href="allrequest.php"<?php echo $request_class !== '' ? ' class="' . htmlspecialchars($request_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>><?php echo htmlspecialchars($request_label, ENT_QUOTES, 'UTF-8'); ?></a></li>
		<li><a href="usernotification.php"<?php echo $notification_class !== '' ? ' class="' . htmlspecialchars($notification_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>Notification[<?php echo htmlspecialchars((string) $count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
		<li><a href="../logout.php">Log out</a></li>
	</ul>
</nav>
