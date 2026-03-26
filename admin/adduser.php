<?php
session_start();
include(__DIR__ . "/../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../javascript/date_time.js"></script>
<script src="js/validation.js" type="text/javascript"></script>
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<style>
body.student-portal-page #container {
    max-width: 1520px !important;
    width: calc(100% - 32px) !important;
}
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left {
    flex: 0 0 300px !important;
}
.main-row > #content {
    flex: 1 1 auto !important;
    min-width: 0;
}
.main-row > #sidebar {
    flex: 0 0 260px !important;
}
.admin-users-shell {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
}
.admin-users-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 22px;
}
.admin-section-kicker {
    display: inline-block;
    margin-bottom: 8px;
    padding: 4px 10px;
    border-radius: 999px;
    background: #d9e9fb;
    color: #174a7c;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.admin-users-header h1 {
    margin: 0;
    color: #12395f;
    font-size: 28px;
}
.admin-users-header p {
    margin: 10px 0 0;
    max-width: 720px;
    color: #4a6480;
    line-height: 1.6;
}
.admin-users-panel {
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    padding: 20px;
}
.admin-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.admin-search-form {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.admin-search-label {
    font-size: 15px;
    font-weight: 600;
    color: #173a5e;
}
.admin-search-input {
    width: 260px;
    max-width: 100%;
    height: 42px;
    border: 1px solid #bfd0e2;
    border-radius: 10px;
    padding: 0 14px;
    font-size: 15px;
    color: #173a5e;
    background: #f9fbfe;
}
.admin-search-input:focus {
    outline: none;
    border-color: #2f77bd;
    box-shadow: 0 0 0 4px rgba(47, 119, 189, 0.12);
}
.admin-primary-btn,
.admin-secondary-btn,
.admin-add-user-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    border: 0;
    border-radius: 10px;
    padding: 0 18px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
}
.admin-primary-btn {
    background: #1f6fb2;
    color: #ffffff;
    box-shadow: 0 12px 24px rgba(31, 111, 178, 0.18);
}
.admin-secondary-btn {
    background: #edf4fb;
    color: #18466f;
}
.admin-add-user-link {
    background: #12395f;
    color: #ffffff;
    box-shadow: 0 12px 24px rgba(18, 57, 95, 0.16);
}
.admin-primary-btn:hover,
.admin-secondary-btn:hover,
.admin-add-user-link:hover {
    transform: translateY(-1px);
}
.admin-users-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 16px;
    color: #45627f;
}
.admin-users-count {
    font-size: 15px;
}
.admin-users-count strong,
.admin-users-search-state strong {
    color: #1f6fb2;
}
.admin-users-table-wrap {
    overflow-x: auto;
    border: 1px solid #e3ebf3;
    border-radius: 14px;
}
.admin-users-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 840px;
    background: #ffffff;
}
.admin-users-table th {
    background: #eff5fb;
    color: #12395f;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.admin-users-table th,
.admin-users-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e7edf5;
    text-align: left;
}
.admin-users-table tr:last-child td {
    border-bottom: 0;
}
.admin-users-table td {
    color: #36516d;
    vertical-align: middle;
}
.admin-photo-thumb {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid #d7e3ef;
    background: #f2f6fb;
}
.admin-empty-state {
    padding: 34px 20px;
    border: 1px dashed #bfd0e2;
    border-radius: 14px;
    background: #f8fbff;
    text-align: center;
    color: #4d6882;
    font-size: 15px;
}
.admin-pagination {
    margin-top: 18px;
    text-align: center;
}
@media (max-width: 1100px) {
    body.student-portal-page #container {
        width: calc(100% - 20px) !important;
    }
    .main-row {
        flex-direction: column !important;
    }
    .main-row > #left,
    .main-row > #content,
    .main-row > #sidebar {
        flex: 1 1 auto !important;
        width: 100%;
    }
}
@media (max-width: 720px) {
    .admin-users-shell {
        padding: 16px;
    }
    .admin-users-panel {
        padding: 16px;
    }
    .admin-search-form {
        width: 100%;
    }
    .admin-search-input,
    .admin-primary-btn,
    .admin-secondary-btn,
    .admin-add-user-link {
        width: 100%;
    }
}
</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
        loadingImage: 'src/loading.gif',
        closeImage: 'src/closelabel.png'
    });
});
</script>
</head>
<body class="student-portal-page light-theme">
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!empty($_SESSION['flash_success'])) {
    echo '<script type="text/javascript">alert(' . json_encode($_SESSION['flash_success']) . ');</script>';
    unset($_SESSION['flash_success']);
} elseif (!empty($_GET['m']) && $_GET['m'] === 'success') {
    echo '<script type="text/javascript">alert(' . json_encode('Your Information Is Successfully Registered !!!') . ');</script>';
}

if (!empty($_SESSION['flash_error'])) {
    echo '<script type="text/javascript">alert(' . json_encode($_SESSION['flash_error']) . ');</script>';
    unset($_SESSION['flash_error']);
} elseif (!empty($_GET['e'])) {
    $err = $_GET['e'];
    $msg = '';
    if ($err === 'photo_size') {
        $msg = 'Photo size should not be greater than 2 MB!';
    } elseif ($err === 'photo_type') {
        $msg = 'Photo should be in JPEG or PNG format';
    } elseif ($err === 'unable_register') {
        $msg = 'Unable to register the user';
    }
    if ($msg !== '') {
        echo '<script type="text/javascript">alert(' . json_encode($msg) . ');</script>';
    }
}
?>
<div id="container">
<div id="header">
<?php require("header.php"); ?>
</div>
<div id="menu">
<?php require("menu.php"); ?>
</div>
<div class="main-row">
<div id="left">
<?php require("sidemenu.php"); ?>
</div>
<div id="content">
<div id="contentindex5">
<div id="content" class="clearfix">
<div class="admin-users-shell">
<div class="admin-users-header">
<div>
<span class="admin-section-kicker">Admin</span>
<h1>User Management</h1>
<p>Register new users, search the current registry, and verify that records are being fetched correctly from the MySQL database.</p>
</div>
</div>
<?php require("blockuser.php"); ?>
</div>
</div>
</div>
</div>
<div id="sidebar">
<?php require("rightsidebar.php"); ?>
</div>
</div>
<?php include("../footer.php"); ?>
</div>
</body>
</html>
