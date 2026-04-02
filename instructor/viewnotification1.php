<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    exit('Unauthorized access.');
}

$messageId = isset($_GET['M_ID']) ? trim((string) $_GET['M_ID']) : '';
$currentUserId = instructorCurrentUserId();
$messageRow = null;

if ($messageId !== '') {
    $stmt = mysqli_prepare($conn, "SELECT M_ID, M_sender, M_reciever FROM message WHERE M_ID = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $messageId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result instanceof mysqli_result) {
            $messageRow = mysqli_fetch_assoc($result) ?: null;
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reply Message</title>
<?php instructorRenderPopupStyles(); ?>
</head>
<body>
<div class="instructor-popup-shell">
    <h2 class="instructor-popup-title">Reply Message</h2>
    <p class="instructor-popup-subtitle">Write your reply below and send it back to the original sender.</p>
    <?php if ($messageRow && ($messageRow['M_reciever'] ?? '') === $currentUserId) { ?>
        <form action="notificationprocess1.php" method="post">
            <input type="hidden" name="ud_id" value="<?php echo instructorH($messageRow['M_ID'] ?? ''); ?>">
            <input type="hidden" name="M_Reciever" value="<?php echo instructorH($messageRow['M_sender'] ?? ''); ?>">
            <div class="instructor-popup-card">
                <div class="instructor-popup-grid">
                    <div class="instructor-popup-field">
                        <label for="popup-reply-sender">Reply From</label>
                        <input type="text" id="popup-reply-sender" value="<?php echo instructorH($currentUserId); ?>" readonly>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-reply-receiver">Reply To</label>
                        <input type="text" id="popup-reply-receiver" value="<?php echo instructorH($messageRow['M_sender'] ?? ''); ?>" readonly>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="popup-reply-message">Message</label>
                        <textarea name="message" id="popup-reply-message" required placeholder="Write your reply"></textarea>
                    </div>
                </div>
                <div class="instructor-popup-actions">
                    <button type="reset" class="instructor-popup-btn secondary">Clear</button>
                    <button type="submit" class="instructor-popup-btn">Send Reply</button>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <div class="instructor-popup-empty">The selected message could not be opened for reply.</div>
    <?php } ?>
</div>
</body>
</html>
