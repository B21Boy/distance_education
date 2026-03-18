<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<style>
/* inline fallback when stylesheet isn't loaded: keep columns, spacing, and proportions */
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
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
<div id="container">
	<div id="header">
		<?php require("header.php"); ?>
	</div>

		<div id="menu">
			<?php $student_portal_modern_menu = true; ?>
			<?php require("menustud.php"); ?>
		</div>

	<div class="main-row">
		<div id="left">
			<?php require("sidemenustud.php"); ?>
		</div>

		<div id="content">
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
		</div>

		<div id="sidebar">
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
		</div>
	</div>

	<div id="footer">
		<?php include("../footer.php"); ?>
	</div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
} else {
	header("location:../index.php");
	exit;
}
?>
</body>
</html>
