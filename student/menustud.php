<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$script_filename = isset($_SERVER['SCRIPT_FILENAME']) ? realpath($_SERVER['SCRIPT_FILENAME']) : '';
$current_file = realpath(__FILE__);
if ($script_filename !== '' && $current_file !== false && $script_filename === $current_file) {
	$target = isset($_SESSION['sun']) ? 'studentpage.php' : '../index.php';
	header("location:" . $target);
	exit;
}

if (!defined('STUDENT_FACEBOX_ASSETS_LOADED')) {
	define('STUDENT_FACEBOX_ASSETS_LOADED', true);
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

$user_id = isset($_SESSION['suid']) ? (int) $_SESSION['suid'] : 0;
$count = 0;

if ($user_id > 0 && isset($conn) && is_object($conn) && method_exists($conn, 'prepare')) {
	$stmt = $conn->prepare("SELECT COUNT(*) FROM message WHERE M_reciever = ? AND status = 'no'");
	if ($stmt) {
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
	}
}

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$use_modern_student_menu = !empty($student_portal_modern_menu);
$menu_items = array(
	array('href' => 'downloadmodule.php', 'label' => 'Download Module'),
	array('href' => 'assignmentdownload.php', 'label' => 'Download Assignment'),
	array(
		'href' => 'usernotification.php',
		'label' => 'Notification [' . $count . ']',
		'class' => $count >= 1 ? 'has-alert' : ''
	),
	array('href' => '../logout.php', 'label' => 'Log Out')
);
?>
<?php
$nav_attributes = $use_modern_student_menu
	? 'class="student-top-nav" style="display:block;width:100%;margin:0;padding:12px 18px;box-sizing:border-box;border-radius:0 0 18px 18px;background:linear-gradient(135deg, #0d4d7a, #1d7fa4);box-shadow:inset 0 1px 0 rgba(255,255,255,0.18);"'
	: 'id="menubar1"';
$list_attributes = $use_modern_student_menu
	? 'class="student-top-nav-list" style="display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:12px;list-style:none;margin:0;padding:0;"'
	: '';
?>
<nav <?php echo $nav_attributes; ?> aria-label="Student navigation">
	<ul <?php echo $list_attributes; ?>>
		<?php foreach ($menu_items as $item) {
			$item_class = isset($item['class']) ? trim($item['class']) : '';
			if ($current_page === basename($item['href'])) {
				$item_class = trim($item_class . ' active');
			}
			$link_style = '';
			if ($use_modern_student_menu) {
				$link_style = 'display:block;margin:0;padding:11px 18px;height:auto;line-height:1.2;border-radius:999px;background:rgba(255,255,255,0.08);color:#f7fbff;text-decoration:none;font-family:Georgia,\"Times New Roman\",serif;font-size:15px;font-weight:bold;letter-spacing:0.2px;';
				if (strpos($item_class, 'has-alert') !== false) {
					$link_style = 'display:block;margin:0;padding:11px 18px;height:auto;line-height:1.2;border-radius:999px;background:#fff1a8;color:#523400;text-decoration:none;font-family:Georgia,\"Times New Roman\",serif;font-size:15px;font-weight:bold;letter-spacing:0.2px;';
				}
				if (strpos($item_class, 'active') !== false && strpos($item_class, 'has-alert') === false) {
					$link_style = 'display:block;margin:0;padding:11px 18px;height:auto;line-height:1.2;border-radius:999px;background:#ffffff;color:#0f4f79;text-decoration:none;font-family:Georgia,\"Times New Roman\",serif;font-size:15px;font-weight:bold;letter-spacing:0.2px;';
				}
			}
			?>
			<li<?php echo $use_modern_student_menu ? ' style="margin:0;padding:0;float:none;list-style:none;"' : ''; ?>>
				<a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $item_class !== '' ? ' class="' . htmlspecialchars($item_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?><?php echo $link_style !== '' ? ' style="' . htmlspecialchars($link_style, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
					<?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</nav>
