<?php
session_start();
require_once(__DIR__ . '/../connection.php');

function departmentPopupH($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function departmentPopupSelected($currentValue, $optionValue)
{
    return (string) $currentValue === (string) $optionValue ? ' selected' : '';
}

$courseCode = trim((string) ($_GET['id'] ?? ''));
$course = null;
$assignment = [
    'uid' => '',
    'Iname' => '',
    'department' => '',
    'section' => '',
    'Student_class_year' => '',
    'semister' => ''
];
$departments = [];
$instructors = [];

if ($courseCode !== '') {
    $courseStmt = mysqli_prepare(
        $conn,
        "SELECT c.course_code, c.cname, c.department, c.chour, c.ayear,
                ai.uid, ai.Iname, ai.department AS assigned_department, ai.section,
                ai.Student_class_year, ai.semister
         FROM course AS c
         LEFT JOIN assign_instructor AS ai ON ai.corse_code = c.course_code
         WHERE c.course_code = ?
         LIMIT 1"
    );

    if ($courseStmt) {
        mysqli_stmt_bind_param($courseStmt, 's', $courseCode);
        mysqli_stmt_execute($courseStmt);
        $result = mysqli_stmt_get_result($courseStmt);
        $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
        mysqli_stmt_close($courseStmt);

        if ($row) {
            $course = [
                'course_code' => (string) ($row['course_code'] ?? ''),
                'cname' => (string) ($row['cname'] ?? ''),
                'department' => (string) ($row['department'] ?? ''),
                'chour' => (string) ($row['chour'] ?? ''),
                'ayear' => (string) ($row['ayear'] ?? '')
            ];
            $assignment = [
                'uid' => (string) ($row['uid'] ?? ''),
                'Iname' => (string) ($row['Iname'] ?? ''),
                'department' => (string) ($row['assigned_department'] ?? ''),
                'section' => (string) ($row['section'] ?? ''),
                'Student_class_year' => (string) ($row['Student_class_year'] ?? ''),
                'semister' => (string) ($row['semister'] ?? '')
            ];
        }
    }
}

$departmentResult = mysqli_query($conn, "SELECT DName FROM department ORDER BY DName ASC");
if ($departmentResult instanceof mysqli_result) {
    while ($departmentRow = mysqli_fetch_assoc($departmentResult)) {
        $departmentName = trim((string) ($departmentRow['DName'] ?? ''));
        if ($departmentName !== '') {
            $departments[] = $departmentName;
        }
    }
    mysqli_free_result($departmentResult);
}

$instructorResult = mysqli_query(
    $conn,
    "SELECT u.UID, u.fname, u.lname
     FROM user AS u
     INNER JOIN account AS a ON a.UID = u.UID
     WHERE a.Role = 'instructor'
     ORDER BY u.fname ASC, u.lname ASC"
);
if ($instructorResult instanceof mysqli_result) {
    while ($instructorRow = mysqli_fetch_assoc($instructorResult)) {
        $fullName = trim(
            (string) (($instructorRow['fname'] ?? '') . ' ' . ($instructorRow['lname'] ?? ''))
        );
        $instructors[] = [
            'uid' => (string) ($instructorRow['UID'] ?? ''),
            'name' => $fullName !== '' ? $fullName : (string) ($instructorRow['UID'] ?? '')
        ];
    }
    mysqli_free_result($instructorResult);
}

$selectedDepartment = $assignment['department'] !== '' ? $assignment['department'] : ($course['department'] ?? '');
$currentInstructor = $assignment['Iname'] !== '' ? $assignment['Iname'] : 'Not assigned yet';
$currentSection = $assignment['section'] !== '' ? $assignment['section'] : 'Not selected';
$currentClassYear = $assignment['Student_class_year'] !== '' ? $assignment['Student_class_year'] : 'Not selected';
$currentSemester = $assignment['semister'] !== '' ? $assignment['semister'] : 'Not selected';
$canSubmit = $course && $departments && $instructors;
?>
<style>
#facebox .popup {
    border: none;
    border-radius: 28px;
    box-shadow: 0 28px 72px rgba(15, 23, 42, 0.24);
}

#facebox .content {
    display: block;
    width: 760px;
    max-width: calc(100vw - 32px);
    padding: 0;
    border-radius: 28px;
    background: transparent;
    overflow: hidden;
}

#facebox .close {
    top: 16px;
    right: 16px;
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(148, 163, 184, 0.28);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
}

#facebox .close img {
    display: none;
}

#facebox .close::before {
    content: "x";
    color: #34506b;
    font-size: 24px;
    line-height: 1;
}

