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
.change-pass-shell {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
}

.change-pass-panel {
    max-width: 760px;
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    padding: 22px;
}

.change-pass-form {
    display: grid;
    gap: 16px;
}

.change-pass-field {
    display: grid;
    gap: 8px;
    color: #173a5e;
    font-weight: 700;
}

.change-pass-hint {
    margin: 0;
    color: #4a6480;
    line-height: 1.6;
}

.change-pass-status {
    margin-bottom: 16px;
    padding: 14px 16px;
    border-radius: 12px;
    font-weight: 700;
}

.change-pass-status.is-success {
    background: #e8f7ea;
    border: 1px solid #7ecb87;
    color: #1b5e20;
}

.change-pass-status.is-error {
    background: #fdeaea;
    border: 1px solid #e38b8b;
    color: #8a1f1f;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $statusType = (string) ($_GET['type'] ?? '');
    $statusMessage = (string) ($_GET['message'] ?? '');
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
	<div id="contentindex5">
<div class="change-pass-shell">
    <div class="admin-page-header">
        <div>
            <span class="admin-page-kicker">CDE Officer</span>
            <h1 class="admin-page-title">Change Password</h1>
            <p class="admin-page-copy">Update your login password from a cleaner form layout. Your new password must match the confirmation field.</p>
        </div>
    </div>
    <div class="change-pass-panel">
        <?php if ($statusMessage !== '') { ?>
        <div class="change-pass-status <?php echo $statusType === 'success' ? 'is-success' : 'is-error'; ?>">
            <?php echo htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php } ?>
        <form action="uaccounta.php" method="POST" class="change-pass-form" onsubmit="return validatePasswordForm();">
            <label class="change-pass-field" for="opass">
                Current Password
                <input type="password" id="opass" name="opass" class="admin-page-input" required>
            </label>
            <label class="change-pass-field" for="npass">
                New Password
                <input type="password" id="npass" name="npass" class="admin-page-input" required>
            </label>
            <label class="change-pass-field" for="rnpass">
                Confirm New Password
                <input type="password" id="rnpass" name="rnpass" class="admin-page-input" required>
            </label>
            <p class="change-pass-hint">Choose a new password that is different from your current one and make sure the confirmation matches exactly.</p>
            <div class="admin-page-form-row">
                <button type="submit" name="submit" class="admin-page-btn">Change Password</button>
                <button type="reset" class="admin-page-btn-secondary">Reset</button>
            </div>
        </form>
    </div>
</div>

</div></div>
	 <div id="sidebar">
<?php
    require("officer_sidebar.php");
?>
	 </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>
<script>
function validatePasswordForm() {
    var currentPassword = document.getElementById('opass').value;
    var newPassword = document.getElementById('npass').value;
    var confirmPassword = document.getElementById('rnpass').value;
    if (currentPassword.trim() === '' || newPassword.trim() === '' || confirmPassword.trim() === '') {
        alert('All password fields are required.');
        return false;
    }
    if (newPassword !== confirmPassword) {
        alert('New password and confirmation do not match.');
        return false;
    }
    if (currentPassword === newPassword) {
        alert('The new password must be different from the old password.');
        return false;
    }
    return true;
}
</script>
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
