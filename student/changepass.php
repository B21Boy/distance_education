<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$status = trim((string) ($_GET['status'] ?? ''));
$statusMessages = array(
    'success' => array('class' => 'success', 'message' => 'Password changed successfully.'),
    'empty' => array('class' => 'error', 'message' => 'All password fields are required.'),
    'mismatch' => array('class' => 'error', 'message' => 'The new password and confirmation password did not match.'),
    'reuse' => array('class' => 'error', 'message' => 'The old password cannot be reused as the new password.'),
    'incorrect' => array('class' => 'error', 'message' => 'The old password is incorrect.'),
    'missing' => array('class' => 'error', 'message' => 'The student account record could not be found.'),
    'db' => array('class' => 'error', 'message' => 'The password update could not be completed right now.'),
    'short' => array('class' => 'info', 'message' => 'Use a stronger password with at least 6 characters.')
);

studentRenderPageStart(
    "Change password",
    "Profile Settings",
    "Change Account Password",
    "Update your student account password here. The current password must match the account record before the new password is saved."
);
?>
<?php if (isset($statusMessages[$status])) { ?>
    <div class="student-status-banner <?php echo studentH($statusMessages[$status]['class']); ?>">
        <?php echo studentH($statusMessages[$status]['message']); ?>
    </div>
<?php } ?>

<fieldset>
    <legend>Password Form</legend>
    <form action="uaccounta.php" method="post" class="student-form-grid two-col">
        <div class="student-form-field full">
            <label class="student-label" for="student-old-password">Old Password</label>
            <input type="password" id="student-old-password" name="opass" required autocomplete="current-password">
        </div>
        <div class="student-form-field">
            <label class="student-label" for="student-new-password">New Password</label>
            <input type="password" id="student-new-password" name="npass" required minlength="6" autocomplete="new-password">
        </div>
        <div class="student-form-field">
            <label class="student-label" for="student-confirm-password">Confirm New Password</label>
            <input type="password" id="student-confirm-password" name="rnpass" required minlength="6" autocomplete="new-password">
        </div>
        <div class="student-form-field full">
            <p class="student-form-note">Pick a password you do not already use for this account. For a safer login, avoid very short or obvious passwords.</p>
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="submit" name="submit" value="Change Password">
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="reset" value="Reset Form">
        </div>
    </form>
</fieldset>
<?php
studentRenderPageEnd();
?>
