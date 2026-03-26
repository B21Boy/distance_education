<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$status = isset($_GET['status']) ? trim((string) $_GET['status']) : '';
$status_message = '';
$status_class = 'info';
if ($status === 'success') {
    $status_message = 'Academic calendar saved successfully.';
    $status_class = 'success';
} elseif ($status === 'error') {
    $status_message = 'Unable to save the academic calendar right now. Please check the form and try again.';
    $status_class = 'error';
}
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
                    <span class="registrar-page-eyebrow">Academic Calendar</span>
                    <h1 class="registrar-page-title">Prepare Academic Calendar</h1>
                    <p class="registrar-page-copy">Publish semester dates and planned activities for distance education students in a clean, readable format.</p>
                </div>
                <?php if ($status_message !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($status_class); ?>"><?php echo registrarH($status_message); ?></div>
                <?php endif; ?>
                <form action="addcalender.php" method="post" class="registrar-form-grid">
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="calendar-semester">Semester</label>
                        <select name="semister" id="calendar-semester" class="registrar-select" required>
                            <option value="">Select semester</option>
                            <option value="Semister one">Semister one</option>
                            <option value="Semister Two">Semister Two</option>
                        </select>
                    </div>
                    <div class="registrar-form-field full">
                        <label class="registrar-label" for="calendar-dates">Dates</label>
                        <textarea rows="5" name="date" id="calendar-dates" class="registrar-textarea" required placeholder="Enter important dates for the selected semester"></textarea>
                    </div>
                    <div class="registrar-form-field full">
                        <label class="registrar-label" for="calendar-activities">Activities</label>
                        <textarea rows="8" name="activ" id="calendar-activities" class="registrar-textarea" required placeholder="Describe the academic activities planned for the semester"></textarea>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="submit" class="registrar-btn">Save Calendar</button>
                            <button type="reset" name="clear" class="registrar-btn-secondary">Clear</button>
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
