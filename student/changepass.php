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
<script type="text/javascript" src="../javascript\date_time.js"></script>
<style>
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
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $photo_value = isset($_SESSION['sphoto']) ? trim($_SESSION['sphoto']) : '';
    $photo_path = $photo_value !== '' ? htmlspecialchars($photo_value, ENT_QUOTES, 'UTF-8') : '../images/default.png';
?>
<div id="container">

    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menustud.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenustud.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
<form action="uaccounta.php" method="POST"  onsubmit='return validate()'>
<table bgcolor="#f9fbf9" cellpadding="12" border="0">
<tr><td colspan="2" ><center><h1 style="color: #4b80b4"><b>Change Password
</b></h1></center></td></tr>
<tr><td>Old Password:</td><td><input type="password" id="password" name="opass" required="required"  placeholder="old_password" style="height: 30px;" /></td></tr>
<tr><td>New Password:</td><td><input type="password" id="password" name="npass"required="required"  placeholder="new_password" style="height: 30px;"/></td></tr>
 <tr><td>Confirm Password:</td><td><input type="password" id="password" name="rnpass" required="required"  placeholder="confirm_password" style="height: 30px;"/></td></tr>
 <tr><td><input type="submit" id="btn" name="submit" value="CHANGE"size="20" style="height: 30px;width: 100px;"></td><td>
<input type="reset" id="btn" name="validate" value="RESET"size="20" style="height: 30px;width: 150px;"></td></tr>
</table>
</form>

</div>
        </div>

        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
                    echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$photo_path."'width=180px height=160px alt='Student profile photo'></b>";
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
</body>
</html>
<?php
}
else
header("location:../index.php");
?>
