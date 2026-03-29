<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$department = studentSessionValue('sdpt');
$selectedYear = '';
$selectedSemester = '';
$modules = array();
$searchPerformed = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchPerformed = true;
    $selectedYear = trim((string) ($_POST['scy'] ?? ''));
    $selectedSemester = trim((string) ($_POST['sem'] ?? ''));

    if ($department !== '' && $selectedYear !== '' && $selectedSemester !== '') {
        $sql = "SELECT course_code, cname, chour, s_c_year, semister, department, ayear, FileName
                FROM course
                WHERE other_department_takes LIKE ?
                  AND s_c_year LIKE ?
                  AND semister = ?
                  AND status = 'yes'
                ORDER BY ayear DESC, course_code ASC";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            $departmentLike = '%' . $department . '%';
            $yearLike = '%' . $selectedYear . '%';
            mysqli_stmt_bind_param($stmt, 'sss', $departmentLike, $yearLike, $selectedSemester);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result instanceof mysqli_result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $modules[] = $row;
                }
                mysqli_free_result($result);
            }
            mysqli_stmt_close($stmt);
        }
    }
}

studentRenderPageStart(
    "Download modules",
    "Learning Materials",
    "Download Modules",
    "Search approved modules by department, class year, and semester. Matching files are pulled from the shared course records already connected through the main database include.",
    array('include_table_css' => true)
);
?>
<fieldset>
    <legend>Module Search</legend>
    <form action="" method="post" class="student-form-grid two-col">
        <div class="student-form-field">
            <label class="student-label" for="module-department">Department</label>
            <input type="text" id="module-department" name="dpt" value="<?php echo studentH($department); ?>" readonly>
        </div>
        <div class="student-form-field">
            <label class="student-label" for="module-year">Student Class Year</label>
            <select id="module-year" name="scy" required>
                <option value="">Select Student Class Year</option>
                <?php foreach (array('1st', '2nd', '3rd', '4th', '5th') as $yearOption) { ?>
                    <option value="<?php echo studentH($yearOption); ?>"<?php echo $selectedYear === $yearOption ? ' selected' : ''; ?>><?php echo studentH($yearOption); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="student-form-field">
            <label class="student-label" for="module-semester">Semester</label>
            <select id="module-semester" name="sem" required>
                <option value="">Select Semester</option>
                <?php foreach (array('I', 'II', 'III') as $semesterOption) { ?>
                    <option value="<?php echo studentH($semesterOption); ?>"<?php echo $selectedSemester === $semesterOption ? ' selected' : ''; ?>><?php echo studentH($semesterOption); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="student-form-field">
            <label class="student-label">&nbsp;</label>
            <input type="submit" name="search" value="Search Modules">
        </div>
    </form>
</fieldset>

<?php if ($department === '') { ?>
    <div class="student-empty-state">Your student department is not available in the active session, so module filtering cannot run yet.</div>
<?php } elseif ($searchPerformed && empty($modules)) { ?>
    <div class="student-empty-state">No approved modules were found for the selected class year and semester.</div>
<?php } elseif (!empty($modules)) { ?>
    <div class="student-stat-row">
        <span class="student-stat-chip"><?php echo count($modules); ?> modules found</span>
    </div>
    <div class="student-table-wrap">
        <table cellpadding="1" cellspacing="1" id="resultTable">
            <thead>
                <tr>
                    <th>Module Code</th>
                    <th>Module Name</th>
                    <th>Credit Hour</th>
                    <th>Class Year</th>
                    <th>Semester</th>
                    <th>Department</th>
                    <th>Academic Year</th>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($modules as $module) {
                $fileName = trim((string) ($module['FileName'] ?? ''));
                ?>
                <tr>
                    <td><?php echo studentH($module['course_code'] ?? ''); ?></td>
                    <td><?php echo studentH($module['cname'] ?? ''); ?></td>
                    <td><?php echo studentH($module['chour'] ?? ''); ?></td>
                    <td><?php echo studentH($module['s_c_year'] ?? ''); ?></td>
                    <td><?php echo studentH($module['semister'] ?? ''); ?></td>
                    <td><?php echo studentH($module['department'] ?? ''); ?></td>
                    <td><?php echo studentH($module['ayear'] ?? ''); ?></td>
                    <td><?php echo studentH($fileName); ?></td>
                    <td>
                        <?php if ($fileName !== '') { ?>
                            <a class="student-action-link secondary" href="../material/module/<?php echo rawurlencode($fileName); ?>">Download</a>
                        <?php } else { ?>
                            <span class="student-form-note">Missing file</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
