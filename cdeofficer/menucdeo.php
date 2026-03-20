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
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!defined('CDEOFFICER_FACEBOX_ASSETS_LOADED')) {
	define('CDEOFFICER_FACEBOX_ASSETS_LOADED', true);
	?>
	<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="src/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[rel*=facebox]').facebox({
				loadingImage: 'src/loading.gif',
				closeImage: 'src/closelabel.png'
			});
		});
	</script>
	<?php
}

$count = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='tutorial'");
$couni = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='iexam'");
$counmea = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexamassign'");
$counma = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='massignment'");
$counme = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexam'");
$counpe = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='pexam'");

$total=$count+$couni+$counmea+$counma+$counme+$counpe;
?>
<?php
$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$message_count = 0;
if ($user_id !== '') {
	$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
	$result = mysqli_query($conn, $sql);
	if ($result instanceof mysqli_result) {
		$message_count = mysqli_num_rows($result);
		mysqli_free_result($result);
	}
}

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$menu_items = array(
	array(
		'href' => 'cdeofficerpage.php',
		'label' => 'Calculate Employee Worked Fee[' . $total . ']',
		'class' => $total >= 1 ? 'has-alert' : ''
	),
	array('href' => 'preparemoduleschedule.php', 'label' => 'Post module Preparation schedule'),
	array(
		'href' => 'usernotification.php',
		'label' => 'Notification[' . $message_count . ']',
		'class' => $message_count >= 1 ? 'has-alert' : ''
	),
	array('href' => '../logout.php', 'label' => 'Log out')
);
?>
<nav id="menubar1" aria-label="CDE officer navigation">
	<ul>
		<?php foreach ($menu_items as $item) {
			$item_class = isset($item['class']) ? trim($item['class']) : '';
			if ($current_page === basename($item['href'])) {
				$item_class = trim($item_class . ' active');
			}
			?>
			<li>
				<a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $item_class !== '' ? ' class="' . htmlspecialchars($item_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
					<?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</nav>
