<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$status = trim((string) ($_GET['status'] ?? ''));
$statusMessages = array(
    'success' => array('class' => 'success', 'message' => 'Your profile photo was updated successfully.'),
    'invalid' => array('class' => 'error', 'message' => 'Please upload a valid JPG, PNG, GIF, or WEBP image under 2 MB.'),
    'failed' => array('class' => 'error', 'message' => 'The profile photo could not be updated. Please try again.'),
    'missing' => array('class' => 'info', 'message' => 'Choose an image file before submitting the form.')
);

$currentPhoto = studentCurrentPhotoPath();

studentRenderPageStart(
    "Update profile photo",
    "Profile Settings",
    "Change Profile Photo",
    "Upload a new profile image for your student account. The image is stored in the student photo folder and the account photo path is updated in the database."
);
?>
<?php if (isset($statusMessages[$status])) { ?>
    <div class="student-status-banner <?php echo studentH($statusMessages[$status]['class']); ?>">
        <?php echo studentH($statusMessages[$status]['message']); ?>
    </div>
<?php } ?>

<div class="student-inline-card-grid">
    <div class="student-inline-card">
        <h3>Current Photo</h3>
        <div class="student-sidebar-profile" style="margin-bottom:0;">
            <img src="<?php echo studentH($currentPhoto); ?>" alt="Current student profile photo" class="profile-thumb">
            <p class="student-form-note">Recommended formats: JPG, PNG, GIF, or WEBP. Maximum size: 2 MB.</p>
        </div>
    </div>
</div>

<fieldset>
    <legend>Upload New Photo</legend>
    <form action="updatephoto.php" method="post" enctype="multipart/form-data" class="student-form-grid two-col">
        <div class="student-form-field full">
            <label class="student-label" for="student-photo-upload">Profile Photo</label>
            <input type="file" id="student-photo-upload" name="photo" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp" required>
            <p class="student-form-note">Use a clear image so your student profile remains identifiable across the portal.</p>
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="submit" name="submit" value="Update Photo">
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
