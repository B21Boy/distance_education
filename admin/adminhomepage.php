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
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
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
<script src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
?>

<div id="container">

    <!-- Header -->
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <!-- Menu -->
    <div id="menu">
        <?php require("menu.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenu.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="welcome">
                <h2>Welcome to the admin page</h2>
                <p>Use the menu above to manage users, accounts and site data.</p>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
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
                </div>
            </div>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php
} else {
	header("location:../index.php");
	exit();
}
?>
</body>
</html>