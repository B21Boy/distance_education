<?php
session_start();
include("../connection.php");

// Debug: log which session keys are present (temporary - remove after troubleshooting)
$debug_file = '/tmp/admin_session_debug.txt';
$log = "--- adminhomepage debug: " . date('Y-m-d H:i:s') . " ---\n";
$expected = ['suid','sun','spw','sfn','sln','srole'];
foreach ($expected as $k) {
		if (isset($_SESSION[$k])) {
				if ($k === 'spw') {
						$log .= "$k: (set) length=" . strlen($_SESSION[$k]) . "\n"; // don't log raw password
				} else {
						$val = is_scalar($_SESSION[$k]) ? $_SESSION[$k] : json_encode($_SESSION[$k]);
						$log .= "$k: (set) $val\n";
				}
		} else {
				$log .= "$k: (NOT SET)\n";
		}
}
$log .= "\n";
file_put_contents($debug_file, $log, FILE_APPEND | LOCK_EX);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrator page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>

<style>
/* Admin homepage grid layout */
.admin-grid {
	display: grid;
	grid-template-areas:
		"header header header"
		"menu menu menu"
		"sidemenu content right"
		"footer footer footer";
	grid-template-columns: 280px 1fr 260px;
	gap: 12px;
	padding: 12px;
}
.admin-grid > .header { grid-area: header; }
.admin-grid > .menu-area { grid-area: menu; }
.admin-grid > .sidemenu { grid-area: sidemenu; }
.admin-grid > .content { grid-area: content; }
.admin-grid > .right { grid-area: right; }
.admin-grid > .footer { grid-area: footer; }

/* Make the menu area clearly blue with white links */
.menu-area { background: #336699; color: #fff; padding: 6px; border-radius:6px; }
.menu-area .primary-nav, .menu-area .primary-nav a { color: #fff; }
.menu-area .primary-nav a:hover { background: rgba(255,255,255,0.06); }

/* Simple panel styling */
.panel { background: #fff; padding: 12px; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
.profile-photo img, .profile-thumb { width: 180px; height: 160px; object-fit: cover; border-radius:4px; }

@media (max-width: 900px) {
	.admin-grid { grid-template-areas: "header" "menu" "content" "sidemenu" "right" "footer"; grid-template-columns: 1fr; }
}

/* Responsive fixes for sidemenu contents */
.sidemenu { overflow: auto; max-width: 100%; box-sizing: border-box; }
#sidebar1 { width: 100%; max-width: 100%; box-sizing: border-box; }
#sidebar1 ul { list-style: none; padding: 0; margin: 0; }
#sidebar1 li { margin: 6px 0; }

/* Ensure any tables, images or calendar widgets inside the sidebar don't overflow */
#sidebar1 img, #sidebar1 table, #sidebar1 .calendarShell, #sidebar1 .sidedate-widget { max-width: 100%; width: auto !important; height: auto; box-sizing: border-box; }
#sidebar1 .sidedate-widget table { width: 100%; }
#sidebar1 .sidedate-widget { margin-top: 6px; }
</style>

</head>
<body>
<?php
if(isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
?>

<div class="admin-grid">
	<div class="header panel">
		<?php require("header.php"); ?>
	</div>

	<div class="menu-area">
		<?php require("menu.php"); ?>
	</div>

	<div class="sidemenu panel">
		<?php require("sidemenu.php"); ?>
	</div>

	<div class="content panel">
		<h2>Welcome to the admin page</h2>
		<p>Use the menu above to manage users, accounts and site data.</p>
	</div>

	<div class="right panel profile-photo">
		<div class="profile-header"><strong>User Profile</strong></div>
		<?php
			echo "<div style='margin:8px 0;color:#333;'><strong>Welcome:</strong> <span style='color:#b00404;'>" . htmlspecialchars(
				(isset($_SESSION['sfn'])?$_SESSION['sfn']:'')) . " " . htmlspecialchars((isset($_SESSION['sln'])?$_SESSION['sln']:'')) . "</span></div>";
			$photo = isset($_SESSION['sphoto']) ? $_SESSION['sphoto'] : '../images/default.png';
			echo "<div><img src='".htmlspecialchars($photo)."' alt='photo' class='profile-thumb'></div>";
		?>
		<div id="sidebarr">
			<ul>
				<li><a href="updateprofilephoto.php">Change Photo</a></li>
				<li><a href="changepass.php">Change password</a></li>
			</ul>
		</div>
		<div class="social-links" style="margin-top:10px;">
			<a href="https://www.facebook.com/">Facebook</a><br>
			<a href="https://www.twitter.com/">Twitter</a><br>
			<a href="https://www.youtube.com/">Youtube</a>
		</div>
	</div>

	<div class="footer panel">
		<?php include("../footer.php"); ?>
	</div>

</div>

<?php
} else {
	header("location:../index.php");
	exit();
}
?>
</body>
</html>