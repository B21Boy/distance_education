<?php
require_once(__DIR__ . "/../connection.php");
require("popup_styles.php");

function cde_application_notice_decode(string $value): string
{
    return html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$date = date('Y-m-d');
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$no = 0;
$title = '';
$type = '';
$expiredDate = '';
$startDate = '';
$endDate = '';
$information = '';
$postedBy = "ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት ባህር ዳር ዩኒቨርስቲ";
$status = 'apply';

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT no, Title, types, Ex_date, start_date, end_date, info, posted_by, status FROM postss WHERE no = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $dbNo, $dbTitle, $dbType, $dbExpiredDate, $dbStartDate, $dbEndDate, $dbInformation, $dbPostedBy, $dbStatus);

        if (mysqli_stmt_fetch($stmt)) {
            $no = (int) $dbNo;
            $title = cde_application_notice_decode((string) $dbTitle);
            $type = cde_application_notice_decode((string) $dbType);
            $expiredDate = (string) $dbExpiredDate;
            $startDate = (string) $dbStartDate;
            $endDate = (string) $dbEndDate;
            $information = cde_application_notice_decode((string) $dbInformation);

            $savedPostedBy = cde_application_notice_decode((string) $dbPostedBy);
            if (trim($savedPostedBy) !== '') {
                $postedBy = $savedPostedBy;
            }

            $savedStatus = trim((string) $dbStatus);
            if ($savedStatus !== '') {
                $status = $savedStatus;
            }
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Update Application Date</h1>
        <p class="cde-popup-copy">Edit the saved application notice and update it directly from this popup.</p>
    </div>
    <form action="updateposteda.php" method="post" class="cde-popup-form">
        <input type="hidden" name="no" value="<?php echo (int) $no; ?>">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="title">
                Title
                <input type="text" name="title" id="title" class="cde-popup-input" required value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="typ">
                Type
                <input type="text" name="typ" id="typ" class="cde-popup-input" required value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="date">
                Date
                <input type="text" name="date" id="date" class="cde-popup-input" readonly value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="exd">
                Expired Date
                <input type="date" name="exd" id="exd" class="cde-popup-input" required value="<?php echo htmlspecialchars($expiredDate, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="sd">
                Application Start Date
                <input type="date" name="sd" id="sd" class="cde-popup-input" required value="<?php echo htmlspecialchars($startDate, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="ed">
                Application End Date
                <input type="date" name="ed" id="ed" class="cde-popup-input" required value="<?php echo htmlspecialchars($endDate, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <label class="cde-popup-field" for="infor">
            Information
            <textarea name="infor" id="infor" class="cde-popup-textarea" required placeholder="Write information here"><?php echo htmlspecialchars($information, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </label>
        <label class="cde-popup-field" for="pb">
            Posted By
            <input type="text" name="pb" id="pb" class="cde-popup-input" value="<?php echo htmlspecialchars($postedBy, ENT_QUOTES, 'UTF-8'); ?>" required>
        </label>
        <input type="hidden" name="st" value="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="cde-popup-actions">
            <button type="submit" name="submit" class="cde-popup-btn">Update</button>
            <button type="reset" name="clear" class="cde-popup-btn-secondary">Clear</button>
        </div>
        <?php if ($no === 0) { ?>
        <p class="cde-popup-note">The requested application notice was not found. Close this popup and reopen it from the notice list.</p>
        <?php } ?>
    </form>
</div>
