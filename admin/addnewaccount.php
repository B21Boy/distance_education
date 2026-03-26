<?php
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

function admin_account_modal_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$availableUsers = array();
$userResult = mysqli_query(
    $conn,
    'SELECT user.UID, user.fname, user.lname FROM user LEFT JOIN account ON account.UID = user.UID WHERE account.UID IS NULL ORDER BY user.UID ASC'
);
if ($userResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($userResult)) {
        $availableUsers[] = $row;
    }
    mysqli_free_result($userResult);
}
?>
<style>
.account-modal {
    width: min(700px, 92vw);
    padding: 24px;
    background: linear-gradient(180deg, #ffffff 0%, #f5f9fe 100%);
    border-radius: 18px;
    color: #173a5e;
    font-family: Arial, Helvetica, sans-serif;
}
.account-modal-badge {
    display: inline-block;
    margin-bottom: 10px;
    padding: 5px 10px;
    border-radius: 999px;
    background: #dceafb;
    color: #18466f;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.account-modal h2 {
    margin: 0;
    font-size: 28px;
    color: #12395f;
}
.account-modal-intro {
    margin: 10px 0 0;
    line-height: 1.6;
    color: #4b6783;
}
.account-modal-form {
    margin-top: 22px;
}
.account-modal-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}
.account-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.account-field-full {
    grid-column: 1 / -1;
}
.account-field label {
    font-size: 14px;
    font-weight: 700;
    color: #173a5e;
}
.account-field input,
.account-field select {
    width: 100%;
    min-height: 46px;
    border: 1px solid #c6d6e7;
    border-radius: 12px;
    padding: 0 14px;
    font-size: 15px;
    color: #173a5e;
    background: #ffffff;
    box-sizing: border-box;
}
.account-field input:focus,
.account-field select:focus {
    outline: none;
    border-color: #2d76bc;
    box-shadow: 0 0 0 4px rgba(45, 118, 188, 0.12);
}
.account-help-text {
    margin: 0;
    font-size: 12px;
    color: #617b94;
}
.account-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}
.account-modal-actions input {
    min-width: 140px;
    min-height: 44px;
    border: 0;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}
.account-submit-btn {
    background: #1f6fb2;
    color: #ffffff;
}
.account-reset-btn {
    background: #e9f0f8;
    color: #173a5e;
}
@media (max-width: 640px) {
    .account-modal {
        width: auto;
        padding: 18px;
    }
    .account-modal-grid {
        grid-template-columns: 1fr;
    }
    .account-modal-actions {
        flex-direction: column;
    }
    .account-modal-actions input {
        width: 100%;
    }
}
</style>
<div class="account-modal">
<span class="account-modal-badge">Admin</span>
<h2>Create Account</h2>
<p class="account-modal-intro">Select a user who does not have an account yet, assign the correct role, and create credentials that work with the current login system.</p>
<form action="insertaccount.php" method="post" name="form1" class="account-modal-form">
<div class="account-modal-grid">
<div class="account-field account-field-full">
<label for="uid">User ID</label>
<select name="uid" id="uid" required>
<option value="">Choose user ID</option>
<?php foreach ($availableUsers as $user) { ?>
<option value="<?php echo admin_account_modal_h($user['UID']); ?>"><?php echo admin_account_modal_h($user['UID']); ?> - <?php echo admin_account_modal_h(trim($user['fname'] . ' ' . $user['lname'])); ?></option>
<?php } ?>
</select>
<p class="account-help-text"><?php echo empty($availableUsers) ? 'All users already have accounts.' : 'Only users without an existing account are listed here.'; ?></p>
</div>
<div class="account-field">
<label for="un">UserName</label>
<input type="text" name="un" id="un" required maxlength="50" pattern="[A-Za-z0-9._-]{3,50}" placeholder="Enter username">
</div>
<div class="account-field">
<label for="pass">Password</label>
<input type="text" name="pass" id="pass" required minlength="4" maxlength="50" placeholder="Enter password">
</div>
<div class="account-field account-field-full">
<label for="role">Role</label>
<select name="role" id="role" required>
<option value="">Select role</option>
<option value="administrator">Administrator</option>
<option value="cdeofficer">CDE Officer</option>
<option value="registrar">Registrar</option>
<option value="collage_dean">College Dean</option>
<option value="department_head">Department Head</option>
<option value="instructor">Instructor</option>
<option value="financestaff">Finance Staff</option>
<option value="acadamic_vice_presidant">Academic Vice President</option>
</select>
</div>
</div>
<div class="account-modal-actions">
<input type="reset" class="account-reset-btn" value="Clear Form">
<input type="submit" class="account-submit-btn" name="submit" value="Create Account"<?php echo empty($availableUsers) ? ' disabled' : ''; ?>>
</div>
</form>
</div>
