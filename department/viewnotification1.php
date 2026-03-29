<?php
session_start();
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

if (!departmentIsLoggedIn()) {
    http_response_code(403);
    ?>
    <style>
    .department-reply-shell {
        width: min(100%, 720px);
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
    }
    .department-reply-alert {
        padding: 18px 20px;
        border: 1px solid #e4b2b2;
        border-radius: 18px;
        background: #fff5f5;
        color: #8f1f1f;
        font-weight: 700;
        line-height: 1.6;
    }
    </style>
    <div class="department-reply-shell">
        <div class="department-reply-alert">Your session has expired. Please sign in again.</div>
    </div>
    <?php
    exit;
}

$messageId = trim((string) ($_GET['M_ID'] ?? ''));
$currentUserId = departmentCurrentUserId();
$messageRow = null;
$errorMessage = '';

if ($messageId === '') {
    $errorMessage = 'The selected message could not be found.';
} else {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT m.M_ID, m.M_sender, m.M_Reciever, m.message, m.date_sended,
                COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), m.M_sender) AS sender_name
         FROM message AS m
         LEFT JOIN user AS u ON u.UID = m.M_sender
         WHERE m.M_ID = ? AND m.M_Reciever = ?
         LIMIT 1"
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $messageId, $currentUserId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            $messageRow = mysqli_fetch_assoc($result) ?: null;
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }

    if (!$messageRow) {
        $errorMessage = 'The selected message could not be loaded for your account.';
    }
}

$senderName = 'Unknown sender';
$replyTargetId = '';
$messageDate = '';
$messageBody = '';

if ($messageRow) {
    $senderName = trim((string) ($messageRow['sender_name'] ?? ''));
    if ($senderName === '') {
        $senderName = trim((string) ($messageRow['M_sender'] ?? 'Unknown sender'));
    }
    $replyTargetId = trim((string) ($messageRow['M_sender'] ?? ''));
    $messageDate = trim((string) ($messageRow['date_sended'] ?? ''));
    $messageBody = trim((string) ($messageRow['message'] ?? ''));
}
?>
<style>
#facebox .popup {
    border: none;
    border-radius: 28px;
    box-shadow: 0 28px 72px rgba(15, 23, 42, 0.24);
}

#facebox .content {
    display: block;
    width: 720px;
    max-width: calc(100vw - 32px);
    padding: 0;
    border-radius: 28px;
    background: transparent;
    overflow: hidden;
}

#facebox .close {
    top: 16px;
    right: 16px;
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(148, 163, 184, 0.28);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
}

#facebox .close img {
    display: none;
}

#facebox .close::before {
    content: "x";
    color: #34506b;
    font-size: 24px;
    line-height: 1;
}

#facebox_overlay.facebox_overlayBG {
    background: rgba(15, 23, 42, 0.66);
    backdrop-filter: blur(4px);
}

.department-reply-shell {
    width: min(100%, 720px);
    margin: 0 auto;
    font-family: Arial, Helvetica, sans-serif;
    color: #17324d;
}

.department-reply-card {
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
}

.department-reply-header {
    padding: 30px 30px 22px;
    background: linear-gradient(135deg, #0f3c68 0%, #1f6aa5 58%, #64a6d8 100%);
    color: #ffffff;
}

.department-reply-eyebrow {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-reply-header h2 {
    margin: 14px 0 10px;
    font-size: 28px;
    line-height: 1.2;
}

.department-reply-header p {
    margin: 0;
    color: rgba(255, 255, 255, 0.88);
    font-size: 15px;
    line-height: 1.7;
}

.department-reply-body {
    padding: 28px 30px 30px;
}

.department-reply-alert {
    padding: 18px 20px;
    border-radius: 18px;
    border: 1px solid #e4b2b2;
    background: #fff5f5;
    color: #8f1f1f;
    font-size: 14px;
    font-weight: 700;
    line-height: 1.6;
}

.department-reply-summary {
    display: grid;
    gap: 14px;
    margin-bottom: 24px;
    padding: 20px;
    border: 1px solid #d8e4f1;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
}

.department-reply-summary-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px 18px;
}

.department-reply-summary-label {
    color: #66809b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-reply-summary-value {
    margin-top: 6px;
    color: #17324d;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.6;
    word-break: break-word;
}

.department-reply-message {
    padding: 16px 18px;
    border-radius: 14px;
    border: 1px solid #d6e7f7;
    background: #f7fbff;
    color: #36516c;
    line-height: 1.7;
    white-space: pre-wrap;
    word-break: break-word;
}

.department-reply-form {
    display: grid;
    gap: 18px;
}

.department-reply-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 20px;
}