#facebox_overlay.facebox_overlayBG {
    background: rgba(15, 23, 42, 0.66);
    backdrop-filter: blur(4px);
}

.department-update-shell {
    width: 100%;
    font-family: Arial, Helvetica, sans-serif;
    color: #17324d;
}

.department-update-card {
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
}

.department-update-header {
    padding: 30px 30px 22px;
    background: linear-gradient(135deg, #0f3c68 0%, #1f6aa5 58%, #64a6d8 100%);
    color: #ffffff;
}

.department-update-eyebrow {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-update-header h2 {
    margin: 14px 0 10px;
    font-size: 28px;
    line-height: 1.2;
}

.department-update-header p {
    margin: 0;
    max-width: 620px;
    color: rgba(255, 255, 255, 0.88);
    font-size: 15px;
    line-height: 1.7;
}

.department-update-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
}

.department-update-chip {
    padding: 9px 14px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.16);
    font-size: 13px;
    font-weight: 700;
}

.department-update-body {
    padding: 28px 30px 30px;
}

.department-update-summary {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.department-update-summary-card {
    padding: 16px 18px;
    border: 1px solid #dbe7f2;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
}

.department-update-summary-label {
    color: #66809b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-update-summary-value {
    margin-top: 8px;
    color: #17324d;
    font-size: 16px;
    font-weight: 700;
    line-height: 1.5;
    word-break: break-word;
}

.department-update-form {
    display: grid;
    gap: 22px;
}

.department-update-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
}

.department-update-field {
    display: grid;
    gap: 8px;
}

.department-update-field.full {
    grid-column: 1 / -1;
}

.department-update-field label {
    color: #234766;
    font-size: 14px;
    font-weight: 700;
}

.department-update-field input,
.department-update-field select {
    width: 100%;
    min-height: 48px;
    padding: 0 15px;
    border: 1px solid #cfdceb;
    border-radius: 14px;
    background: #ffffff;
    box-sizing: border-box;
    color: #17324d;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.department-update-field input[readonly] {
    background: #f3f7fb;
    color: #617b95;
}

.department-update-field input:focus,
.department-update-field select:focus {
    outline: none;
    border-color: #2e78cb;
    box-shadow: 0 0 0 4px rgba(46, 120, 203, 0.12);
}

.department-update-help {
    color: #6a8197;
    font-size: 13px;
    line-height: 1.6;
}

.department-update-status {
    padding: 18px 20px;
    border-radius: 18px;
    border: 1px solid #f0d2d2;
    background: #fff5f5;
    color: #9a2828;
    font-size: 14px;
    font-weight: 700;
    line-height: 1.6;
}

.department-update-status.info {
    border-color: #d7e5f2;
    background: #f7fbff;
    color: #36516c;
}

.department-update-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 4px;
}

.department-update-actions button,
.department-update-actions input[type="reset"] {
    min-height: 48px;
    padding: 0 20px;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
}

.department-update-actions button {
    background: linear-gradient(135deg, #1f5fb6 0%, #2e84dd 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(31, 95, 182, 0.24);
}

.department-update-actions input[type="reset"] {
    background: #eaf1f7;
    color: #24425f;
}

.department-update-actions button:disabled,
.department-update-actions input[type="reset"]:disabled {
    cursor: not-allowed;
    opacity: 0.65;
    box-shadow: none;
}

@media (max-width: 760px) {
    #facebox .content {
        max-width: calc(100vw - 20px);
    }

    .department-update-header,
    .department-update-body {
        padding-left: 20px;
        padding-right: 20px;
    }

    .department-update-summary,
    .department-update-grid {
        grid-template-columns: 1fr;
    }

    .department-update-actions button,
    .department-update-actions input[type="reset"] {
        width: 100%;
    }
}
</style>

