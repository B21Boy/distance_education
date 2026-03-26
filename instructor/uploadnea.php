<?php
session_start();
include('../connection.php');
require_once('page_helpers.php');

if (!instructorIsLoggedIn()) {
    header('location:../index.php');
    exit;
}

$courseCode = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
?>
<?php instructorRenderPopupStyles(); ?>
<div class="instructor-popup-shell">
    <h2 class="instructor-popup-title">Upload Module File</h2>
    <p class="instructor-popup-subtitle">Upload or replace the prepared module file for the selected course.</p>
    <?php if ($courseCode !== '') { ?>
        <div class="instructor-popup-card">
            <form action="bbbbbb.php" method="post" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?php echo instructorH($courseCode); ?>">
                <div class="instructor-popup-grid">
                    <div class="instructor-popup-field full">
                        <label for="module-course-id">Course Code</label>
                        <input type="text" id="module-course-id" value="<?php echo instructorH($courseCode); ?>" readonly>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="module-upload-file">Module File</label>
                        <input type="file" name="image" id="module-upload-file" required>
                    </div>
                </div>
                <div class="instructor-popup-actions">
                    <button type="reset" class="instructor-popup-btn secondary">Reset</button>
                    <button type="submit" name="Submit" class="instructor-popup-btn">Upload</button>
                </div>
            </form>
        </div>
    <?php } else { ?>
        <div class="instructor-popup-empty">The selected course code is missing.</div>
    <?php } ?>
</div>