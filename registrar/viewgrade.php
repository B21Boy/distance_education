<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$departments = registrarFetchDepartments($conn);
$class_years = ['1st', '2nd', '3rd', '4th', '5th'];
$semesters = ['I', 'II',];
$sections = ['A', 'B', 'C', 'D', 'E', 'F'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-header">
                    <span class="registrar-page-eyebrow">Grade Report</span>
                    <h1 class="registrar-page-title">Prepare Grade Report</h1>
                    <p class="registrar-page-copy">Select the department, class year, semester, and section to review approved student grades and generate the report.</p>
                </div>
                <form action="viewgradeall.php" method="post" class="registrar-form-grid" id="viewgrade-search-form">
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="viewgrade-department">Department</label>
                        <select name="dpt" id="viewgrade-department" class="registrar-select" required>
                            <option value="">Select department</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?php echo registrarH($department); ?>"><?php echo registrarH($department); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="viewgrade-year">Student Class Year</label>
                        <select name="scy" id="viewgrade-year" class="registrar-select" required>
                            <option value="">Select student class year</option>
                            <?php foreach ($class_years as $class_year): ?>
                                <option value="<?php echo registrarH($class_year); ?>"><?php echo registrarH($class_year); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="viewgrade-semester">Semester</label>
                        <select name="sem" id="viewgrade-semester" class="registrar-select" required>
                            <option value="">Select semester</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?php echo registrarH($semester); ?>"><?php echo registrarH($semester); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="viewgrade-section">Section</label>
                        <select name="sec" id="viewgrade-section" class="registrar-select" required>
                            <option value="">Select section</option>
                            <?php foreach ($sections as $section): ?>
                                <option value="<?php echo registrarH($section); ?>"><?php echo registrarH($section); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="search" class="registrar-btn">Search Grades</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
<script>
(function () {
    var form = document.getElementById('viewgrade-search-form');
    if (!form) {
        return;
    }

    function encodeForm(formElement) {
        var pairs = [];
        var elements = formElement.elements;

        for (var i = 0; i < elements.length; i += 1) {
            var field = elements[i];
            if (!field.name || field.disabled) {
                continue;
            }

            var type = (field.type || '').toLowerCase();
            if ((type === 'checkbox' || type === 'radio') && !field.checked) {
                continue;
            }

            if (type === 'select-multiple') {
                for (var j = 0; j < field.options.length; j += 1) {
                    if (field.options[j].selected) {
                        pairs.push(encodeURIComponent(field.name) + '=' + encodeURIComponent(field.options[j].value));
                    }
                }
                continue;
            }

            pairs.push(encodeURIComponent(field.name) + '=' + encodeURIComponent(field.value));
        }

        return pairs.join('&');
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        try {
            window.sessionStorage.setItem('registrar_viewgrade_autoprint', '1');
        } catch (error) {
            // Ignore browsers that block sessionStorage.
        }

        var request = new XMLHttpRequest();
        try {
            request.open('POST', form.action, false);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            request.send(encodeForm(form));
        } catch (error) {
            HTMLFormElement.prototype.submit.call(form);
            return;
        }

        if (request.status >= 200 && request.status < 300 && request.responseText) {
            document.open();
            document.write(request.responseText);
            document.close();
            window.focus();
            window.print();
            return;
        }

        HTMLFormElement.prototype.submit.call(form);
    });
})();
</script>
</body>
</html>
