<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$photoValue = departmentCurrentPhotoPath();
$status = (string) ($_GET['status'] ?? '');
$messages = [
    'success' => 'Profile photo updated successfully.',
    'invalid-type' => 'Upload a JPG, PNG, GIF, or WEBP image only.',
    'too-large' => 'The selected image is too large. Maximum size is 2MB.',
    'upload' => 'The image could not be uploaded.',
    'error' => 'The profile photo could not be updated right now.'
];

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Update profile photo",
    "Upload a new account photo to refresh the image shown in your department profile card across the system."
);
echo departmentStatusBanner($status, $messages);
?>
<div class="department-card-grid" style="grid-template-columns:minmax(240px,320px) minmax(0,1fr);">
    <div class="department-card" style="text-align:center;">
        <img src="<?php echo departmentH($photoValue); ?>" alt="Current profile photo" class="profile-thumb" style="width:min(240px, 100%);height:auto;aspect-ratio:1/1;">
        <p style="margin-top:14px;">Your current profile photo appears here. Upload a new image to replace it.</p>
    </div>
    <div class="department-section">
        <form action="updatephoto.php" method="POST" enctype="multipart/form-data" class="department-form-grid">
            <label class="department-form-field" for="photo">
                <span class="department-label">Choose new photo</span>
                <input type="file" id="photo" name="photo" required>
            </label>
            <p class="department-form-note">JPG, PNG, GIF, and WEBP images up to 2MB are supported.</p>
            <div class="department-inline-actions">
                <button type="submit" name="submit" class="department-btn">Change photo</button>
                <button type="reset" class="department-btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php
departmentRenderPageEnd();
?>
