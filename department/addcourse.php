<?php
session_start();
require_once(__DIR__ . "/../connection.php");

$departmentCode = isset($_SESSION['sdc']) ? trim((string) $_SESSION['sdc']) : '';
$departmentName = '';

if ($departmentCode !== '') {
    $stmt = mysqli_prepare($conn, "SELECT DName FROM department WHERE Dcode = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $departmentCode);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $departmentNameResult);
        if (mysqli_stmt_fetch($stmt)) {
            $departmentName = trim((string) $departmentNameResult);
        }
        mysqli_stmt_close($stmt);
    }
}

$departmentValue = $departmentName !== '' ? $departmentName : $departmentCode;
$startYear = 2010;
$endYear = max((int) date('Y') + 5, $startYear);
?>
<style>
.department-popup-panel {
    width: min(100%, 680px);
    padding: 14px;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}
.department-popup-card {
    border: 1px solid #d6e3ef;
    border-radius: 18px;
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
    box-shadow: 0 18px 34px rgba(18, 53, 94, 0.10);
    overflow: hidden;
}
.department-popup-header {
    padding: 18px 22px 10px;
    border-bottom: 1px solid #e1ebf5;
}
.department-popup-kicker {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 999px;
    background: #deebfb;
    color: #1b588a;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.department-popup-header h2 {
    margin: 12px 0 6px;
    color: #163b60;
    font-size: 27px;
    line-height: 1.15;
}
.department-popup-header p {
    margin: 0;
    color: #53708a;
    font-size: 14px;
    line-height: 1.6;
}
.department-popup-form {
    padding: 22px;
}
.department-popup-grid {
    display: grid;
    gap: 16px;
}
.department-popup-grid.two-col {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
.department-popup-field {
    display: grid;
    gap: 8px;
}
.department-popup-field.full {
    grid-column: 1 / -1;
}
.department-popup-field label {
    color: #1a4268;
    font-size: 14px;
    font-weight: 700;
}
.department-popup-field input,
.department-popup-field select {
    width: 100%;
    min-height: 46px;
    padding: 0 14px;
    border: 1px solid #cddcec;
    border-radius: 12px;
    background: #ffffff;
    box-sizing: border-box;
    color: #17364e;
    font-size: 14px;
}
.department-popup-note {
    margin: 2px 0 0;
    color: #5a738c;
    font-size: 13px;
    line-height: 1.5;
}
.department-popup-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 4px;
}
.department-popup-actions button,
.department-popup-actions input[type="reset"] {
    min-height: 44px;
    padding: 0 18px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
}
.department-popup-actions button {
    background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
    color: #ffffff;
}
.department-popup-actions input[type="reset"] {
    background: #eaf0f6;
    color: #294663;
}
@media (max-width: 720px) {
    .department-popup-panel {
        padding: 6px;
    }
    .department-popup-form {
        padding: 18px;
    }
    .department-popup-grid.two-col {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="department-popup-panel">
    <div class="department-popup-card">
        <div class="department-popup-header">
            <span class="department-popup-kicker">Department</span>
            <h2>Add Course</h2>
            <p>Register a new course for this department from a cleaner popup form.</p>
        </div>
        <form action="addcours.php" method="post" class="department-popup-form">
            <div class="department-popup-grid two-col">
                <div class="department-popup-field">
                    <label for="cd">Course Code</label>
                    <input type="text" name="cd" id="cd" required placeholder="Enter course code" pattern="[A-Za-z0-9-]+" title="Use letters, numbers, or hyphen only.">
                </div>
                <div class="department-popup-field">
                    <label for="ch">Credit Hour</label>
                    <input type="number" name="ch" id="ch" required min="1" step="1" placeholder="Enter credit hour">
                </div>
                <div class="department-popup-field full">
                    <label for="cn">Course Title</label>
                    <input type="text" name="cn" id="cn" required placeholder="Enter course title">
                </div>
                <div class="department-popup-field">
                    <label for="dc">Department</label>
                    <input type="text" name="dc" id="dc" value="<?php echo htmlspecialchars($departmentValue, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="Enter department name">
                </div>
                <div class="department-popup-field">
                    <label for="ayear">Academic Year</label>
                    <select name="ayear" id="ayear" required>
                        <option value="">Select academic year</option>
                        <?php for ($year = $startYear; $year <= $endYear; $year++) { ?>
                        <option value="<?php echo htmlspecialchars((string) $year, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars((string) $year, ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <p class="department-popup-note">All fields are required. The department field now auto-fills when available, and you can edit it if needed before saving.</p>
            <div class="department-popup-actions">
                <button type="submit" name="submit">Save Course</button>
                <input type="reset" value="Clear">
            </div>
        </form>
    </div>
</div>
