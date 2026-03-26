<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    header("location:../index.php");
    exit;
}

$photo_path = registrarCurrentPhotoPath();
$messages = registrarFetchUnreadMessages($conn, registrarCurrentUserId());
$status = isset($_GET['status']) ? trim((string) $_GET['status']) : '';
$status_message = '';
$status_class = 'info';
if ($status === 'sent') {
    $status_message = 'Your message was sent successfully.';
    $status_class = 'success';
} elseif ($status === 'replied') {
    $status_message = 'Your reply was sent successfully.';
    $status_class = 'success';
} elseif ($status === 'error') {
    $status_message = 'The message could not be sent. Please try again.';
    $status_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Registrar Officer Page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<?php registrarRenderStandardStyles(); ?>
</head>
<body class="student-portal-page light-theme">
<div id="container">
<div id="header"><?php require("header.php"); ?></div>
<div id="menu"><?php require("menuro.php"); ?></div>
<div class="main-row">
    <div id="left"><?php require("sidemenuro.php"); ?></div>
    <div id="content">
        <div id="contentindex5">
            <div class="registrar-page-card">
                <div class="registrar-page-toolbar">
                    <div>
                        <span class="registrar-page-eyebrow">Messages</span>
                        <h1 class="registrar-page-title">View and Send Messages</h1>
                        <p class="registrar-page-copy">Review unread messages for the registrar account and reply directly from the message center.</p>
                    </div>
                    <a href="newnotification1.php" class="registrar-link-btn">New Message</a>
                </div>
                <?php if ($status_message !== ''): ?>
                    <div class="registrar-status <?php echo registrarH($status_class); ?>"><?php echo registrarH($status_message); ?></div>
                <?php endif; ?>
                <?php if (count($messages) > 0): ?>
                    <div class="registrar-message-list">
                        <?php foreach ($messages as $message): ?>
                            <div class="registrar-message-item">
                                <div class="registrar-message-meta">
                                    <div class="registrar-message-sender"><?php echo registrarH($message['sender_name'] ?? $message['M_sender'] ?? 'Unknown sender'); ?></div>
                                    <div class="registrar-message-date"><?php echo registrarH($message['date_sended'] ?? ''); ?></div>
                                </div>
                                <p class="registrar-message-body"><?php echo registrarH($message['message'] ?? ''); ?></p>
                                <a href="viewnotification1.php?M_ID=<?php echo urlencode((string) ($message['M_ID'] ?? '')); ?>" class="registrar-link-btn">Reply</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="registrar-empty">No new messages were found for your account.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="sidebar"><?php registrarRenderSidebar($photo_path); ?></div>
</div>
<div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php registrarRenderIconScripts(); ?>
</body>
</html>