.department-reply-field {
    display: grid;
    gap: 8px;
}

.department-reply-field.full {
    grid-column: 1 / -1;
}

.department-reply-field label {
    color: #234766;
    font-size: 14px;
    font-weight: 700;
}

.department-reply-field input,
.department-reply-field textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #cfdceb;
    border-radius: 14px;
    background: #ffffff;
    color: #17324d;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.department-reply-field input {
    min-height: 48px;
    padding: 0 15px;
}

.department-reply-field textarea {
    min-height: 150px;
    padding: 14px 15px;
    resize: vertical;
    line-height: 1.7;
}

.department-reply-field input[readonly] {
    background: #f3f7fb;
    color: #617b95;
}

.department-reply-field input:focus,
.department-reply-field textarea:focus {
    outline: none;
    border-color: #2e78cb;
    box-shadow: 0 0 0 4px rgba(46, 120, 203, 0.12);
}

.department-reply-help {
    color: #6a8197;
    font-size: 13px;
    line-height: 1.6;
}

.department-reply-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.department-reply-actions button {
    min-height: 48px;
    padding: 0 20px;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
}

.department-reply-actions .is-primary {
    background: linear-gradient(135deg, #1f5fb6 0%, #2e84dd 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(31, 95, 182, 0.24);
}

.department-reply-actions .is-secondary {
    background: #eaf1f7;
    color: #24425f;
}

@media (max-width: 760px) {
    #facebox .content {
        max-width: calc(100vw - 20px);
    }

    .department-reply-header,
    .department-reply-body {
        padding-left: 20px;
        padding-right: 20px;
    }

    .department-reply-summary-grid,
    .department-reply-grid {
        grid-template-columns: 1fr;
    }

    .department-reply-actions button {
        width: 100%;
    }
}
</style>

<div class="department-reply-shell">
    <div class="department-reply-card">
        <div class="department-reply-header">
            <span class="department-reply-eyebrow">Reply Message</span>
            <h2>Respond to Notification</h2>
            <p>Review the unread message details and send your reply from this standard department popup.</p>
        </div>

        <div class="department-reply-body">
            <?php if ($errorMessage !== '') { ?>
            <div class="department-reply-alert"><?php echo departmentH($errorMessage); ?></div>
            <?php } else { ?>
            <div class="department-reply-summary">
                <div class="department-reply-summary-grid">
                    <div>
                        <div class="department-reply-summary-label">Sender</div>
                        <div class="department-reply-summary-value"><?php echo departmentH($senderName); ?></div>
                    </div>
                    <div>
                        <div class="department-reply-summary-label">Date Sent</div>
                        <div class="department-reply-summary-value"><?php echo departmentH($messageDate !== '' ? $messageDate : 'Not recorded'); ?></div>
                    </div>
                </div>
                <div>
                    <div class="department-reply-summary-label">Original Message</div>
                    <div class="department-reply-message"><?php echo departmentH($messageBody !== '' ? $messageBody : 'No message body was provided.'); ?></div>
                </div>
            </div>

            <form action="notificationprocess1.php" method="post" class="department-reply-form">
                <input type="hidden" name="ud_id" value="<?php echo departmentH($messageId); ?>">
                <input type="hidden" name="M_Reciever" value="<?php echo departmentH($replyTargetId); ?>">
                <input type="hidden" name="M_sender" value="<?php echo departmentH($currentUserId); ?>">

                <div class="department-reply-grid">
                    <div class="department-reply-field">
                        <label for="reply-sender">Reply From</label>
                        <input type="text" id="reply-sender" value="<?php echo departmentH($currentUserId); ?>" readonly>
                    </div>

                    <div class="department-reply-field">
                        <label for="reply-recipient">Reply To</label>
                        <input type="text" id="reply-recipient" value="<?php echo departmentH($senderName); ?>" readonly>
                    </div>

                    <div class="department-reply-field full">
                        <label for="reply-message">Reply Message</label>
                        <textarea id="reply-message" name="message" placeholder="Write your reply here" required></textarea>
                        <div class="department-reply-help">Your reply will be sent to the original sender, and this unread message will be marked as handled.</div>
                    </div>
                </div>

                <div class="department-reply-actions">
                    <button type="submit" class="is-primary">Send Reply</button>
                    <button type="reset" class="is-secondary">Clear</button>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</div>
