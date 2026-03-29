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
    display: grid;
    gap: 18px;
}
.stats-row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
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
.table-wrap {
    overflow-x: auto;
    border: 1px solid #dbe5f1;
    border-radius: 16px;
    background: #ffffff;
}
.modern-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}
.modern-table thead th {
    padding: 14px 16px;
    background: #edf4fb;
    color: #163b67;
    text-align: left;
    font-size: 14px;
    letter-spacing: 0.02em;
    border-bottom: 1px solid #d7e3f0;
    white-space: nowrap;
}
.modern-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #edf2f8;
    color: #29415d;
    vertical-align: top;
}
.modern-table tbody tr:nth-child(even) {
    background: #fbfdff;
}
.modern-table tbody tr:hover {
    background: #f2f7ff;
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
    $currentYear = date('Y');
    $rows = array();
    $columns = array();

    $stmt = mysqli_prepare($conn, "SELECT * FROM entrance_exam WHERE year = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $currentYear);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            $fieldCount = mysqli_num_fields($result);
            for ($i = 0; $i < $fieldCount; $i++) {
                $field = mysqli_fetch_field_direct($result, $i);
                if (!$field) {
                    continue;
                }
                if ($field->name === 'Account') {
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
    }
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
     require("sidemenucdeo.php");
?>
    
</div><div id="content">
    <div id="contentindex5">
        <div class="content-shell">
            <div class="page-card">
                <div class="page-card-header">
                    <h1 class="page-card-title">Entrance Exam Result</h1>
                    <p class="page-card-copy">Review the entrance exam records for the current year in the standard CDE officer table layout.</p>
                </div>
                <div class="page-card-body">
                    <div class="stats-row">
                        <span class="stat-chip"><?php echo count($rows); ?> result record<?php echo count($rows) === 1 ? '' : 's'; ?></span>
                        <span class="stat-chip">Year <?php echo htmlspecialchars($currentYear, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>

                    <?php if (!empty($rows) && !empty($columns)) { ?>
                    <div class="table-wrap">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <?php foreach ($columns as $column) { ?>
                                    <th><?php echo htmlspecialchars((string) $column, ENT_QUOTES, 'UTF-8'); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) { ?>
                                <tr>
                                    <?php foreach ($columns as $column) { ?>
                                    <td><?php echo htmlspecialchars((string) ($row[$column] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } else { ?>
                    <div class="empty-state">No entrance exam result records were found for the current year.</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div></div>
     <div id="sidebar">
<?php
    require("officer_sidebar.php");
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
</body>
</html>
