	<?php
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($conn)) {
		include("../connection.php");
	}
	?>
<script src="js/validation.js" type="text/javascript"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<?php
if (!defined('DEPARTMENT_FACEBOX_ASSETS_LOADED')) {
	define('DEPARTMENT_FACEBOX_ASSETS_LOADED', true);
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
$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$notification_class = trim(($count >= 1 ? 'has-alert ' : '') . ($current_page === 'usernotification.php' ? 'active' : ''));
?>
<nav id="menubar1" aria-label="Department navigation">
	<ul>
		<li><a href="managecourse.php"<?php echo $current_page === 'managecourse.php' ? ' class="active"' : ''; ?>>Register course</a></li>
		<li><a href="manageinst.php"<?php echo $current_page === 'manageinst.php' ? ' class="active"' : ''; ?>>Assign instructor</a></li>
		<li class="menu-dropdown">
			<button type="button" class="menu-dropdown-toggle">Prepare Employee worked time</button>
			<ul class="menu-dropdown-menu">
				<li><a rel="facebox" href="offeringtutorial.php">Offering Tutorial Program</a></li>
				<li><a rel="facebox" href="markingexam.php">Marking Exams</a></li>
				<li><a rel="facebox" href="markingassignment.php">Marking Assignments</a></li>
				<li><a rel="facebox" href="invigilatingfexam.php">Invigilating Final Exams</a></li>
				<li><a rel="facebox" href="preparingexam.php">Preparing Exams</a></li>
				<li><a rel="facebox" href="markingexamassign.php">Marking Exams and Assignments</a></li>
			</ul>
		</li>
		<li><a href="usernotification.php"<?php echo $notification_class !== '' ? ' class="' . htmlspecialchars($notification_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>Notification[<?php echo htmlspecialchars((string) $count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
		<li><a href="../logout.php">Log out</a></li>
	</ul>
</nav>
