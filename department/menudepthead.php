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
<style>
#menubar1 .dept-dropdown {
    position: relative;
}
#menubar1 .dept-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    min-width: 260px;
    padding: 10px 0;
    margin: 0;
    list-style: none;
    background: #13466e;
    border-radius: 14px;
    box-shadow: 0 12px 24px rgba(12, 33, 76, 0.24);
    z-index: 20;
}
#menubar1 .dept-dropdown:hover .dept-dropdown-menu {
    display: block;
}
#menubar1 .dept-dropdown-menu li {
    margin: 0;
    width: 100%;
}
#menubar1 .dept-dropdown-menu a {
    display: block;
    padding: 10px 16px;
    border-radius: 0;
    background: transparent !important;
    color: #f7fbff !important;
    font-size: 14px !important;
    font-weight: 600;
    text-decoration: none;
    white-space: normal;
}
#menubar1 .dept-dropdown-menu a:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    transform: none !important;
}
</style>
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
		<li class="dept-dropdown">
			<a href="#">Prepare Employee worked time</a>
			<ul class="dept-dropdown-menu">
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
