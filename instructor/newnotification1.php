<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

if (!instructorIsLoggedIn()) {
    exit('Unauthorized access.');
}

$userId = instructorCurrentUserId();
$date = date("Y-m-d");
$recipients = [];
$sql = "SELECT UID, Role FROM account
        WHERE UID <> ? AND Role IN ('department_head', 'registrar', 'instructor', 'student', 'collage_dean', 'cdeofficer')
        ORDER BY Role, UID";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $recipients[] = $row;
        }
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Message</title>
<?php instructorRenderPopupStyles(); ?>
</head>
<body>
<div class="instructor-popup-shell">
    <h2 class="instructor-popup-title">New Message</h2>
    <p class="instructor-popup-subtitle">Choose the receiver, write the message clearly, and send it directly from this popup.</p>
    <?php if ($recipients) { ?>
        <form action="newnotificationprocess1.php" method="post">
            <div class="instructor-popup-card">
                <div class="instructor-popup-grid">
                    <div class="instructor-popup-field">
                        <label for="popup-message-sender">Send By</label>
                        <input type="text" name="M_sender" id="popup-message-sender" value="<?php echo instructorH($userId); ?>" readonly>
                    </div>
                    <div class="instructor-popup-field">
                        <label for="popup-message-date">Date</label>
                        <input type="text" name="date_sended" id="popup-message-date" value="<?php echo instructorH($date); ?>" readonly>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="popup-message-receiver">Send To</label>
                        <select name="M_Reciever" id="popup-message-receiver" required>
                            <option value="">Select user ID</option>
                            <?php foreach ($recipients as $recipient) { ?>
                                <option value="<?php echo instructorH($recipient['UID'] ?? ''); ?>">
                                    <?php echo instructorH(($recipient['UID'] ?? '') . ' (' . ($recipient['Role'] ?? '') . ')'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="instructor-popup-field full">
                        <label for="popup-message-body">Message</label>
                        <textarea name="message" id="popup-message-body" required placeholder="Write your message"></textarea>
                    </div>
                </div>
                <div class="instructor-popup-actions">
                    <button type="reset" class="instructor-popup-btn secondary">Clear</button>
                    <button type="submit" class="instructor-popup-btn" name="submitMain">Send</button>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <div class="instructor-popup-empty">No valid receiver account is available for messaging right now.</div>
    <?php } ?>
</div>
</body>
</html>
