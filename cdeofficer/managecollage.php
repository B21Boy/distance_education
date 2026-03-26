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
body.student-portal-page {
    padding: 10px 0 24px !important;
}
body.student-portal-page #container {
    max-width: 1720px !important;
    width: calc(100% - 12px) !important;
}
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 18px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 250px !important; min-width: 250px !important; max-width: 250px !important; }
.main-row > #content {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    width: auto !important;
}
.main-row > #sidebar { flex: 0 0 230px !important; min-width: 230px !important; max-width: 230px !important; }
#contentindex5 {
    width: 100% !important;
    padding: 34px !important;
}
.content-shell {
    display: grid;
    gap: 20px;
    width: 100%;
}
.page-card {
    width: 100%;
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
    padding: 26px 30px 12px;
}
.page-card-title {
    margin: 0;
    color: #163b67;
    font-size: 32px;
    line-height: 1.2;
}
.page-card-copy {
    margin: 8px 0 0;
    color: #5a6e86;
    font-size: 16px;
}
.page-card-body {
    padding: 0 30px 30px;
}
.page-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 170px;
    height: 46px;
    padding: 0 20px;
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
    min-width: 920px;
}
.modern-table thead th {
    padding: 15px 18px;
    background: #edf4fb;
    color: #163b67;
    text-align: left;
    font-size: 14px;
    letter-spacing: 0.02em;
    border-bottom: 1px solid #d7e3f0;
}
.modern-table tbody td {
    padding: 15px 18px;
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
@media (max-width: 1100px) {
    body.student-portal-page #container {
        width: calc(100% - 20px) !important;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $photo_value = isset($_SESSION['sphoto']) ? trim($_SESSION['sphoto']) : '';
    $photo_path = $photo_value !== '' ? htmlspecialchars($photo_value, ENT_QUOTES, 'UTF-8') : '../images/default.png';
    $collages = [];
    $result = mysqli_query($conn, "SELECT * FROM collage");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $collages[] = $row;
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
                                <h1 class="page-card-title">Manage Colleges</h1>
                                <p class="page-card-copy">Review registered colleges and add new ones from a cleaner, wider management view.</p>
                            </div>
                            <a class="page-action" rel="facebox" href="addcollega.php">Add College</a>
                        </div>
                        <div class="page-card-body">
                            <div style="margin-bottom: 16px;"><span class="stat-chip"><?php echo count($collages); ?> colleges</span></div>
                            <?php if (!empty($collages)) { ?>
                            <div class="table-wrap">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>College Code</th>
                                            <th>College Name</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($collages as $row) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['Ccode'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($row['cname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($row['Location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">No colleges found yet.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
                    <?php
                    echo "<b><br><font color=blue>Welcome:</font><font color=#c1110d>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$photo_path."'width=180px height=160px alt='CDE officer profile photo'></b>";
                    ?>
                    <div id="sidebarr">
                        <ul>
                            <li><a href="updateprofilephoto.php">Change Photo</a></li>
                            <li><a href="changepass.php">Change password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
