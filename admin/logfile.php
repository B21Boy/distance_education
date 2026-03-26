<?php
session_start();
include(__DIR__ . '/../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<script src="../javascript/date_time.js"></script>
<style>
.log-table-panel {
    display: grid;
    gap: 18px;
}
.log-table-meta {
    color: #45627f;
    font-size: 14px;
}
.log-simple-table-wrap {
    overflow-x: auto;
    border: 1px solid #dce6f2;
    border-radius: 14px;
    background: #ffffff;
}
.log-simple-table {
    width: 100%;
    min-width: 980px;
    border-collapse: collapse;
}
.log-simple-table th,
.log-simple-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e7edf5;
    text-align: left;
    vertical-align: top;
    line-height: 1.6;
}
.log-simple-table th {
    background: #eff5fb;
    color: #12395f;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.log-simple-table tr:last-child td {
    border-bottom: 0;
}
.log-activity-cell {
    max-width: 320px;
    white-space: pre-wrap;
    word-break: break-word;
}
.log-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.log-page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 40px;
    padding: 0 12px;
    border-radius: 10px;
    border: 1px solid #c9d9ea;
    background: #ffffff;
    color: #18466f;
    text-decoration: none;
    font-weight: 700;
}
.log-page-link.is-active {
    background: #1f6fb2;
    border-color: #1f6fb2;
    color: #ffffff;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $searchFile = trim((string) ($_GET['search_file'] ?? ''));
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    if ($currentPage < 1) {
        $currentPage = 1;
    }

    $perPage = 4;
    $totalRows = 0;
    $rows = array();

    if ($conn instanceof mysqli) {
        if ($searchFile !== '') {
            $searchLike = '%' . $searchFile . '%';
            $countStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS total FROM logfile WHERE username LIKE ? OR role LIKE ? OR activity_type LIKE ? OR activity_performed LIKE ?');
            if ($countStmt instanceof mysqli_stmt) {
                mysqli_stmt_bind_param($countStmt, 'ssss', $searchLike, $searchLike, $searchLike, $searchLike);
                mysqli_stmt_execute($countStmt);
                $countResult = mysqli_stmt_get_result($countStmt);
                if ($countResult instanceof mysqli_result) {
                    $countRow = mysqli_fetch_assoc($countResult);
                    $totalRows = (int) ($countRow['total'] ?? 0);
                    mysqli_free_result($countResult);
                }
                mysqli_stmt_close($countStmt);
            }
        } else {
            $countResult = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM logfile');
            if ($countResult instanceof mysqli_result) {
                $countRow = mysqli_fetch_assoc($countResult);
                $totalRows = (int) ($countRow['total'] ?? 0);
                mysqli_free_result($countResult);
            }
        }

        $totalPages = max(1, (int) ceil($totalRows / $perPage));
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
        $offset = ($currentPage - 1) * $perPage;

        if ($searchFile !== '') {
            $searchLike = '%' . $searchFile . '%';
            $dataStmt = mysqli_prepare($conn, 'SELECT logid, username, role, start_time, activity_type, activity_performed, ip_address, end FROM logfile WHERE username LIKE ? OR role LIKE ? OR activity_type LIKE ? OR activity_performed LIKE ? ORDER BY logid DESC LIMIT ?, ?');
            if ($dataStmt instanceof mysqli_stmt) {
                mysqli_stmt_bind_param($dataStmt, 'ssssii', $searchLike, $searchLike, $searchLike, $searchLike, $offset, $perPage);
                mysqli_stmt_execute($dataStmt);
                $dataResult = mysqli_stmt_get_result($dataStmt);
                if ($dataResult instanceof mysqli_result) {
                    while ($row = mysqli_fetch_assoc($dataResult)) {
                        $rows[] = $row;
                    }
                    mysqli_free_result($dataResult);
                }
                mysqli_stmt_close($dataStmt);
            }
        } else {
            $dataStmt = mysqli_prepare($conn, 'SELECT logid, username, role, start_time, activity_type, activity_performed, ip_address, end FROM logfile ORDER BY logid DESC LIMIT ?, ?');
            if ($dataStmt instanceof mysqli_stmt) {
                mysqli_stmt_bind_param($dataStmt, 'ii', $offset, $perPage);
                mysqli_stmt_execute($dataStmt);
                $dataResult = mysqli_stmt_get_result($dataStmt);
                if ($dataResult instanceof mysqli_result) {
                    while ($row = mysqli_fetch_assoc($dataResult)) {
                        $rows[] = $row;
                    }
                    mysqli_free_result($dataResult);
                }
                mysqli_stmt_close($dataStmt);
            }
        }
    } else {
        $totalPages = 1;
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
                            <h1 class="admin-page-title">Activity Log</h1>
                            <p class="admin-page-copy">This page now shows the real database table with 4 rows per page and sequential page numbers under the table.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel log-table-panel">
                        <form method="get" action="" class="admin-page-toolbar">
                            <div class="admin-page-form-row">
                                <label for="search_file"><strong>Search log</strong></label>
                                <input type="text" name="search_file" id="search_file" class="admin-page-input" placeholder="Search by username, role, activity, or details" value="<?php echo htmlspecialchars($searchFile, ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="submit" class="admin-page-btn">Filter</button>
                                <?php if ($searchFile !== '') { ?><a href="logfile.php" class="admin-page-btn-secondary">Clear Search</a><?php } ?>
                            </div>
                        </form>
                        <div class="log-table-meta">
                            Total rows: <strong><?php echo $totalRows; ?></strong>.
                            Showing <strong><?php echo count($rows); ?></strong> row(s) on page <strong><?php echo $currentPage; ?></strong>.
                        </div>
                        <?php if (!empty($rows)) { ?>
                        <div class="log-simple-table-wrap">
                            <table class="log-simple-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>UserName</th>
                                        <th>UserType</th>
                                        <th>Login Time</th>
                                        <th>Activity Type</th>
                                        <th>Activity Performed</th>
                                        <th>IP Address</th>
                                        <th>Logout Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $index => $row) { ?>
                                    <tr>
                                        <td><?php echo $offset + $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['start_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['activity_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="log-activity-cell"><?php echo htmlspecialchars($row['activity_performed'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['ip_address'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row['end'] !== '' ? $row['end'] : 'Still active', ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($totalPages > 1) { ?>
                        <div class="log-pagination">
                            <?php for ($page = 1; $page <= $totalPages; $page++) {
                                $query = http_build_query(array_filter(array('page' => $page, 'search_file' => $searchFile), static function ($value) {
                                    return $value !== '' && $value !== null;
                                }));
                            ?>
                            <a class="log-page-link <?php echo $page === $currentPage ? 'is-active' : ''; ?>" href="logfile.php<?php echo $query !== '' ? '?' . $query : ''; ?>"><?php echo $page; ?></a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <?php } else { ?>
                        <div class="admin-page-empty">No log records found<?php echo $searchFile !== '' ? ' for <strong>' . htmlspecialchars($searchFile, ENT_QUOTES, 'UTF-8') . '</strong>' : ''; ?>.</div>
                        <?php } ?>
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
