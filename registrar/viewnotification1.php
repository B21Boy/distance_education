<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!registrarIsLoggedIn()) {
    http_response_code(403);
    ?>
    <style>
    .registrar-facebox-shell {
        width: min(100%, 720px);
        margin: 0 auto;
    }
    </style>
    <?php registrarRenderStandardStyles(); ?>
    <div class="registrar-facebox-shell">
    <div class="registrar-page-card">
        <div class="registrar-status error">Your session has expired. Please sign in again.</div>
    </div>
    </div>
    <?php
    exit;
}

$message_id = trim((string) ($_GET['M_ID'] ?? ''));
$current_user_id = registrarCurrentUserId();
$message_row = null;
$error_message = '';

if ($message_id === '') {
    $error_message = 'The selected message could not be found.';
} else {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT m.M_ID, m.M_sender, m.M_Reciever, m.message, m.date_sended,
                COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), m.M_sender) AS sender_name
         FROM message AS m
         LEFT JOIN user AS u ON u.UID = m.M_sender
         WHERE m.M_ID = ?
         LIMIT 1"
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $message_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            $message_row = mysqli_fetch_assoc($result) ?: null;
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }

    if (!$message_row) {
        $error_message = 'The selected message could not be loaded.';
    }
}

$sender_name = 'Unknown sender';
$reply_target_id = '';
$message_date = '';
$message_body = '';

if ($message_row) {
    $sender_name = trim((string) ($message_row['sender_name'] ?? ''));
    if ($sender_name === '') {
        $sender_name = trim((string) ($message_row['M_sender'] ?? 'Unknown sender'));
    }
    $reply_target_id = trim((string) ($message_row['M_sender'] ?? ''));
    $message_date = trim((string) ($message_row['date_sended'] ?? ''));
    $message_body = trim((string) ($message_row['message'] ?? ''));
}
?>
<style>
.registrar-facebox-shell {
    width: min(100%, 720px);
    margin: 0 auto;
}
.registrar-popup-summary {
    display: grid;
    gap: 14px;
    margin-bottom: 24px;
    padding: 18px 20px;
    border: 1px solid #d7e2f1;
    border-radius: 16px;
    background: #ffffff;
}
.registrar-popup-summary-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px 18px;
}
.registrar-popup-summary-label {
    color: #5d718b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.registrar-popup-summary-value {
    margin-top: 6px;
    color: #17324d;
    font-size: 15px;
    font-weight: 700;
    word-break: break-word;
}
.registrar-popup-summary-message {
    padding: 16px 18px;
    border-radius: 14px;
    background: #f7fbff;
    border: 1px solid #d7e8f7;
    color: #36516c;
    line-height: 1.7;
    white-space: pre-wrap;
    word-break: break-word;
}
@media (max-width: 760px) {
    .registrar-popup-summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php registrarRenderStandardStyles(); ?>
<div class="registrar-facebox-shell">
<div class="registrar-page-card">
    <div class="registrar-page-header">
        <span class="registrar-page-eyebrow">Reply Message</span>
        <h1 class="registrar-page-title">Respond to Notification</h1>
        <p class="registrar-page-copy">Review the unread message details and send your reply in the same standard registrar format.</p>
    </div>

    <?php if ($error_message !== ''): ?>
        <div class="registrar-status error"><?php echo registrarH($error_message); ?></div>
    <?php else: ?>
        <div class="registrar-popup-summary">
            <div class="registrar-popup-summary-grid">
                <div>
                    <div class="registrar-popup-summary-label">Sender</div>
                    <div class="registrar-popup-summary-value"><?php echo registrarH($sender_name); ?></div>
                </div>
                <div>
                    <div class="registrar-popup-summary-label">Date Sent</div>
                    <div class="registrar-popup-summary-value"><?php echo registrarH($message_date !== '' ? $message_date : 'Not recorded'); ?></div>
                </div>
            </div>
            <div>
                <div class="registrar-popup-summary-label">Original Message</div>
                <div class="registrar-popup-summary-message"><?php echo registrarH($message_body !== '' ? $message_body : 'No message body was provided.'); ?></div>
            </div>
        </div>

        <form action="notificationprocess1.php" method="post" class="registrar-form-grid">
            <input type="hidden" name="ud_id" value="<?php echo registrarH($message_id); ?>">
            <input type="hidden" name="M_Reciever" value="<?php echo registrarH($reply_target_id); ?>">
            <input type="hidden" name="M_sender" value="<?php echo registrarH($current_user_id); ?>">

            <div class="registrar-form-field">
                <label class="registrar-label" for="reply-sender">Reply From</label>
                <input type="text" id="reply-sender" class="registrar-input" value="<?php echo registrarH($current_user_id); ?>" readonly>
            </div>

            <div class="registrar-form-field">
                <label class="registrar-label" for="reply-recipient">Reply To</label>
                <input type="text" id="reply-recipient" class="registrar-input" value="<?php echo registrarH($sender_name); ?>" readonly>
            </div>

            <div class="registrar-form-field full">
                <label class="registrar-label" for="reply-message">Reply Message</label>
                <textarea id="reply-message" name="message" class="registrar-textarea" rows="5" placeholder="Write your response to this message" required></textarea>
            </div>

            <div class="registrar-form-field full">
                <div class="registrar-actions">
                    <button type="submit" class="registrar-btn">Send Reply</button>
                    <button type="reset" class="registrar-btn-secondary">Clear</button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
</div>
