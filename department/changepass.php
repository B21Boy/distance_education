<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$status = (string) ($_GET['status'] ?? '');
$messages = [
    'success' => 'Password changed successfully.',
    'empty' => 'All password fields are required.',
    'password-mismatch' => 'The new password and confirmation do not match.',
    'same-password' => 'The new password must be different from the old password.',
    'old-password' => 'The current password is incorrect.',
    'error' => 'The password could not be changed right now.'
];

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Change password",
    "Update your department account password from a cleaner form layout. Your new password must match the confirmation field."
);
echo departmentStatusBanner($status, $messages);
?>
<div class="department-section" style="max-width:760px;">
    <form action="uaccounta.php" method="POST" class="department-form-grid" onsubmit="return validateDepartmentPasswordForm();">
        <label class="department-form-field" for="opass">
            <span class="department-label">Current password</span>
            <input type="password" id="opass" name="opass" required>
        </label>
        <label class="department-form-field" for="npass">
            <span class="department-label">New password</span>
            <input type="password" id="npass" name="npass" required>
        </label>
        <label class="department-form-field" for="rnpass">
            <span class="department-label">Confirm new password</span>
            <input type="password" id="rnpass" name="rnpass" required>
        </label>
        <p class="department-form-note">Choose a new password that is different from your current one and make sure the confirmation matches exactly.</p>
        <div class="department-inline-actions">
            <button type="submit" name="submit" class="department-btn">Change password</button>
            <button type="reset" class="department-btn-secondary">Reset</button>
        </div>
    </form>
</div>
<script>
function validateDepartmentPasswordForm() {
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
departmentRenderPageEnd();
?>
