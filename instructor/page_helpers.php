<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once("../connection.php");
}

function instructorIsLoggedIn(): bool
{
    return isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole']);
}

function instructorCurrentUserId(): string
{
    return isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
}

function instructorCurrentPhotoPath(): string
{
    $photo = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
    return $photo !== '' ? $photo : '../images/default.png';
}

function instructorH($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function instructorFetchDistinctAssignedValues(mysqli $conn, string $column, string $userId): array
{
    $allowedColumns = ['department', 'Student_class_year', 'semister', 'section', 'corse_code'];
    if ($userId === '' || !in_array($column, $allowedColumns, true)) {
        return [];
    }

    $sql = "SELECT DISTINCT `$column` AS value FROM assign_instructor WHERE uid = ? AND `$column` <> '' ORDER BY `$column`";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $values = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $value = trim((string) ($row['value'] ?? ''));
            if ($value !== '') {
                $values[] = $value;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return array_values(array_unique($values));
}

function instructorFetchDepartmentCodes(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT DISTINCT d.Dcode AS value
            FROM assign_instructor ai
            INNER JOIN department d ON d.DName = ai.department
            WHERE ai.uid = ? AND d.Dcode <> ''
            ORDER BY d.Dcode";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $values = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $value = trim((string) ($row['value'] ?? ''));
            if ($value !== '') {
                $values[] = $value;
            }
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return array_values(array_unique($values));
}

function instructorFetchSubmittedAssignments(mysqli $conn, string $userId, string $department, string $classYear, string $semister, string $courseCode): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT DISTINCT a.U_ID, a.asno, a.ccode, a.cname, a.department, a.Student_class_year, a.semister, a.Submission_date, a.fileName
            FROM assignment a
            INNER JOIN assign_instructor ai
                ON ai.uid = ?
               AND ai.department = a.department
               AND ai.Student_class_year = a.Student_class_year
               AND ai.semister = a.semister
               AND ai.corse_code = a.ccode
            WHERE a.department = ? AND a.Student_class_year = ? AND a.semister = ? AND a.status = 'stud' AND a.ccode = ?
            ORDER BY a.Submission_date DESC, a.asno DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 'sssss', $userId, $department, $classYear, $semister, $courseCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function instructorFetchAssignmentUploads(mysqli $conn, string $department, string $classYear, string $semister): array
{
    $sql = "SELECT asno, ccode, cname, department, Student_class_year, semister, Submission_date, fileName
            FROM assignment
            WHERE department = ? AND Student_class_year = ? AND semister = ?
            ORDER BY Submission_date DESC, asno DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 'sss', $department, $classYear, $semister);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function instructorFetchAssignedCourses(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT ai.no, ai.corse_code, ai.cname, ai.Iname, ai.department, ai.section, ai.Student_class_year, ai.semister, c.chour, c.ayear
            FROM assign_instructor ai
            LEFT JOIN course c ON c.course_code = ai.corse_code
            WHERE ai.uid = ?
            ORDER BY ai.department, ai.corse_code, ai.section";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function instructorFetchUnreadMessages(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT m.M_ID, m.M_sender, m.message, m.date_sended, COALESCE(a.Role, m.M_sender) AS sender_label
            FROM message m
            LEFT JOIN account a ON a.UID = m.M_sender
            WHERE m.M_reciever = ? AND m.status = 'no'
            ORDER BY m.date_sended DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function instructorFetchModuleSchedules(mysqli $conn): array
{
    $result = mysqli_query($conn, "SELECT information FROM module_schedule");
    if (!$result instanceof mysqli_result) {
        return [];
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $information = trim((string) ($row['information'] ?? ''));
        if ($information !== '') {
            $rows[] = ['information' => $information];
        }
    }

    mysqli_free_result($result);
    return $rows;
}

function instructorFetchRejectedCourseResults(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return ['columns' => [], 'rows' => []];
    }

    $sql = "SELECT * FROM course_result WHERE status = 'not' AND uid = ? ORDER BY no DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return ['columns' => [], 'rows' => []];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $columns = [];
    $rows = [];
    if ($result instanceof mysqli_result) {
        foreach (mysqli_fetch_fields($result) as $field) {
            if ($field->name === 'status') {
                break;
            }
            $columns[] = $field->name;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return ['columns' => $columns, 'rows' => $rows];
}

function instructorRenderSidebar(string $photoPath): void
{
    ?>
    <div class="sidebar-panel profile-panel">
        <div class="sidebar-panel-title">User Profile</div>
        <div class="sidebar-panel-body">
            <div class="instructor-sidebar-welcome">
                <strong>Welcome:</strong>
                <span><?php echo instructorH(($_SESSION['sfn'] ?? '') . ' ' . ($_SESSION['sln'] ?? '')); ?></span>
            </div>
            <img src="<?php echo instructorH($photoPath); ?>" alt="Instructor profile photo">
            <div id="sidebarr">
                <ul>
                    <li><a href="#.html">Change Photo</a></li>
                    <li><a href="changepass.php">Change password</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sidebar-panel social-panel">
        <div class="sidebar-panel-title">Social Link</div>
        <div class="sidebar-panel-body">
            <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
            <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
            <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
            <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
        </div>
    </div>
    <?php
}

function instructorRenderPopupStyles(): void
{
    ?>
    <style>
    .instructor-popup-shell {
        width: min(100%, 620px);
        padding: 10px;
        font-family: Arial, Helvetica, sans-serif;
        color: #173a5e;
    }
    .instructor-popup-title {
        margin: 0 0 16px;
        color: #12395f;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
    }
    .instructor-popup-subtitle {
        margin: -8px 0 18px;
        color: #4a6480;
        font-size: 14px;
        line-height: 1.6;
        text-align: center;
    }
    .instructor-popup-card {
        border: 1px solid #dce6f2;
        border-radius: 16px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
        box-shadow: 0 18px 32px rgba(16, 46, 74, 0.08);
        padding: 20px;
    }
    .instructor-popup-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 16px;
    }
    .instructor-popup-field {
        display: grid;
        gap: 8px;
    }
    .instructor-popup-field.full {
        grid-column: 1 / -1;
    }
    .instructor-popup-field label {
        color: #163b60;
        font-size: 14px;
        font-weight: 700;
    }
    .instructor-popup-field input,
    .instructor-popup-field select,
    .instructor-popup-field textarea {
        width: 100%;
        min-height: 42px;
        padding: 0 14px;
        border: 1px solid #bfd0e2;
        border-radius: 10px;
        background: #f9fbfe;
        color: #173a5e;
        box-sizing: border-box;
    }
    .instructor-popup-field textarea {
        min-height: 120px;
        padding: 12px 14px;
    }
    .instructor-popup-field input[readonly] {
        background: #eef4fb;
    }
    .instructor-popup-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 18px;
        flex-wrap: wrap;
    }
    .instructor-popup-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 10px;
        background: #1f6fb2;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }
    .instructor-popup-btn.secondary {
        background: #edf4fb;
        color: #18466f;
    }
    .instructor-popup-empty {
        padding: 18px 20px;
        border-radius: 14px;
        background: #f8fbff;
        border: 1px dashed #bfd0e2;
        color: #48637f;
        text-align: center;
    }
    @media (max-width: 640px) {
        .instructor-popup-grid {
            grid-template-columns: 1fr;
        }
        .instructor-popup-actions {
            justify-content: stretch;
        }
        .instructor-popup-btn {
            width: 100%;
        }
    }
    </style>
    <?php
}
function instructorRenderIconScripts(): void
{
    ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php
}
function instructorBuildAssignedFilterRows(mysqli $conn, string $userId): array
{
    $courses = instructorFetchAssignedCourses($conn, $userId);
    $rows = [];
    $seen = [];

    foreach ($courses as $course) {
        $row = [
            'dpt' => trim((string) ($course['department'] ?? '')),
            'scy' => trim((string) ($course['Student_class_year'] ?? '')),
            'sem' => trim((string) ($course['semister'] ?? '')),
            'sec' => trim((string) ($course['section'] ?? '')),
            'cc' => trim((string) ($course['corse_code'] ?? '')),
        ];

        if ($row['dpt'] === '' && $row['scy'] === '' && $row['sem'] === '' && $row['sec'] === '' && $row['cc'] === '') {
            continue;
        }

        $key = implode('|', $row);
        if (isset($seen[$key])) {
            continue;
        }

        $seen[$key] = true;
        $rows[] = $row;
    }

    return $rows;
}

function instructorFilterValues(array $rows, string $key): array
{
    $values = [];
    foreach ($rows as $row) {
        $value = trim((string) ($row[$key] ?? ''));
        if ($value !== '') {
            $values[] = $value;
        }
    }

    $values = array_values(array_unique($values));
    sort($values, SORT_NATURAL | SORT_FLAG_CASE);
    return $values;
}

function instructorRenderAssignedFilterScript(string $formId, array $rows, array $fields): void
{
    $jsonRows = json_encode(array_values($rows), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $jsonFields = json_encode(array_values($fields), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    ?>
    <script>
    (function() {
        var form = document.getElementById(<?php echo json_encode($formId); ?>);
        if (!form) {
            return;
        }

        var rows = <?php echo $jsonRows ?: '[]'; ?>;
        var fields = <?php echo $jsonFields ?: '[]'; ?>;
        var selects = {};

        fields.forEach(function(name) {
            var field = form.querySelector('[name="' + name + '"]');
            if (!field) {
                return;
            }
            selects[name] = field;
            if (!field.dataset.placeholder) {
                field.dataset.placeholder = field.options.length ? field.options[0].text : 'Select an option';
            }
        });

        function previousFields(index) {
            return fields.slice(0, index);
        }

        function matchingRows(index) {
            return rows.filter(function(row) {
                return previousFields(index).every(function(fieldName) {
                    var field = selects[fieldName];
                    if (!field) {
                        return true;
                    }
                    var selectedValue = String(field.value || '').trim();
                    if (selectedValue === '') {
                        return true;
                    }
                    return String(row[fieldName] || '').trim() === selectedValue;
                });
            });
        }

        function fillSelect(name, index, preferredValue) {
            var field = selects[name];
            if (!field) {
                return;
            }

            var placeholder = field.dataset.placeholder || 'Select an option';
            var values = [];
            var seen = {};

            matchingRows(index).forEach(function(row) {
                var value = String(row[name] || '').trim();
                if (value === '' || seen[value]) {
                    return;
                }
                seen[value] = true;
                values.push(value);
            });

            field.innerHTML = '';
            var option = document.createElement('option');
            option.value = '';
            option.textContent = placeholder;
            field.appendChild(option);

            values.forEach(function(value) {
                var item = document.createElement('option');
                item.value = value;
                item.textContent = value;
                field.appendChild(item);
            });

            field.disabled = values.length === 0;
            if (preferredValue && values.indexOf(preferredValue) !== -1) {
                field.value = preferredValue;
            } else {
                field.value = '';
            }
        }

        var initialValues = {};
        fields.forEach(function(name) {
            var field = selects[name];
            initialValues[name] = field ? String(field.dataset.selected || field.value || '').trim() : '';
        });

        fields.forEach(function(name, index) {
            fillSelect(name, index, initialValues[name]);
        });

        fields.forEach(function(name, index) {
            var field = selects[name];
            if (!field) {
                return;
            }

            field.addEventListener('change', function() {
                for (var i = index + 1; i < fields.length; i += 1) {
                    var nextName = fields[i];
                    if (!selects[nextName]) {
                        continue;
                    }
                    selects[nextName].dataset.selected = '';
                    fillSelect(nextName, i, '');
                }
            });
        });
    })();
    </script>
    <?php
}
