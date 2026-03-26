<?php
session_start();
include(__DIR__ . '/../connection.php');

const ADMIN_BACKUP_DB = 'cde_backup';

function createDatabaseConnection(string $host, string $user, string $pass, string $database): ?mysqli
{
    $db = @new mysqli($host, $user, $pass, $database);
    if ($db->connect_error) {
        return null;
    }

    $db->set_charset('utf8mb4');
    return $db;
}

function escapeIdentifier(string $identifier): string
{
    return str_replace('`', '``', $identifier);
}

function buildBackupSql(mysqli $db, string $sourceDatabase): string
{
    $tables = array();
    $tableResult = $db->query('SHOW TABLES');

    if ($tableResult instanceof mysqli_result) {
        while ($row = $tableResult->fetch_row()) {
            if (isset($row[0])) {
                $tables[] = (string) $row[0];
            }
        }
        $tableResult->free();
    }

    $dump = array();
    $dump[] = '-- Backup generated on ' . date('Y-m-d H:i:s');
    $dump[] = '-- Source database: ' . $sourceDatabase;
    $dump[] = 'SET NAMES utf8mb4;';
    $dump[] = 'SET FOREIGN_KEY_CHECKS=0;';
    $dump[] = '';

    foreach ($tables as $table) {
        $safeTable = escapeIdentifier($table);
        $createResult = $db->query('SHOW CREATE TABLE `' . $safeTable . '`');
        $createRow = $createResult instanceof mysqli_result ? $createResult->fetch_row() : null;
        if ($createResult instanceof mysqli_result) {
            $createResult->free();
        }

        if (!$createRow || !isset($createRow[1])) {
            continue;
        }

        $dump[] = 'DROP TABLE IF EXISTS `' . $safeTable . '`;';
        $dump[] = $createRow[1] . ';';

        $dataResult = $db->query('SELECT * FROM `' . $safeTable . '`');
        if ($dataResult instanceof mysqli_result) {
            $fieldCount = $dataResult->field_count;

            while ($row = $dataResult->fetch_row()) {
                $values = array();
                for ($i = 0; $i < $fieldCount; $i++) {
                    if ($row[$i] === null) {
                        $values[] = 'NULL';
                        continue;
                    }

                    $values[] = "'" . $db->real_escape_string((string) $row[$i]) . "'";
                }

                $dump[] = 'INSERT INTO `' . $safeTable . '` VALUES(' . implode(',', $values) . ');';
            }

            $dataResult->free();
        }

        $dump[] = '';
    }

    $dump[] = 'SET FOREIGN_KEY_CHECKS=1;';

    return implode(PHP_EOL, $dump) . PHP_EOL;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<script src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $statusTitle = 'Database Backup';
    $statusMessage = 'Database connection is not available.';
    $statusPath = '';
    $sourceDatabase = ADMIN_BACKUP_DB;

    $backupDb = createDatabaseConnection($domain, $dbuser, $dbpass, ADMIN_BACKUP_DB);
    if ($backupDb instanceof mysqli) {
        $folder = __DIR__ . '/db';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = $folder . '/backup.sql';
        $backupSql = buildBackupSql($backupDb, ADMIN_BACKUP_DB);

        if (file_put_contents($filename, $backupSql) !== false) {
            $statusMessage = 'Database backup completed successfully.';
            $statusPath = 'admin/db/backup.sql';
        } else {
            $statusMessage = 'Unable to write the backup file.';
        }

        $backupDb->close();
    } else {
        $statusMessage = 'Unable to connect to the backup database.';
    }
?>
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="admin-page-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">Admin</span>
                            <h1 class="admin-page-title">Backup Database</h1>
                            <p class="admin-page-copy">Create a fresh SQL backup from the dedicated admin backup database.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-status-card">
                            <strong><?php echo htmlspecialchars($statusTitle, ENT_QUOTES, 'UTF-8'); ?>:</strong>
                            <?php echo htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?>
                            <br>Source database: <strong><?php echo htmlspecialchars($sourceDatabase, ENT_QUOTES, 'UTF-8'); ?></strong>
                            <?php if ($statusPath !== '') { ?>
                            <br>Backup path: <strong><?php echo htmlspecialchars($statusPath, ENT_QUOTES, 'UTF-8'); ?></strong>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require('rightsidebar.php'); ?></div>
    </div>
    <div id="footer"><?php include('../footer.php'); ?></div>
</div>
<?php } else { header('location:../index.php'); exit; } ?>
</body>
</html>
