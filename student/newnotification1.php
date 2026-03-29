<?php
session_start();
require_once("../connection.php");

$userId = isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
$instructors = array();

$stmt = mysqli_prepare($conn, "SELECT UID FROM account WHERE Role = 'instructor' ORDER BY UID ASC");
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $instructors[] = $row;
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
<style>
body { margin: 0; padding: 18px; font-family: "Times New Roman", Georgia, serif; background: #f4f8fc; color: #17364e; }
.modal-form { display: grid; gap: 14px; }
.modal-form label { display: grid; gap: 6px; font-weight: 700; }
.modal-form input, .modal-form select, .modal-form textarea { width: 100%; padding: 10px 12px; border: 1px solid #c8dce7; border-radius: 10px; box-sizing: border-box; }
.modal-form textarea { resize: vertical; min-height: 110px; }
.modal-form button { padding: 11px 16px; border: 0; border-radius: 999px; background: linear-gradient(135deg, #0d5d8b, #2a87aa); color: #ffffff; font-weight: 700; cursor: pointer; }
.modal-note { margin: 0; color: #5d748b; font-size: 13px; }
</style>
</head>
<body>
<form action="newnotificationprocess1.php" method="post" class="modal-form">
    <label>
        Send By
        <input type="text" name="M_sender" value="<?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </label>

    <label>
        Send To
        <select name="M_Reciever" required>
            <option value="">Select instructor</option>
            <?php foreach ($instructors as $instructor) { ?>
                <option value="<?php echo htmlspecialchars($instructor['UID'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($instructor['UID'] ?? '', ENT_QUOTES, 'UTF-8'); ?></option>
            <?php } ?>
        </select>
    </label>

    <label>
        Message
        <textarea name="message" required></textarea>
    </label>

    <p class="modal-note">The message will be stored immediately and marked unread for the selected instructor.</p>
    <button type="submit" name="submitMain">Send Message</button>
</form>
</body>
</html>
