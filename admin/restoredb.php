<?php
session_start();
include(__DIR__ . '/../connection.php');

const ADMIN_RESTORE_DB = 'cde_backup';

function createRestoreConnection(string $host, string $user, string $pass, string $database): ?mysqli
{
    $server = @new mysqli($host, $user, $pass);
    if ($server->connect_error) {
        return null;
    }

    $server->set_charset('utf8mb4');
    $safeDatabase = str_replace('`', '``', $database);
    if (!$server->query('CREATE DATABASE IF NOT EXISTS `' . $safeDatabase . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci')) {
        $server->close();
        return null;
    }

    $server->close();

    $db = @new mysqli($host, $user, $pass, $database);
    if ($db->connect_error) {
        return null;
    }

    $db->set_charset('utf8mb4');
    return $db;
}

function restoreDatabaseTables(mysqli $db, string $filePath): string
{
    if (!is_file($filePath)) {
        return 'Backup file not found.';
    }

    $sql = file_get_contents($filePath);
    if ($sql === false || trim($sql) === '') {
        return 'Unable to read the backup file.';
    }

    $db->query('SET FOREIGN_KEY_CHECKS=0');

    if (!$db->multi_query($sql)) {
        $db->query('SET FOREIGN_KEY_CHECKS=1');
        return 'Database restore failed: ' . $db->error;
    }

    do {
        $result = $db->store_result();
        if ($result instanceof mysqli_result) {
            $result->free();
        }
    } while ($db->more_results() && $db->next_result());

    $error = $db->error;
    $db->query('SET FOREIGN_KEY_CHECKS=1');

    if ($error !== '') {
        return 'Database restore completed with errors: ' . $error;
    }

    return 'Database restore completed successfully.';
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
    $statusMessage = 'Database connection is not available.';
    $backupPath = __DIR__ . '/db/backup.sql';
    $targetDatabase = ADMIN_RESTORE_DB;

    $restoreDb = createRestoreConnection($domain, $dbuser, $dbpass, ADMIN_RESTORE_DB);
    if ($restoreDb instanceof mysqli) {
        $statusMessage = restoreDatabaseTables($restoreDb, $backupPath);
        $restoreDb->close();
    } else {
        $statusMessage = 'Unable to connect to the restore database.';
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
                            <h1 class="admin-page-title">Restore Database</h1>
                            <p class="admin-page-copy">Restore the dedicated admin backup database from the saved SQL backup file.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-status-card">
                            <strong>Restore status:</strong> <?php echo htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?>
                            <br>Target database: <strong><?php echo htmlspecialchars($targetDatabase, ENT_QUOTES, 'UTF-8'); ?></strong>
                            <br>Backup source: <strong><?php echo htmlspecialchars('admin/db/backup.sql', ENT_QUOTES, 'UTF-8'); ?></strong>
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
