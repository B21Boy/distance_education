<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
.content-shell {
    display: grid;
    gap: 20px;
}
.page-card {
    background: linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%);
    border: 1px solid #d9e3f0;
    border-radius: 18px;
    box-shadow: 0 16px 36px rgba(24, 58, 110, 0.10);
    overflow: hidden;
}
.page-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 24px 26px 10px;
}
.page-card-title {
    margin: 0;
    color: #163b67;
    font-size: 30px;
    line-height: 1.2;
}
.page-card-copy {
    margin: 8px 0 0;
    color: #5a6e86;
    font-size: 15px;
}
.page-card-body {
    padding: 0 26px 26px;
}
.page-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 170px;
    height: 44px;
    padding: 0 18px;
    border-radius: 12px;
    background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    box-shadow: 0 12px 24px rgba(33, 95, 184, 0.22);
}
.page-action:hover {
    text-decoration: none;
    opacity: 0.95;
}
.table-wrap {
    overflow-x: auto;
    border: 1px solid #dbe5f1;
    border-radius: 16px;
    background: #ffffff;
}
.modern-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}
.modern-table thead th {
    padding: 14px 16px;
    background: #edf4fb;
    color: #163b67;
    text-align: left;
    font-size: 14px;
    letter-spacing: 0.02em;
    border-bottom: 1px solid #d7e3f0;
}
.modern-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #edf2f8;
    color: #29415d;
}
.modern-table tbody tr:nth-child(even) {
    background: #fbfdff;
}
.modern-table tbody tr:hover {
    background: #f2f7ff;
}
.stat-chip {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 999px;
    background: #e8f1fc;
    color: #1d4d8f;
    font-weight: bold;
    font-size: 13px;
}
.empty-state {
    padding: 20px;
    border: 1px dashed #c8d7e8;
    border-radius: 14px;
    background: #f9fbfe;
    color: #60748c;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $departments = [];
    $result = mysqli_query($conn, "SELECT * FROM department");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $departments[] = $row;
        }
    }
?>
<div id="container">
    <div id="header">
        <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menucdeo.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenucdeo.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
                <div class="content-shell">
                    <div class="page-card">
                        <div class="page-card-header">
                            <div>
                                <h1 class="page-card-title">Manage Departments</h1>
                                <p class="page-card-copy">View department records and add new departments from a cleaner management screen.</p>
                            </div>
                            <a class="page-action" rel="facebox" href="adddept.php">Add Department</a>
                        </div>
                        <div class="page-card-body">
                            <div style="margin-bottom: 16px;"><span class="stat-chip"><?php echo count($departments); ?> departments</span></div>
                            <?php if (!empty($departments)) { ?>
                            <div class="table-wrap">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Department Code</th>
                                            <th>Department Name</th>
                                            <th>Location</th>
                                            <th>College Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($departments as $row) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['Dcode'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($row['DName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($row['Location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($row['Ccode'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">No departments found yet.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar">
            <?php require("officer_sidebar.php"); ?>
        </div>
    </div>

    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>
</div>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
