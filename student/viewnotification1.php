<?php
session_start();
require_once("../connection.php");

$messageId = trim((string) ($_GET['M_ID'] ?? ''));
$replyReceiver = '';
$replySender = '';

if ($messageId !== '') {
    $stmt = mysqli_prepare($conn, "SELECT M_sender, M_reciever FROM message WHERE M_ID = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $messageId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);

        if ($row) {
            $replyReceiver = trim((string) ($row['M_sender'] ?? ''));
            $replySender = trim((string) ($row['M_reciever'] ?? ''));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reply Message</title>
<style>
body { margin: 0; padding: 18px; font-family: "Times New Roman", Georgia, serif; background: #f4f8fc; color: #17364e; }
.modal-form { display: grid; gap: 14px; }
.modal-form label { display: grid; gap: 6px; font-weight: 700; }
.modal-form input, .modal-form textarea { width: 100%; padding: 10px 12px; border: 1px solid #c8dce7; border-radius: 10px; box-sizing: border-box; }
.modal-form textarea { resize: vertical; min-height: 110px; }
.modal-form button { padding: 11px 16px; border: 0; border-radius: 999px; background: linear-gradient(135deg, #0d5d8b, #2a87aa); color: #ffffff; font-weight: 700; cursor: pointer; }
.modal-note { margin: 0; color: #5d748b; font-size: 13px; }
</style>
</head>
<body>
<?php if ($messageId === '' || $replyReceiver === '' || $replySender === '') { ?>
    <p class="modal-note">The selected message could not be loaded for reply.</p>
<?php } else { ?>
    <form action="notificationprocess1.php" method="post" class="modal-form">
        <input type="hidden" name="ud_id" value="<?php echo htmlspecialchars($messageId, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="M_Reciever" value="<?php echo htmlspecialchars($replyReceiver, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="M_sender" value="<?php echo htmlspecialchars($replySender, ENT_QUOTES, 'UTF-8'); ?>">

        <label>
            Reply Message
            <textarea name="message" required></textarea>
        </label>

        <p class="modal-note">This reply will be sent back to the original sender and the current message will be marked as handled.</p>
        <button type="submit">Send Reply</button>
    </form>
<?php } ?>
</body>
</html>
