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
$messages = instructorFetchUnreadMessages($conn, $userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<link rel="stylesheet" href="instructor-page.css" type="text/css">
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
                            <span class="instructor-page-kicker">Notification</span>
                            <h1 class="instructor-page-title">View And Send Message</h1>
                            <p class="instructor-page-copy">Review unread messages and continue with the same reply and compose actions already used in the instructor area.</p>
                        </div>
                    </div>
                    <div class="instructor-page-panel">
                        <div class="instructor-form-actions">
                            <a class="instructor-btn" rel="facebox" href="newnotification1.php">New Message</a>
                        </div>
                        <?php if ($messages) { ?>
                            <div class="instructor-message-list">
                                <?php foreach ($messages as $message) { ?>
                                    <article class="instructor-message-item">
                                        <div class="instructor-message-meta">
                                            <div><strong>From:</strong> <?php echo instructorH($message['sender_label'] ?? ''); ?></div>
                                            <div><?php echo instructorH($message['date_sended'] ?? ''); ?></div>
                                        </div>
                                        <p class="instructor-message-body"><?php echo nl2br(instructorH($message['message'] ?? '')); ?></p>
                                        <a class="instructor-inline-link" rel="facebox" href="viewnotification1.php?M_ID=<?php echo urlencode((string) ($message['M_ID'] ?? '')); ?>">Reply</a>
                                    </article>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="instructor-empty-state">No new message.</div>
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