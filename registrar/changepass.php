<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$status = isset($_GET['status']) ? trim((string) $_GET['status']) : '';
$status_message = '';
$status_class = 'info';

if ($status === 'success') {
    $status_message = 'Your password was changed successfully.';
    $status_class = 'success';
} elseif ($status === 'empty') {
    $status_message = 'Please fill in all password fields.';
    $status_class = 'error';
} elseif ($status === 'old-password') {
    $status_message = 'The current password you entered is incorrect.';
    $status_class = 'error';
} elseif ($status === 'password-mismatch') {
    $status_message = 'The new password and confirmation password do not match.';
    $status_class = 'error';
} elseif ($status === 'same-password') {
    $status_message = 'Use a different new password from your current password.';
    $status_class = 'error';
} elseif ($status === 'error') {
    $status_message = 'The password could not be changed right now. Please try again.';
    $status_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Security</span>
                    <h1 class="registrar-page-title">Change Password</h1>
                    <p class="registrar-page-copy">Update your registrar account password and keep access to the system secure.</p>
                </div>
                <?php if ($status_message !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($status_class); ?>"><?php echo registrarH($status_message); ?></div>
                <?php endif; ?>
                <form action="uaccounta.php" method="post" class="registrar-form-grid">
                    <div class="registrar-form-field full">
                        <label class="registrar-label" for="changepass-old">Current Password</label>
                        <input type="password" id="changepass-old" name="opass" class="registrar-input" placeholder="Enter your current password" autocomplete="current-password" required>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="changepass-new">New Password</label>
                        <input type="password" id="changepass-new" name="npass" class="registrar-input" placeholder="Enter a new password" autocomplete="new-password" required>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="changepass-confirm">Confirm Password</label>
                        <input type="password" id="changepass-confirm" name="rnpass" class="registrar-input" placeholder="Re-enter the new password" autocomplete="new-password" required>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="submit" class="registrar-btn">Change Password</button>
                            <button type="reset" name="validate" class="registrar-btn-secondary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
