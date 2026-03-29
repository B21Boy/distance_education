<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$userId = departmentCurrentUserId();
$messages = departmentFetchUnreadMessages($conn, $userId);
$status = trim((string) ($_GET['status'] ?? ''));
$statusMessages = [
    'sent' => 'Message sent successfully.',
    'replied' => 'Reply sent successfully.',
    'error' => 'The message could not be sent right now. Please try again.'
];

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Notifications",
    "Read new messages sent to your account and send a new notification from the same page.",
    '<a rel="facebox" href="newnotification1.php" class="department-btn">New message</a>'
);
?>
<?php echo departmentStatusBanner($status, $statusMessages); ?>
<div class="department-stat-row">
    <span class="department-stat-chip">Unread messages: <?php echo count($messages); ?></span>
</div>

<?php if (!$messages) { ?>
<div class="department-empty">No new messages are available for your account.</div>
<?php } else { ?>
<div class="department-message-list">
    <?php foreach ($messages as $message) { ?>
    <div class="department-message-card">
        <div class="department-message-meta">
            <span>From: <?php echo departmentH($message['sender_name']); ?></span>
            <span><?php echo departmentH($message['date_sended']); ?></span>
        </div>
        <p><?php echo nl2br(departmentH($message['message'])); ?></p>
        <div class="department-inline-actions" style="margin-top:16px;">
            <a rel="facebox" href="viewnotification1.php?M_ID=<?php echo rawurlencode((string) $message['M_ID']); ?>" class="department-link-btn">Reply</a>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
