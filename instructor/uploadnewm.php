<?php
session_start();
include('../connection.php');
require_once('page_helpers.php');

if (!instructorIsLoggedIn()) {
    header('location:../index.php');
    exit;
}

$userId = instructorCurrentUserId();
$courses = instructorFetchAssignedCourses($conn, $userId);
?>
<?php instructorRenderPopupStyles(); ?>
<div class="instructor-popup-shell">
    <h2 class="instructor-popup-title">Upload Prepared Module</h2>
    <p class="instructor-popup-subtitle">Choose an assigned module, confirm its details, and upload the prepared module file for the CDE officer.</p>
    <?php if ($courses) { ?>
        <div class="instructor-popup-card">
            <form action="editexec.php" method="post" enctype="multipart/form-data">
                <div class="instructor-popup-grid">
                    <div class="instructor-popup-field full">
                        <label for="module-course-code">Module Code</label>
                        <select name="cc" id="module-course-code" required>
                            <option value="">Choose Module Code</option>
                            <?php foreach ($courses as $course) { ?>
                                <option
                                    value="<?php echo instructorH($course['corse_code'] ?? ''); ?>"
                                    data-name="<?php echo instructorH($course['cname'] ?? ''); ?>"
                                    data-department="<?php echo instructorH($course['department'] ?? ''); ?>"
                                    data-year="<?php echo instructorH($course['ayear'] ?? ''); ?>"
                                >
                                    <?php echo instructorH($course['corse_code'] ?? ''); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="module-name">Module Name</label>
                        <input type="text" name="cn" id="module-name" required readonly>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="module-department">Department</label>
                        <input type="text" name="dc" id="module-department" required readonly>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="module-year">Academic Year</label>
                        <input type="text" name="ay" id="module-year" required readonly>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="module-file">Prepared Module File</label>
                        <input type="file" name="image" id="module-file" required>
                    </div>
                </div>
                <div class="instructor-popup-actions">
                    <button type="reset" class="instructor-popup-btn secondary" id="module-reset-btn">Reset</button>
                    <button type="submit" class="instructor-popup-btn" name="assign">Upload</button>
                </div>
            </form>
        </div>
        <script>
            (function() {
                var select = document.getElementById('module-course-code');
                var nameInput = document.getElementById('module-name');
                var departmentInput = document.getElementById('module-department');
                var yearInput = document.getElementById('module-year');
                var resetButton = document.getElementById('module-reset-btn');

                function syncFields() {
                    var option = select.options[select.selectedIndex];
                    if (!option || !option.value) {
                        nameInput.value = '';
                        departmentInput.value = '';
                        yearInput.value = '';
                        return;
                    }
                    nameInput.value = option.getAttribute('data-name') || '';
                    departmentInput.value = option.getAttribute('data-department') || '';
                    yearInput.value = option.getAttribute('data-year') || '';
                }

                select.addEventListener('change', syncFields);
                resetButton.addEventListener('click', function() {
                    window.setTimeout(syncFields, 0);
                });
                syncFields();
            })();
        </script>
    <?php } else { ?>
        <div class="instructor-popup-empty">No assigned course was found to prepare a module upload.</div>
    <?php } ?>
</div>