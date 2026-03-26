<?php
session_start();
include('../connection.php');
require_once('page_helpers.php');

if (!instructorIsLoggedIn()) {
    header('location:../index.php');
    exit;
}

$assignmentId = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
$course = null;

if ($assignmentId !== '') {
    $sql = "SELECT no, corse_code, cname, Iname, department, section, Student_class_year, semister, chour, ayear FROM assign_instructor WHERE no = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $assignmentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            $course = mysqli_fetch_assoc($result) ?: null;
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<script src="js/validation.js" type="text/javascript"></script>
<?php instructorRenderPopupStyles(); ?>
<div class="instructor-popup-shell">
    <h2 class="instructor-popup-title">Upload Assignment</h2>
    <p class="instructor-popup-subtitle">Complete the course assignment details below and upload the student assignment file.</p>
    <?php if ($course) { ?>
        <div class="instructor-popup-card">
            <form action="assignment.php" method="post" enctype="multipart/form-data" onsubmit="return validate(this);">
                <div class="instructor-popup-grid">
                    <div class="instructor-popup-field">
                        <label for="popup-uid">User ID</label>
                        <input type="text" name="uid" id="popup-uid" readonly value="<?php echo instructorH($_SESSION['suid'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-asno">Assignment No</label>
                        <input type="text" name="asno" id="popup-asno" required placeholder="Assignment no">
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-asv">Assignment Value</label>
                        <input type="text" name="asv" id="popup-asv" required placeholder="Assignment value">
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-cc">Course Code</label>
                        <input type="text" name="cc" id="popup-cc" readonly value="<?php echo instructorH($course['corse_code'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="popup-cn">Course Name</label>
                        <input type="text" name="cn" id="popup-cn" readonly value="<?php echo instructorH($course['cname'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-dc">Department</label>
                        <input type="text" name="dc" id="popup-dc" readonly value="<?php echo instructorH($course['department'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-scy">Student Class Year</label>
                        <input type="text" name="scy" id="popup-scy" readonly value="<?php echo instructorH($course['Student_class_year'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-sem">Semister</label>
                        <input type="text" name="sem" id="popup-sem" readonly value="<?php echo instructorH($course['semister'] ?? ''); ?>" required>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-date">Submission Date</label>
                        <input type="date" name="date" id="popup-date" required>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="popup-file">File</label>
                        <input type="file" name="file" id="popup-file" required>
                    </div>
                </div>
                <div class="instructor-popup-actions">
                    <button type="reset" class="instructor-popup-btn secondary">Clear</button>
                    <button type="submit" name="submit" class="instructor-popup-btn">Upload</button>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            if (typeof LiveValidation !== 'undefined') {
                var assignmentValueValidation = new LiveValidation('popup-asv');
                assignmentValueValidation.add(Validate.Presence, { failureMessage: ' Please Enter Assignment value' });
                assignmentValueValidation.add(Validate.Format, { pattern: /^[0-9()%]+$/, failureMessage: ' It allows only Number' });
            }
        </script>
    <?php } else { ?>
        <div class="instructor-popup-empty">The selected course could not be loaded for upload.</div>
    <?php } ?>
</div>