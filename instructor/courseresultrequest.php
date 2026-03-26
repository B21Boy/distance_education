<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$userId = instructorCurrentUserId();
$photoPath = instructorCurrentPhotoPath();
$requestData = instructorFetchRejectedCourseResults($conn, $userId);
$columns = $requestData['columns'];
$rows = $requestData['rows'];
$rejectReason = $rows ? trim((string) ($rows[0]['reject'] ?? '')) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="instructor-page.css" type="text/css">
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menuins.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenuins.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="instructor-page-shell">
                    <div class="instructor-page-header">
                        <div>
                            <span class="instructor-page-kicker">Request</span>
                            <h1 class="instructor-page-title">Rejected Course Result Requests</h1>
                            <p class="instructor-page-copy">Review the rejected course result rows and continue with the same update and resend actions already used by the instructor workflow.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <?php if ($rows) { ?>
                            <div class="instructor-note-card">
                                <div>
                                    <strong>Because of:</strong>
                                    <span><?php echo instructorH($rejectReason !== '' ? $rejectReason : 'No rejection reason recorded.'); ?></span>
                                </div>
                                <a class="instructor-btn" href="sendallrequest.php">Send All</a>
                            </div>
                            <div class="instructor-table-wrap">
                                <table cellpadding="1" cellspacing="1" id="resultTable">
                                    <thead>
                                        <tr>
                                            <?php foreach ($columns as $column) { ?>
                                                <th><?php echo instructorH($column); ?></th>
                                            <?php } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row) { ?>
                                            <tr>
                                                <?php foreach ($columns as $column) { ?>
                                                    <td><?php echo instructorH($row[$column] ?? ''); ?></td>
                                                <?php } ?>
                                                <td><a class="instructor-inline-link" rel="facebox" href="calculategradeu.php?id=<?php echo urlencode((string) ($row['no'] ?? '')); ?>">Update</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="instructor-empty-state">No new request.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php instructorRenderSidebar($photoPath); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php instructorRenderIconScripts(); ?>
</body>
</html>