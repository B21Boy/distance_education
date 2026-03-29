<?php
include('../connection.php');
require("popup_styles.php");

$courseCode = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
$module = null;
$departments = array();

if ($courseCode !== '') {
    $stmt = mysqli_prepare($conn, "SELECT course_code, cname, department, chour, ayear, FileName FROM course WHERE course_code = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $courseCode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $module = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}

$departmentResult = mysqli_query($conn, "SELECT DName FROM department ORDER BY DName ASC");
if ($departmentResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($departmentResult)) {
        $departmentName = isset($row['DName']) ? trim((string) $row['DName']) : '';
        if ($departmentName !== '') {
            $departments[] = $departmentName;
        }
    }
    mysqli_free_result($departmentResult);
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Assign Upload</h1>
        <p class="cde-popup-copy">Assign the uploaded module to departments and student class years, then send the assignment update.</p>
    </div>
    <form action="editexecu.php" method="post" enctype="multipart/form-data" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="cc">
                Module Code
                <input type="text" name="cc" id="cc" class="cde-popup-input" readonly value="<?php echo htmlspecialchars((string) ($module['course_code'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="cn">
                Module Name
                <input type="text" name="cn" id="cn" class="cde-popup-input" readonly value="<?php echo htmlspecialchars((string) ($module['cname'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>

        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="combo">
                Selected Department
                <input name="combo" type="text" class="cde-popup-input" id="combo" required placeholder="Selected departments will appear here">
            </label>
            <label class="cde-popup-field" for="dc">
                Add Department
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <select name="dc" id="dc" class="cde-popup-select" style="flex:1 1 220px;">
                        <option value="">Select department</option>
                        <?php foreach ($departments as $departmentName) { ?>
                        <option value="<?php echo htmlspecialchars($departmentName, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($departmentName, ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                    <button name="button" type="button" class="cde-popup-btn-secondary" onclick="appendPopupValue('dc', 'combo')">Add</button>
                </div>
            </label>
        </div>

        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="combo1">
                Student Class Year
                <input name="combo1" type="text" class="cde-popup-input" id="combo1" required placeholder="Selected class years will appear here">
            </label>
            <label class="cde-popup-field" for="scy">
                Add Class Year
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <select name="scy" id="scy" class="cde-popup-select" style="flex:1 1 220px;">
                        <option value="">Select Student Class Year</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                    <button name="button" type="button" class="cde-popup-btn-secondary" onclick="appendPopupValue('scy', 'combo1')">Add</button>
                </div>
            </label>
        </div>

        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="sem">
                Semister
                <select name="sem" id="sem" class="cde-popup-select" required>
                    <option value="">Select Semister</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                </select>
            </label>
            <label class="cde-popup-field" for="ch">
                Creadit Hour
                <input type="text" name="ch" id="ch" class="cde-popup-input" readonly value="<?php echo htmlspecialchars((string) ($module['chour'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>

        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="ay">
                Acadamic Year
                <input type="text" name="ay" id="ay" class="cde-popup-input" readonly value="<?php echo htmlspecialchars((string) ($module['ayear'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="image">
                File
                <input type="file" name="image" id="image" class="cde-popup-input">
            </label>
        </div>

        <div class="cde-popup-actions">
            <button type="submit" value="Upload" class="cde-popup-btn" name="assign">Send</button>
            <button name="Reset" type="reset" class="cde-popup-btn-secondary">Reset</button>
        </div>
    </form>
</div>

<script>
function appendPopupValue(sourceId, targetId) {
    var source = document.getElementById(sourceId);
    var target = document.getElementById(targetId);
    if (!source || !target || !source.value) {
        return;
    }

    var selectedValue = source.value.trim();
    if (selectedValue === '') {
        return;
    }

    var currentValue = target.value.trim();
    var values = currentValue === '' ? [] : currentValue.split(',').map(function (item) {
        return item.trim();
    }).filter(function (item) {
        return item !== '';
    });

    if (values.indexOf(selectedValue) === -1) {
        values.push(selectedValue);
    }

    target.value = values.join(', ');
    source.value = '';
}
</script>
