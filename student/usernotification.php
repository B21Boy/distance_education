<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$messages = array();
$userId = studentCurrentUserId();

if ($userId !== '') {
    $sql = "SELECT m.M_ID, m.message, m.date_sended,
                   COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), m.M_sender) AS sender_name
            FROM message m
            LEFT JOIN user u ON u.UID = m.M_sender
            WHERE m.M_reciever = ?
              AND m.status = 'no'
            ORDER BY m.date_sended DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $messages[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}

$actionsHtml = '<a class="student-action-link" rel="facebox" href="newnotification1.php">New Message</a>';

studentRenderPageStart(
    "User notifications",
    "Messaging",
    "Unread Notifications",
    "Read the latest unread messages sent to your student account and reply directly from this page.",
    array('actions_html' => $actionsHtml)
);
?>
<div class="student-stat-row">
    <span class="student-stat-chip"><?php echo count($messages); ?> unread message<?php echo count($messages) === 1 ? '' : 's'; ?></span>
</div>

<?php if (empty($messages)) { ?>
    <div class="student-empty-state">You do not have any unread notifications right now.</div>
<?php } else { ?>
    <div class="student-message-list">
        <?php foreach ($messages as $message) { ?>
            <article class="student-message-card">
                <div class="student-message-meta">
                    <span>From: <?php echo studentH($message['sender_name'] ?? ''); ?></span>
                    <span><?php echo studentH(studentFormatDate($message['date_sended'] ?? '', 'M j, Y g:i A')); ?></span>
                </div>
                <p><?php echo nl2br(studentH($message['message'] ?? '')); ?></p>
                <div class="student-message-actions">
                    <a class="student-action-link secondary" rel="facebox" href="viewnotification1.php?M_ID=<?php echo urlencode((string) ($message['M_ID'] ?? '')); ?>">Reply</a>
                </div>
            </article>
        <?php } ?>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
