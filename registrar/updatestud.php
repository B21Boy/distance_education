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
$semesters = ['I', 'II', 'III'];
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
                    <span class="registrar-page-eyebrow">Student Promotion</span>
                    <h1 class="registrar-page-title">Update Student Year and Semester</h1>
                    <p class="registrar-page-copy">Choose the student group you want to review before clearing or advancing the selected records.</p>
                </div>
                <form action="studentlist.php" method="post" class="registrar-form-grid">
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="updatestud-department">Department</label>
                        <select name="dpt" id="updatestud-department" class="registrar-select" required>
                            <option value="">Select department</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?php echo registrarH($department); ?>"><?php echo registrarH($department); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="updatestud-year">Student Class Year</label>
                        <select name="scy" id="updatestud-year" class="registrar-select" required>
                            <option value="">Select student class year</option>
                            <?php foreach ($class_years as $class_year): ?>
                                <option value="<?php echo registrarH($class_year); ?>"><?php echo registrarH($class_year); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="updatestud-semester">Semester</label>
                        <select name="sem" id="updatestud-semester" class="registrar-select" required>
                            <option value="">Select semester</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?php echo registrarH($semester); ?>"><?php echo registrarH($semester); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="search" class="registrar-btn">Review Students</button>
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
</body>
</html>
