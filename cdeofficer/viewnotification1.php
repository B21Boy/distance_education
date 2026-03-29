<?php
session_start();
include("../connection.php");
require("popup_styles.php");

$messageId = isset($_GET['M_ID']) ? (int) $_GET['M_ID'] : 0;
$replyReceiver = '';
$replySender = isset($_SESSION['suid']) ? (string) $_SESSION['suid'] : '';
$senderName = '';

if ($messageId > 0) {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT m.M_ID, m.M_sender, m.M_reciever, u.fname, u.lname
         FROM message AS m
         LEFT JOIN user AS u ON m.M_sender = u.UID
         WHERE m.M_ID = ?
         LIMIT 1"
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $messageId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);

        if (is_array($row)) {
            $replyReceiver = isset($row['M_sender']) ? (string) $row['M_sender'] : '';
            $senderName = trim(((string) ($row['fname'] ?? '')) . ' ' . ((string) ($row['lname'] ?? '')));
            if ($replySender === '') {
                $replySender = isset($row['M_reciever']) ? (string) $row['M_reciever'] : '';
            }
        }
    }
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Reply Message</h1>
        <p class="cde-popup-copy">Write your reply here and send it back to the original sender.</p>
    </div>
    <form action="notificationprocess1.php" method="post" class="cde-popup-form">
        <input type="hidden" name="ud_id" value="<?php echo (int) $messageId; ?>">
        <input type="hidden" name="M_Reciever" value="<?php echo htmlspecialchars($replyReceiver, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="M_sender" value="<?php echo htmlspecialchars($replySender, ENT_QUOTES, 'UTF-8'); ?>">

        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="reply_from">
                Send By
                <input type="text" id="reply_from" class="cde-popup-input" value="<?php echo htmlspecialchars($replySender, ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </label>
            <label class="cde-popup-field" for="reply_to">
                Reply To
                <input type="text" id="reply_to" class="cde-popup-input" value="<?php echo htmlspecialchars($senderName !== '' ? $senderName . ' (' . $replyReceiver . ')' : $replyReceiver, ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </label>
        </div>

        <label class="cde-popup-field" for="message">
            Message
            <textarea name="message" id="message" class="cde-popup-textarea" required placeholder="Write your reply here"></textarea>
        </label>

        <div class="cde-popup-actions">
            <button type="submit" class="cde-popup-btn">Send</button>
            <button type="reset" class="cde-popup-btn-secondary">Clear</button>
        </div>
    </form>
</div>
