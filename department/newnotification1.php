<?php
session_start();
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

if (!departmentIsLoggedIn()) {
    http_response_code(403);
    ?>
    <style>
    .department-compose-shell {
        width: min(100%, 720px);
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
    }
    .department-compose-alert {
        padding: 18px 20px;
        border: 1px solid #e4b2b2;
        border-radius: 18px;
        background: #fff5f5;
        color: #8f1f1f;
        font-weight: 700;
        line-height: 1.6;
    }
    </style>
    <div class="department-compose-shell">
        <div class="department-compose-alert">Your session has expired. Please sign in again.</div>
    </div>
    <?php
    exit;
}

$currentUserId = departmentCurrentUserId();
$currentDate = date('Y-m-d');
$recipients = [];

$recipientResult = mysqli_query(
    $conn,
    "SELECT a.UID, u.fname, u.lname
     FROM account AS a
     LEFT JOIN user AS u ON u.UID = a.UID
     WHERE a.Role IN ('department_head', 'registrar', 'instructor', 'collage_dean', 'cdeofficer')
     ORDER BY a.UID ASC"
);
if ($recipientResult instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($recipientResult)) {
        $uid = trim((string) ($row['UID'] ?? ''));
        if ($uid === '') {
            continue;
        }

        $fullName = trim((string) (($row['fname'] ?? '') . ' ' . ($row['lname'] ?? '')));
        $label = $fullName !== '' ? $uid . ' - ' . $fullName : $uid;

        $recipients[] = [
            'uid' => $uid,
            'label' => $label
        ];
    }
    mysqli_free_result($recipientResult);
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

.department-compose-shell {
    width: min(100%, 720px);
    margin: 0 auto;
    font-family: Arial, Helvetica, sans-serif;
    color: #17324d;
}

.department-compose-card {
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%);
}

.department-compose-header {
    padding: 30px 30px 22px;
    background: linear-gradient(135deg, #0f3c68 0%, #1f6aa5 58%, #64a6d8 100%);
    color: #ffffff;
}

.department-compose-eyebrow {
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

.department-compose-header h2 {
    margin: 14px 0 10px;
    font-size: 28px;
    line-height: 1.2;
}

.department-compose-header p {
    margin: 0;
    color: rgba(255, 255, 255, 0.88);
    font-size: 15px;
    line-height: 1.7;
}

.department-compose-body {
    padding: 28px 30px 30px;
}

.department-compose-summary {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.department-compose-summary-card {
    padding: 16px 18px;
    border: 1px solid #dbe7f2;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
}

.department-compose-summary-label {
    color: #66809b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.department-compose-summary-value {
    margin-top: 8px;
    color: #17324d;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.6;
    word-break: break-word;
}

.department-compose-form {
    display: grid;
    gap: 18px;
}

.department-compose-field {
    display: grid;
    gap: 8px;
}

.department-compose-field label {
    color: #234766;
    font-size: 14px;
    font-weight: 700;
}

.department-compose-field input,
.department-compose-field select,
.department-compose-field textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #cfdceb;
    border-radius: 14px;
    background: #ffffff;
    color: #17324d;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.department-compose-field input,
.department-compose-field select {
    min-height: 48px;
    padding: 0 15px;
}

.department-compose-field textarea {
    min-height: 170px;
    padding: 14px 15px;
    resize: vertical;
    line-height: 1.7;
}

.department-compose-field input[readonly] {
    background: #f3f7fb;
    color: #617b95;
}

.department-compose-field input:focus,
.department-compose-field select:focus,
.department-compose-field textarea:focus {
    outline: none;
    border-color: #2e78cb;
    box-shadow: 0 0 0 4px rgba(46, 120, 203, 0.12);
}

.department-compose-help {
    color: #6a8197;
    font-size: 13px;
    line-height: 1.6;
}

.department-compose-empty {
    padding: 18px 20px;
    border: 1px dashed #b8cce2;
    border-radius: 16px;
    background: #f8fbff;
    color: #4e6680;
    font-weight: 600;
}

.department-compose-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.department-compose-actions button {
    min-height: 48px;
    padding: 0 20px;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
}

.department-compose-actions .is-primary {
    background: linear-gradient(135deg, #1f5fb6 0%, #2e84dd 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(31, 95, 182, 0.24);
}

.department-compose-actions .is-secondary {
    background: #eaf1f7;
    color: #24425f;
}

.department-compose-actions button:disabled {
    cursor: not-allowed;
    opacity: 0.65;
    box-shadow: none;
}

@media (max-width: 760px) {
    #facebox .content {
        max-width: calc(100vw - 20px);
    }

    .department-compose-header,
    .department-compose-body {
        padding-left: 20px;
        padding-right: 20px;
    }

    .department-compose-summary {
        grid-template-columns: 1fr;
    }

    .department-compose-actions button {
        width: 100%;
    }
}
</style>

<div class="department-compose-shell">
    <div class="department-compose-card">
        <div class="department-compose-header">
            <span class="department-compose-eyebrow">Compose Message</span>
            <h2>New Notification</h2>
            <p>Send a new message from the department office using the same cleaner popup style as the updated reply form.</p>
        </div>

        <div class="department-compose-body">
            <div class="department-compose-summary">
                <div class="department-compose-summary-card">
                    <div class="department-compose-summary-label">Send By</div>
                    <div class="department-compose-summary-value"><?php echo departmentH($currentUserId); ?></div>
                </div>
                <div class="department-compose-summary-card">
                    <div class="department-compose-summary-label">Date</div>
                    <div class="department-compose-summary-value"><?php echo departmentH($currentDate); ?></div>
                </div>
            </div>

            <form action="newnotificationprocess1.php" method="post" class="department-compose-form">
                <div class="department-compose-field">
                    <label for="message-sender">Send By</label>
                    <input type="text" id="message-sender" name="M_sender" value="<?php echo departmentH($currentUserId); ?>" readonly>
                </div>

                <div class="department-compose-field">
                    <label for="message-date">Date</label>
                    <input type="text" id="message-date" name="date_sended" value="<?php echo departmentH($currentDate); ?>" readonly>
                </div>

                <div class="department-compose-field">
                    <label for="message-recipient">Send To</label>
                    <select id="message-recipient" name="M_Reciever" required>
                        <option value="">Select recipient</option>
                        <?php foreach ($recipients as $recipient) { ?>
                        <option value="<?php echo departmentH($recipient['uid']); ?>"><?php echo departmentH($recipient['label']); ?></option>
                        <?php } ?>
                    </select>
                    <?php if (!$recipients) { ?>
                    <div class="department-compose-empty">No available recipients were found for this message.</div>
                    <?php } ?>
                </div>

                <div class="department-compose-field">
                    <label for="message-body">Message</label>
                    <textarea id="message-body" name="message" placeholder="Write the message you want to send" required></textarea>
                    <div class="department-compose-help">The message will be delivered as a new unread notification for the selected user.</div>
                </div>

                <div class="department-compose-actions">
                    <button type="submit" class="is-primary" <?php echo $recipients ? '' : 'disabled'; ?>>Send Message</button>
                    <button type="reset" class="is-secondary" <?php echo $recipients ? '' : 'disabled'; ?>>Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>
