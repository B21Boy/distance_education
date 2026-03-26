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
                    <span class="registrar-page-eyebrow">Student ID</span>
                    <h1 class="registrar-page-title">Generate Student IDs</h1>
                    <p class="registrar-page-copy">Select a department to review first-year students and continue to the ID generation step.</p>
                </div>
                <form action="generateclass.php" method="post" class="registrar-form-grid">
                    <div class="registrar-form-field">
                        <label class="registrar-label" for="generateid-department">Department</label>
                        <select name="dpt" id="generateid-department" class="registrar-select" required>
                            <option value="">Select department</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?php echo registrarH($department); ?>"><?php echo registrarH($department); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="registrar-form-field full">
                        <div class="registrar-actions">
                            <button type="submit" name="search" class="registrar-btn">Load Students</button>
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
