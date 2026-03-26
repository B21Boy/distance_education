<?php
session_start();
include("../connection.php");
require("popup_styles.php");

$user_id = $_SESSION['suid'];
$date = date("Y-m-d");
$receivers = array();
$result = mysql_query("select UID from account where Role='department_head' or Role='registrar' or Role='collage_dean' or Role='financestaff'");
while ($row = mysql_fetch_array($result)) {
    $receivers[] = $row['UID'];
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">New Message</h1>
        <p class="cde-popup-copy">Send a new internal message to the relevant office or staff account.</p>
    </div>
    <form action="newnotificationprocess1.php" method="post" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="M_sender">
                Send By
                <input type="text" name="M_sender" id="M_sender" class="cde-popup-input" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </label>
            <label class="cde-popup-field" for="M_Reciever">
                Send To
                <select name="M_Reciever" id="M_Reciever" class="cde-popup-select" required>
                    <option value="">Select User Id</option>
                    <?php foreach ($receivers as $receiver_id) { ?>
                    <option value="<?php echo htmlspecialchars($receiver_id, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($receiver_id, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>
        <label class="cde-popup-field" for="message">
            Message
            <textarea rows="5" name="message" id="message" class="cde-popup-textarea" required></textarea>
        </label>
        <label class="cde-popup-field" for="date_sended">
            Date
            <input type="text" name="date_sended" id="date_sended" class="cde-popup-input" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>" readonly>
        </label>
        <div class="cde-popup-actions">
            <button type="submit" class="cde-popup-btn" name="submitMain">Send</button>
            <button type="reset" class="cde-popup-btn-secondary">Clear</button>
        </div>
    </form>
</div>
