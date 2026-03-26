<?php
include_once(__DIR__ . '/../connection.php');

if (!($conn instanceof mysqli)) {
    die('Database connection failed or not available.');
}

function admin_modal_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$colleges = array();
$departments = array();

$collegeResult = mysqli_query($conn, 'SELECT Ccode, cname FROM collage ORDER BY cname ASC');
if ($collegeResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($collegeResult)) {
        $colleges[] = $row;
    }
    mysqli_free_result($collegeResult);
}

$departmentResult = mysqli_query($conn, 'SELECT Dcode, DName, Ccode FROM department ORDER BY DName ASC');
if ($departmentResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($departmentResult)) {
        $departments[] = $row;
    }
    mysqli_free_result($departmentResult);
}
?>
<style>
.admin-modal {
    width: min(720px, 92vw);
    padding: 24px;
    background: linear-gradient(180deg, #ffffff 0%, #f5f9fe 100%);
    border-radius: 18px;
    color: #173a5e;
    font-family: Arial, Helvetica, sans-serif;
}
.admin-modal-badge {
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
.admin-modal h2 {
    margin: 0;
    font-size: 28px;
    color: #12395f;
}
.admin-modal-intro {
    margin: 10px 0 0;
    line-height: 1.6;
    color: #4b6783;
}
.admin-modal-form {
    margin-top: 22px;
}
.admin-modal-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}
.admin-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.admin-field-full {
    grid-column: 1 / -1;
}
.admin-field label {
    font-size: 14px;
    font-weight: 700;
    color: #173a5e;
}
.admin-field input,
.admin-field select {
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
.admin-field input:focus,
.admin-field select:focus {
    outline: none;
    border-color: #2d76bc;
    box-shadow: 0 0 0 4px rgba(45, 118, 188, 0.12);
}
.admin-help-text {
    margin: 0;
    font-size: 12px;
    color: #617b94;
}
.admin-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}
.admin-modal-actions input {
    min-width: 140px;
    min-height: 44px;
    border: 0;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}
.admin-submit-btn {
    background: #1f6fb2;
    color: #ffffff;
}
.admin-reset-btn {
    background: #e9f0f8;
    color: #173a5e;
}
@media (max-width: 640px) {
    .admin-modal {
        width: auto;
        padding: 18px;
    }
    .admin-modal-grid {
        grid-template-columns: 1fr;
    }
    .admin-modal-actions {
        flex-direction: column;
    }
    .admin-modal-actions input {
        width: 100%;
    }
}
</style>
<script type="text/javascript">
(function () {
    function initAdminUserModal() {
        var roleField = document.getElementById('roleField');
        var collegeGroup = document.getElementById('collegeGroup');
        var departmentGroup = document.getElementById('departmentGroup');
        var collegeField = document.getElementById('collegeField');
        var departmentField = document.getElementById('departmentField');

        if (!roleField || !collegeGroup || !departmentGroup || !collegeField || !departmentField) {
            return;
        }

        function filterDepartments() {
            var selectedCollege = collegeField.value;
            var options = departmentField.querySelectorAll('option[data-college]');

            options.forEach(function (option) {
                var shouldShow = !selectedCollege || option.getAttribute('data-college') === selectedCollege;
                option.hidden = !shouldShow;
                option.disabled = !shouldShow;
            });

            if (departmentField.selectedOptions.length > 0 && departmentField.selectedOptions[0].disabled) {
                departmentField.value = '';
            }
        }

        function toggleRoleFields() {
            var role = roleField.value;
            var needsCollege = role === 'collage_dean' || role === 'department_head' || role === 'instructor';
            var needsDepartment = role === 'department_head' || role === 'instructor';

            collegeGroup.hidden = !needsCollege;
            departmentGroup.hidden = !needsDepartment;
            collegeField.required = needsCollege;
            departmentField.required = needsDepartment;

            if (!needsCollege) {
                collegeField.value = '';
            }
            if (!needsDepartment) {
                departmentField.value = '';
            }

            filterDepartments();
        }

        roleField.addEventListener('change', toggleRoleFields);
        collegeField.addEventListener('change', filterDepartments);
        toggleRoleFields();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminUserModal);
    } else {
        initAdminUserModal();
    }
})();
</script>
<div class="admin-modal">
<span class="admin-modal-badge">Admin</span>
<h2>Add New User</h2>
<p class="admin-modal-intro">Create a user record with the correct college and department mapping so the admin CRUD flow stores data cleanly in MySQL.</p>
<form action="insertuser.php" method="post" name="form1" class="admin-modal-form" enctype="multipart/form-data">
<div class="admin-modal-grid">
<div class="admin-field">
<label for="uid">User ID</label>
<input type="text" name="uid" id="uid" required maxlength="20" pattern="[A-Za-z0-9]{2,20}" placeholder="Enter user ID">
<p class="admin-help-text">Use letters and numbers only.</p>
</div>
<div class="admin-field">
<label for="roleField">User Type</label>
<select name="ct" id="roleField" required>
<option value="">Select user type</option>
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
<div class="admin-field">
<label for="fname">First Name</label>
<input type="text" name="fname" id="fname" required maxlength="30" pattern="[A-Za-z ]{2,30}" placeholder="First name">
</div>
<div class="admin-field">
<label for="lname">Last Name</label>
<input type="text" name="lname" id="lname" required maxlength="30" pattern="[A-Za-z ]{2,30}" placeholder="Last name">
</div>
<div class="admin-field">
<label for="sex">Sex</label>
<select name="sex" id="sex" required>
<option value="">Select sex</option>
<option value="male">Male</option>
<option value="female">Female</option>
</select>
</div>
<div class="admin-field">
<label for="email">Email</label>
<input type="email" name="email" id="email" required maxlength="50" placeholder="Enter email address">
</div>
<div class="admin-field">
<label for="phone">Phone</label>
<input type="text" name="phone" id="phone" value="+251" required maxlength="14" pattern="[0-9+]{10,14}" placeholder="Enter phone number">
</div>
<div class="admin-field">
<label for="loc">Location</label>
<input type="text" name="loc" id="loc" required maxlength="50" pattern="[A-Za-z0-9 .,-]{2,50}" placeholder="Office or building">
</div>
<div class="admin-field" id="collegeGroup" hidden>
<label for="collegeField">College</label>
<select name="ac" id="collegeField">
<option value="">Choose college</option>
<?php foreach ($colleges as $college) { ?>
<option value="<?php echo admin_modal_h($college['Ccode']); ?>"><?php echo admin_modal_h($college['cname']); ?> (<?php echo admin_modal_h($college['Ccode']); ?>)</option>
<?php } ?>
</select>
</div>
<div class="admin-field" id="departmentGroup" hidden>
<label for="departmentField">Department</label>
<select name="dc" id="departmentField">
<option value="">Choose department</option>
<?php foreach ($departments as $department) { ?>
<option value="<?php echo admin_modal_h($department['Dcode']); ?>" data-college="<?php echo admin_modal_h($department['Ccode']); ?>"><?php echo admin_modal_h($department['DName']); ?> (<?php echo admin_modal_h($department['Dcode']); ?>)</option>
<?php } ?>
</select>
</div>
<div class="admin-field admin-field-full">
<label for="photo">User Photo</label>
<input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
<p class="admin-help-text">Optional. If you skip this, the default profile image will be used.</p>
</div>
</div>
<div class="admin-modal-actions">
<input type="reset" class="admin-reset-btn" value="Clear Form">
<input type="submit" class="admin-submit-btn" name="submit" value="Register User">
</div>
</form>
</div>
