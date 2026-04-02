<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
Instructor page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
.module-shell {
    display: grid;
    gap: 20px;
}
.module-card {
    margin: 12px 0;
    padding: 28px 30px;
    background: linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%);
    border: 1px solid #d9e3f0;
    border-radius: 18px;
    box-shadow: 0 16px 36px rgba(24, 58, 110, 0.10);
}
.module-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.module-eyebrow {
    margin: 0 0 8px;
    color: #2c74c9;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.module-title {
    margin: 0 0 10px;
    color: #163b67;
    font-size: 30px;
    line-height: 1.2;
}
.module-copy {
    max-width: 720px;
    margin: 0;
    color: #5a6e86;
    font-size: 15px;
    line-height: 1.7;
}
.module-action a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 22px;
    border-radius: 12px;
    background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 12px 24px rgba(33, 95, 184, 0.22);
    transition: transform 0.18s ease, box-shadow 0.18s ease;
}
.module-action a:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 28px rgba(33, 95, 184, 0.26);
}
.module-table-wrap {
    overflow-x: auto;
}
.module-table {
    width: 100%;
    min-width: 860px;
    border-collapse: separate;
    border-spacing: 0;
}
.module-table thead th {
    padding: 15px 14px;
    border: none;
    background: linear-gradient(135deg, #163b67 0%, #255b93 100%);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.45;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.module-table thead th:first-child {
    border-top-left-radius: 14px;
}
.module-table thead th:last-child {
    border-top-right-radius: 14px;
}
.module-table tbody td {
    padding: 15px 14px;
    border-bottom: 1px solid #dde7f2;
    color: #24405d;
    font-size: 14px;
    vertical-align: middle;
    background: #ffffff;
}
.module-table tbody tr:nth-child(even) td {
    background: #f8fbff;
}
.module-table tbody tr:hover td {
    background: #edf5ff;
}
.module-table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 14px;
}
.module-table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 14px;
}
.module-department {
    font-weight: 600;
}
.module-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.module-actions a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #eaf3ff;
    transition: transform 0.18s ease, background-color 0.18s ease;
}
.module-actions a:hover {
    transform: translateY(-1px);
    background: #dcecff;
}
.module-actions img {
    display: block;
}
.module-empty {
    padding: 34px 20px !important;
    color: #60748c !important;
    font-size: 15px !important;
    text-align: center;
    background: #f8fbff !important;
}
@media (max-width: 768px) {
    .module-card {
        padding: 22px 18px;
    }
    .module-title {
        font-size: 26px;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
    $photo_path = instructorCurrentPhotoPath();
?>
<div id="container">
    <div id="header">
<?php
    require("header.php");
?>
    </div>
    <div id="menu">
<?php
    require("menuins.php");
?>
    </div>
    <div class="main-row">
        <div id="left">
<?php
	 require("sidemenuins.php");
?>
        </div>
        <div id="content">
	<div id="contentindex5">
                <div class="module-shell">
                    <div class="module-card">
                        <div class="module-card-header">
                            <div>
                                <p class="module-eyebrow">Module Management</p>
                                <h1 class="module-title">Upload Prepared Module</h1>
                                <p class="module-copy">Review the assigned courses below and upload the prepared module file for each one in a consistent format.</p>
                            </div>
                            <div class="module-action">
                                <a rel="facebox" href="uploadnewm.php">Upload Module</a>
                            </div>
                        </div>
                        <div class="module-table-wrap">
                            <table cellpadding="1" cellspacing="1" id="resultTable" class="module-table">
                                <thead>
                                    <tr>
                                        <th>Module Code</th>
                                        <th>Module Name</th>
                                        <th>Credit Hour</th>
                                        <th>Year</th>
                                        <th>Department</th>
                                        <th>File Name</th>
                                        <th>Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
				<?php
                            $uid = isset($_SESSION['suid']) ? mysql_real_escape_string($_SESSION['suid']) : '';
                            $result = mysql_query("SELECT * FROM assign_instructor where uid='$uid'");
                            $has_rows = false;

                            if ($result) {
                                while ($row = mysql_fetch_array($result)) {
                                    $cc = isset($row['corse_code']) ? mysql_real_escape_string($row['corse_code']) : '';
                                    $result1 = mysql_query("SELECT * FROM course where course_code='$cc'");
                                    $row1 = $result1 ? mysql_fetch_array($result1) : false;

                                    if (!$row1) {
                                        continue;
                                    }

                                    $has_rows = true;
                                    $course_code = isset($row1['course_code']) ? $row1['course_code'] : '';
                                    $course_name = isset($row1['cname']) ? $row1['cname'] : '';
                                    $credit_hour = isset($row1['chour']) ? $row1['chour'] : '';
                                    $year = isset($row1['ayear']) ? $row1['ayear'] : '';
                                    $department = isset($row['department']) ? $row['department'] : '';
                                    $files = isset($row1['FileName']) ? $row1['FileName'] : '';
                                    $upload_href = 'uploadnea.php?id=' . rawurlencode($course_code);

                                    echo '<tr class="record">';
                                    echo '<td>' . instructorH($course_code) . '</td>';
                                    echo '<td>' . instructorH($course_name) . '</td>';
                                    echo '<td>' . instructorH($credit_hour) . '</td>';
                                    echo '<td>' . instructorH($year) . '</td>';
                                    echo '<td class="module-department">' . instructorH($department) . '</td>';
                                    echo '<td>' . instructorH($files !== '' ? $files : 'Not uploaded yet') . '</td>';
                                    echo '<td><div class="module-actions">';

                                    if ($files !== '') {
                                        echo '<a href="../material/module/' . instructorH($files) . '" title="Download module"><img width="30" height="30" src="images/d1.jpg" alt="Download module"></a>';
                                    }

                                    echo '<a rel="facebox" href="' . instructorH($upload_href) . '" title="Upload module file"><img width="30" height="30" src="images/u2.png" alt="Upload module"></a>';
                                    echo '</div></td>';
                                    echo '</tr>';
                                }
                            }

                            if (!$has_rows) {
                                echo '<tr><td colspan="7" class="module-empty">No assigned modules are available for upload right now.</td></tr>';
                            }
				?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
				</div></div>
	 <div id="sidebar">
<?php
    instructorRenderSidebar($photo_path);
?>
	  </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>
<?php
}
else
{
header("location:../index.php");
exit;
}
?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
