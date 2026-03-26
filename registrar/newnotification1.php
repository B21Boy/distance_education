<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

$user_id = isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
$date = date("Y-m-d");
$recipients = [];

$result = mysqli_query($conn, "SELECT UID FROM account WHERE Role IN ('department_head', 'instructor', 'collage_dean', 'cdeofficer') ORDER BY UID ASC");
if ($result instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $uid = trim((string) ($row['UID'] ?? ''));
        if ($uid !== '') {
            $recipients[] = $uid;
        }
    }
    mysqli_free_result($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Registrar Message</title>
<?php registrarRenderStandardStyles(); ?>
<style>
body {
    margin: 0;
    padding: 14px;
    background: transparent;
    font-family: Arial, Helvetica, sans-serif;
}
.registrar-popup-card {
    width: min(100%, 620px);
    margin: 0 auto;
}
</style>
</head>
<body>
<div class="registrar-page-card registrar-popup-card">
    <div class="registrar-page-header">
        <span class="registrar-page-eyebrow">Compose Message</span>
        <h1 class="registrar-page-title">New Notification</h1>
        <p class="registrar-page-copy">Send a message from the registrar office to academic leaders and instructors in a clear, standard format.</p>
    </div>

    <form action="newnotificationprocess1.php" method="post" class="registrar-form-grid">
        <div class="registrar-form-field">
            <label class="registrar-label" for="message-sender">Send By</label>
            <input type="text" id="message-sender" name="M_sender" class="registrar-input" value="<?php echo registrarH($user_id); ?>" readonly>
        </div>

        <div class="registrar-form-field">
            <label class="registrar-label" for="message-date">Date</label>
            <input type="text" id="message-date" name="date_sended" class="registrar-input" value="<?php echo registrarH($date); ?>" readonly>
        </div>

        <div class="registrar-form-field full">
            <label class="registrar-label" for="message-recipient">Send To</label>
            <select name="M_Reciever" id="message-recipient" class="registrar-select" required>
                <option value="">Select user ID</option>
                <?php foreach ($recipients as $recipient): ?>
                    <option value="<?php echo registrarH($recipient); ?>"><?php echo registrarH($recipient); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="registrar-form-field full">
            <label class="registrar-label" for="message-body">Message</label>
            <textarea id="message-body" name="message" class="registrar-textarea" rows="5" placeholder="Write the message you want to send" required></textarea>
        </div>

        <div class="registrar-form-field full">
            <div class="registrar-actions">
                <button type="submit" name="submitMain" class="registrar-btn">Send Message</button>
                <button type="reset" class="registrar-btn-secondary">Clear</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
