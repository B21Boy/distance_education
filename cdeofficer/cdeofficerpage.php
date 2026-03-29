<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
body.student-portal-page #container {
    max-width: 1520px !important;
    width: calc(100% - 32px) !important;
}
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 24px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 285px !important; }
.main-row > #content {
    flex: 1 1 auto !important;
    min-width: 0 !important;
}
.main-row > #sidebar { flex: 0 0 255px !important; }
#contentindex5 {
    padding: 30px !important;
}
@media (max-width: 900px) {
    body.student-portal-page #container {
        width: calc(100% - 20px) !important;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $photo_value = isset($_SESSION['sphoto']) ? trim($_SESSION['sphoto']) : '';
    $photo_path = $photo_value !== '' ? htmlspecialchars($photo_value, ENT_QUOTES, 'UTF-8') : '../images/default.png';
    $pageView = isset($_GET['view']) ? trim((string) $_GET['view']) : '';
?>
<div id="container">
    <div id="header">
        <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menucdeo.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenucdeo.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
                <?php
                    if ($pageView === 'worked_fee') {
                        require("worked_fee_dashboard.php");
                    } else {
                        require("index.php");
                    }
                ?>
            </div>
        </div>

        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
                        echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$photo_path."'width=180px height=160px alt='CDE officer profile photo'></b>";
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
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
