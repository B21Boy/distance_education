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
Instructor page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
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
.password-shell {
    display: grid;
    gap: 20px;
}
.password-card {
    max-width: 620px;
    margin: 12px auto;
    padding: 30px 32px;
    background: linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%);
    border: 1px solid #d9e3f0;
    border-radius: 18px;
    box-shadow: 0 16px 36px rgba(24, 58, 110, 0.10);
}
.password-title {
    margin: 0 0 10px;
    color: #163b67;
    font-size: 30px;
    line-height: 1.2;
}
.password-copy {
    margin: 0 0 24px;
    color: #5a6e86;
    font-size: 15px;
}
.password-grid {
    display: grid;
    gap: 18px;
}
.password-field {
    display: grid;
    gap: 8px;
}
.password-label {
    color: #17324d;
    font-size: 15px;
    font-weight: bold;
}
.password-input {
    width: 100%;
    height: 46px;
    padding: 0 14px;
    border: 1px solid #c7d5e5;
    border-radius: 12px;
    background: #fbfdff;
    color: #20354d;
    font-size: 15px;
    box-sizing: border-box;
}
.password-input:focus {
    outline: none;
    border-color: #2c74c9;
    box-shadow: 0 0 0 4px rgba(44, 116, 201, 0.12);
    background: #ffffff;
}
.password-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    padding-top: 4px;
}
.password-button {
    min-width: 150px;
    height: 46px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.18s ease, opacity 0.18s ease;
}
.password-button:hover {
    transform: translateY(-1px);
}
.password-button-primary {
    background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
    color: #ffffff;
}
.password-button-secondary {
    background: #e9eef5;
    color: #27415f;
    border: 1px solid #cdd8e7;
}
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
<?php
    require("header.php");
?>
    </div>
    <div id="menu">
<?php
    require("menuins.php");
?>
    </div>
    <div class="main-row">
        <div id="left">
<?php
     require("sidemenuins.php");
?>
        </div>
        <div id="content">
            <div id="contentindex5">
                <div class="password-shell">
                    <form action="uaccounta.php" method="POST" onsubmit='return validate()'>
                        <div class="password-card">
                            <h1 class="password-title">Change Password</h1>
                            <p class="password-copy">Update your current instructor account password using the form below.</p>
                            <div class="password-grid">
                                <div class="password-field">
                                    <label class="password-label" for="oldPassword">Old Password</label>
                                    <input class="password-input" type="password" id="oldPassword" name="opass" required="required" placeholder="old_password" />
                                </div>
                                <div class="password-field">
                                    <label class="password-label" for="newPassword">New Password</label>
                                    <input class="password-input" type="password" id="newPassword" name="npass" required="required" placeholder="new_password" />
                                </div>
                                <div class="password-field">
                                    <label class="password-label" for="confirmPassword">Confirm Password</label>
                                    <input class="password-input" type="password" id="confirmPassword" name="rnpass" required="required" placeholder="confirm_password" />
                                </div>
                                <div class="password-actions">
                                    <input class="password-button password-button-primary" type="submit" name="submit" value="CHANGE">
                                    <input class="password-button password-button-secondary" type="reset" name="validate" value="RESET">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$photo_path."'width=180px height=160px alt='Instructor profile photo'></b>";
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
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
<?php
include("../footer.php");
?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
