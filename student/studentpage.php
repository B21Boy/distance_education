<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Student page
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
	$first_name = htmlspecialchars($_SESSION['sfn'], ENT_QUOTES, 'UTF-8');
	$last_name = htmlspecialchars($_SESSION['sln'], ENT_QUOTES, 'UTF-8');
	$full_name = trim($first_name . ' ' . $last_name);
	$photo_value = isset($_SESSION['sphoto']) ? trim($_SESSION['sphoto']) : '';
	if ($photo_value === '') {
		$photo_value = 'userphoto/img1.jpg';
	}
	$photo_path = htmlspecialchars($photo_value, ENT_QUOTES, 'UTF-8');
?>
<div id="container" class="student-portal-shell">
	<div id="header">
		<?php require("header.php"); ?>
	</div>

		<div id="menu">
			<?php $student_portal_modern_menu = true; ?>
			<?php require("menustud.php"); ?>
		</div>

	<div class="main-row">
		<aside id="left">
			<?php require("sidemenustud.php"); ?>
		</aside>

		<main id="content">
			<div id="contentindex5" class="student-dashboard-home">
				<section class="student-hero">
					<p class="student-hero-label">Student Dashboard</p>
					<h2>Welcome back, <?php echo $first_name; ?>.</h2>
					<p>Use this page to download modules, submit assignments, check results, and follow new notifications from the university.</p>
				</section>

				<section class="student-quick-grid" aria-label="Quick actions">
					<a class="student-quick-card" href="downloadmodule.php">
						<strong>Modules</strong>
						<span>Get your latest course materials.</span>
					</a>
					<a class="student-quick-card" href="assignmentsubmit.php">
						<strong>Assignments</strong>
						<span>Submit your completed assignment files.</span>
					</a>
					<a class="student-quick-card" href="viewgradeallv.php">
						<strong>Grades</strong>
						<span>Review approved grade reports quickly.</span>
					</a>
					<a class="student-quick-card" href="usernotification.php">
						<strong>Notifications</strong>
						<span>Check unread updates and announcements.</span>
					</a>
				</section>
			</div>
		</main>

		<aside id="sidebar">
			<section id="user-login">
				<h3>User Profile</h3>
				<div class="student-profile-card">
					<img src="<?php echo $photo_path; ?>" alt="<?php echo $full_name; ?>" class="student-profile-photo">
					<p class="student-profile-name"><?php echo $full_name; ?></p>
					<p class="student-profile-role">Student account</p>
				</div>
				<div id="sidebarr">
					<ul>
						<li><a href="updateprofilephoto.php">Change Photo</a></li>
						<li><a href="changepass.php">Change Password</a></li>
					</ul>
				</div>
			</section>

			<section id="social-links">
				<h3>Social Links</h3>
				<ul class="student-social-list">
					<li><a href="https://www.facebook.com/">Facebook</a></li>
					<li><a href="https://www.twitter.com/">Twitter</a></li>
					<li><a href="https://www.youtube.com/">YouTube</a></li>
					<li><a href="https://plus.google.com/">Google+</a></li>
				</ul>
			</section>
		</aside>
	</div>

	<div id="footer">
		<?php include("../footer.php"); ?>
	</div>
</div>
<?php
} else {
	header("location:../index.php");
	exit;
}
?>
</body>
</html>