<div class="department-update-shell">
    <div class="department-update-card">
        <div class="department-update-header">
            <span class="department-update-eyebrow">Update Assignment</span>
            <h2>Instructor Assignment Details</h2>
            <p>Review the selected course and update the assigned instructor, section, class year, and semester using the same cleaner department popup style.</p>
            <?php if ($course) { ?>
            <div class="department-update-meta">
                <div class="department-update-chip">Course: <?php echo departmentPopupH($course['course_code']); ?></div>
                <div class="department-update-chip">Credit hour: <?php echo departmentPopupH($course['chour']); ?></div>
                <div class="department-update-chip">Academic year: <?php echo departmentPopupH($course['ayear']); ?></div>
            </div>
            <?php } ?>
        </div>

        <div class="department-update-body">
            <?php if (!$course) { ?>
            <div class="department-update-status">The selected course could not be found, so the update form could not be loaded.</div>
            <?php } else { ?>
            <div class="department-update-summary">
                <div class="department-update-summary-card">
                    <div class="department-update-summary-label">Current Instructor</div>
                    <div class="department-update-summary-value"><?php echo departmentPopupH($currentInstructor); ?></div>
                </div>
                <div class="department-update-summary-card">
                    <div class="department-update-summary-label">Current Department</div>
                    <div class="department-update-summary-value"><?php echo departmentPopupH($selectedDepartment !== '' ? $selectedDepartment : 'Not selected'); ?></div>
                </div>
                <div class="department-update-summary-card">
                    <div class="department-update-summary-label">Class Setup</div>
                    <div class="department-update-summary-value"><?php echo departmentPopupH($currentSection . ' / ' . $currentClassYear . ' / ' . $currentSemester); ?></div>
                </div>
            </div>

            <?php if (!$departments || !$instructors) { ?>
            <div class="department-update-status info">Some reference data is missing. Please make sure departments and instructor accounts are available before updating this assignment.</div>
            <?php } ?>

            <form action="assigninsu.php" method="post" class="department-update-form">
                <div class="department-update-grid">
                    <div class="department-update-field">
                        <label for="cc">Course Code</label>
                        <input type="text" id="cc" name="cc" value="<?php echo departmentPopupH($course['course_code']); ?>" readonly>
                    </div>

                    <div class="department-update-field">
                        <label for="cn">Course Name</label>
                        <input type="text" id="cn" name="cn" value="<?php echo departmentPopupH($course['cname']); ?>" readonly>
                    </div>

                    <div class="department-update-field">
                        <label for="dc">Department</label>
                        <select id="dc" name="dc" required>
                            <option value="">Select department</option>
                            <?php foreach ($departments as $departmentName) { ?>
                            <option value="<?php echo departmentPopupH($departmentName); ?>"<?php echo departmentPopupSelected($selectedDepartment, $departmentName); ?>>
                                <?php echo departmentPopupH($departmentName); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="department-update-field">
                        <label for="In">Instructor Name</label>
                        <select id="In" name="In" required>
                            <option value="">Select instructor</option>
                            <?php foreach ($instructors as $instructor) { ?>
                            <option value="<?php echo departmentPopupH($instructor['uid']); ?>"<?php echo departmentPopupSelected($assignment['uid'], $instructor['uid']); ?>>
                                <?php echo departmentPopupH($instructor['name']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="department-update-field">
                        <label for="sec">Section</label>
                        <select id="sec" name="sec" required>
                            <option value="">Select section</option>
                            <?php foreach (['A', 'B', 'C', 'D', 'E'] as $sectionOption) { ?>
                            <option value="<?php echo departmentPopupH($sectionOption); ?>"<?php echo departmentPopupSelected($assignment['section'], $sectionOption); ?>>
                                <?php echo departmentPopupH($sectionOption); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="department-update-field">
                        <label for="scy">Student Class Year</label>
                        <select id="scy" name="scy" required>
                            <option value="">Select class year</option>
                            <?php foreach (['1st', '2nd', '3rd', '4th', '5th'] as $classYearOption) { ?>
                            <option value="<?php echo departmentPopupH($classYearOption); ?>"<?php echo departmentPopupSelected($assignment['Student_class_year'], $classYearOption); ?>>
                                <?php echo departmentPopupH($classYearOption); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="department-update-field">
                        <label for="sem">Semester</label>
                        <select id="sem" name="sem" required>
                            <option value="">Select semester</option>
                            <?php foreach (['I', 'II'] as $semesterOption) { ?>
                            <option value="<?php echo departmentPopupH($semesterOption); ?>"<?php echo departmentPopupSelected($assignment['semister'], $semesterOption); ?>>
                                <?php echo departmentPopupH($semesterOption); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="department-update-field">
                        <label for="ch">Credit Hour</label>
                        <input type="text" id="ch" name="ch" value="<?php echo departmentPopupH($course['chour']); ?>" readonly>
                    </div>

                    <div class="department-update-field">
                        <label for="ay">Academic Year</label>
                        <input type="text" id="ay" name="ay" value="<?php echo departmentPopupH($course['ayear']); ?>" readonly>
                    </div>

                    <div class="department-update-field full">
                        <div class="department-update-help">The form keeps the same update action as before, but the popup is now spaced and styled to match the newer department pages.</div>
                    </div>
                </div>

                <div class="department-update-actions">
                    <button type="submit" name="assign" <?php echo $canSubmit ? '' : 'disabled'; ?>>Update Assignment</button>
                    <input type="reset" value="Reset Form" <?php echo $canSubmit ? '' : 'disabled'; ?>>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</div>
