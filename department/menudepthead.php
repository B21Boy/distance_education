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
$dept = isset($_SESSION['sdc']) ? mysqli_real_escape_string($conn, (string) $_SESSION['sdc']) : '';
$department_name = '';
if ($dept !== '') {
	$department_result = mysqli_query($conn, "SELECT DName FROM department WHERE Dcode='$dept'");
	if ($department_result instanceof mysqli_result) {
		$department_row = mysqli_fetch_assoc($department_result);
		if ($department_row && isset($department_row['DName'])) {
			$department_name = (string) $department_row['DName'];
		}
		mysqli_free_result($department_result);
	}
}
$approve_course_count = 0;
if ($dept !== '') {
	$approve_course_result = mysqli_query($conn, "SELECT DISTINCT uid, section, C_Code, year FROM course_result WHERE status='posted' AND reject=' ' AND send_to='$dept'");
	if ($approve_course_result instanceof mysqli_result) {
		$approve_course_count = mysqli_num_rows($approve_course_result);
		mysqli_free_result($approve_course_result);
	}
}
$approve_grade_count = 0;
if ($department_name !== '') {
	$escaped_department_name = mysqli_real_escape_string($conn, $department_name);
	$approve_grade_result = mysqli_query($conn, "SELECT DISTINCT department, section, year FROM grade WHERE status='approve' AND checking='pending' AND department='$escaped_department_name'");
	if ($approve_grade_result instanceof mysqli_result) {
		$approve_grade_count = mysqli_num_rows($approve_grade_result);
		mysqli_free_result($approve_grade_result);
	}
}
$approve_total_count = $approve_course_count + $approve_grade_count;
$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$notification_class = trim(($count >= 1 ? 'has-alert ' : '') . ($current_page === 'usernotification.php' ? 'active' : ''));
?>
<nav id="menubar1" aria-label="Department navigation">
	<ul>
		<li><a href="managecourse.php"<?php echo $current_page === 'managecourse.php' ? ' class="active"' : ''; ?>>Register course</a></li>
		<li><a href="manageinst.php"<?php echo $current_page === 'manageinst.php' ? ' class="active"' : ''; ?>>Assign instructor</a></li>
		<!-- <li class="menu-dropdown">
			<button type="button" class="menu-dropdown-toggle">Prepare Employee worked time</button>
			<ul class="menu-dropdown-menu">
				<li><a rel="facebox" href="offeringtutorial.php">Offering Tutorial Program</a></li>
				<li><a rel="facebox" href="markingexam.php">Marking Exams</a></li>
				<li><a rel="facebox" href="markingassignment.php">Marking Assignments</a></li>
				<li><a rel="facebox" href="invigilatingfexam.php">Invigilating Final Exams</a></li>
				<li><a rel="facebox" href="preparingexam.php">Preparing Exams</a></li>
				<li><a rel="facebox" href="markingexamassign.php">Marking Exams and Assignments</a></li>
			</ul>
		</li> -->
		<!-- <li class="menu-dropdown">
			<button type="button" class="menu-dropdown-toggle">View Employee worked time</button>
			<ul class="menu-dropdown-menu">
				<li><a href="messageddotutorial.php">Offering Tutorial Program</a></li>
				<li><a href="messageddmexam.php">Marking Exams</a></li>
				<li><a href="messageddmassignment.php">Marking Assignments</a></li>
				<li><a href="messageddifexam.php">Invigilating Final Exams</a></li>
				<li><a href="messageddpexam.php">Preparing Exams</a></li>
				<li><a href="messageddmexamassign.php">Marking Exams and Assignments</a></li>
			</ul>
		</li> -->
		<li class="menu-dropdown">
			<button type="button" class="menu-dropdown-toggle">Approve student results[<?php echo htmlspecialchars((string) $approve_total_count, ENT_QUOTES, 'UTF-8'); ?>]</button>
			<ul class="menu-dropdown-menu">
				<li><a href="allrequest.php">Course Result[<?php echo htmlspecialchars((string) $approve_course_count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
				<li><a href="allrequestgr.php">Grade Report[<?php echo htmlspecialchars((string) $approve_grade_count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
			</ul>
		</li>
		<li><a href="usernotification.php"<?php echo $notification_class !== '' ? ' class="' . htmlspecialchars($notification_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>Notification[<?php echo htmlspecialchars((string) $count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
		<li><a href="../logout.php">Log out</a></li>
	</ul>
</nav>
