<?php
session_start();
require_once(__DIR__ . "/../connection.php");

$courseCode = trim((string) ($_GET['id'] ?? ''));
$departmentCode = isset($_SESSION['sdc']) ? trim((string) $_SESSION['sdc']) : '';
$course = null;
$departmentName = '';
$instructors = [];

if ($courseCode !== '') {
    $courseStmt = mysqli_prepare($conn, "SELECT course_code, cname, department, chour, ayear FROM course WHERE course_code = ? LIMIT 1");
    if ($courseStmt) {
        mysqli_stmt_bind_param($courseStmt, 's', $courseCode);
        mysqli_stmt_execute($courseStmt);
        mysqli_stmt_bind_result($courseStmt, $ccode, $cname, $courseDepartment, $chour, $ayear);
        if (mysqli_stmt_fetch($courseStmt)) {
            $course = [
                'course_code' => (string) $ccode,
                'cname' => (string) $cname,
                'department' => (string) $courseDepartment,
                'chour' => (string) $chour,
                'ayear' => (string) $ayear
            ];
            $departmentName = (string) $courseDepartment;
        }
        mysqli_stmt_close($courseStmt);
    }
}

if ($departmentCode === '' && $departmentName !== '') {
    $departmentStmt = mysqli_prepare($conn, "SELECT Dcode FROM department WHERE DName = ? LIMIT 1");
    if ($departmentStmt) {
        mysqli_stmt_bind_param($departmentStmt, 's', $departmentName);
        mysqli_stmt_execute($departmentStmt);
        mysqli_stmt_bind_result($departmentStmt, $resolvedDepartmentCode);
        if (mysqli_stmt_fetch($departmentStmt)) {
            $departmentCode = (string) $resolvedDepartmentCode;
        }
        mysqli_stmt_close($departmentStmt);
    }
}

if ($departmentName === '' && $departmentCode !== '') {
    $departmentStmt = mysqli_prepare($conn, "SELECT DName FROM department WHERE Dcode = ? LIMIT 1");
    if ($departmentStmt) {
        mysqli_stmt_bind_param($departmentStmt, 's', $departmentCode);
        mysqli_stmt_execute($departmentStmt);
        mysqli_stmt_bind_result($departmentStmt, $resolvedDepartmentName);
        if (mysqli_stmt_fetch($departmentStmt)) {
            $departmentName = (string) $resolvedDepartmentName;
        }
        mysqli_stmt_close($departmentStmt);
    }
}

if ($departmentCode !== '') {
    $instructorSql = "SELECT u.UID, u.fname, u.lname
                      FROM user u
                      INNER JOIN account a ON a.UID = u.UID
                      WHERE a.Role = 'instructor' AND u.d_code = ?
                      ORDER BY u.fname ASC, u.lname ASC";
    $instructorStmt = mysqli_prepare($conn, $instructorSql);
    if ($instructorStmt) {
        mysqli_stmt_bind_param($instructorStmt, 's', $departmentCode);
        mysqli_stmt_execute($instructorStmt);
        mysqli_stmt_bind_result($instructorStmt, $instructorUid, $instructorFname, $instructorLname);
        while (mysqli_stmt_fetch($instructorStmt)) {
            $instructors[] = [
                'UID' => (string) $instructorUid,
                'fname' => (string) $instructorFname,
                'lname' => (string) $instructorLname
            ];
        }
        mysqli_stmt_close($instructorStmt);
    }
}
?>
<style>
.department-popup-panel {
    width: min(100%, 720px);
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
.department-popup-header h2 {
    margin: 0;
    color: #163b60;
    font-size: 26px;
}
.department-popup-header p {
    margin: 8px 0 0;
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
.department-popup-field input[readonly] {
    background: #f3f7fb;
    color: #6c8196;
}
.department-popup-actions {
    display: flex;
    gap: 12px;
    margin-top: 18px;
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
.department-popup-empty {
    padding: 22px;
    color: #7f1d1d;
    font-weight: 700;
}
@media (max-width: 720px) {
    .department-popup-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="department-popup-panel">
    <div class="department-popup-card">
        <div class="department-popup-header">
            <h2>Assign Instructor</h2>
            <p>Select the instructor and class details for the registered course.</p>
        </div>
        <?php if (!$course) { ?>
        <div class="department-popup-empty">The selected course could not be found.</div>
        <?php } else { ?>
        <form action="assignins.php" method="post" class="department-popup-form">
            <div class="department-popup-grid">
                <div class="department-popup-field">
                    <label for="cc">Course Code</label>
                    <input type="text" id="cc" name="cc" value="<?php echo htmlspecialchars($course['course_code'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>
                <div class="department-popup-field">
                    <label for="cn">Course Name</label>
                    <input type="text" id="cn" name="cn" value="<?php echo htmlspecialchars($course['cname'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>
                <div class="department-popup-field">
                    <label for="dc">Department</label>
                    <input type="text" id="dc" name="dc" value="<?php echo htmlspecialchars($departmentName, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>
                <div class="department-popup-field">
                    <label for="In">Instructor</label>
                    <select id="In" name="In" required>
                        <option value="">Select instructor</option>
                        <?php foreach ($instructors as $instructor) { ?>
                        <option value="<?php echo htmlspecialchars((string) $instructor['UID'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars(trim((string) $instructor['fname'] . ' ' . $instructor['lname']), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="department-popup-field">
                    <label for="sec">Section</label>
                    <select id="sec" name="sec" required>
                        <option value="">Select section</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div class="department-popup-field">
                    <label for="scy">Student Class Year</label>
                    <select id="scy" name="scy" required>
                        <option value="">Select class year</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                    </select>
                </div>
                <div class="department-popup-field">
                    <label for="sem">Semester</label>
                    <select id="sem" name="sem" required>
                        <option value="">Select semester</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                    </select>
                </div>
                <div class="department-popup-field">
                    <label for="ch">Credit Hour</label>
                    <input type="text" id="ch" name="ch" value="<?php echo htmlspecialchars($course['chour'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>
                <div class="department-popup-field">
                    <label for="ay">Academic Year</label>
                    <input type="text" id="ay" name="ay" value="<?php echo htmlspecialchars($course['ayear'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>
            </div>
            <div class="department-popup-actions">
                <button type="submit" name="assign">Assign Instructor</button>
                <input type="reset" value="Reset">
            </div>
        </form>
        <?php } ?>
    </div>
</div>
