<?php
include('../connection.php');
require("popup_styles.php");

function cde_registration_notice_decode(string $value): string
{
    return html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$date = date('Y-m-d');
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$no = 0;
$tt = '';
$ty = '';
$edate = '';
$rsd = '';
$rend = '';
$inf = '';
$postedBy = "ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት ባህር ዳር ዩኒቨርስቲ";

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT no, Title, types, Ex_date, start_date, end_date, info, posted_by FROM postss WHERE no = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
        }
        mysqli_stmt_close($stmt);

        if (is_array($row)) {
            $no = (int) ($row['no'] ?? 0);
            $tt = cde_registration_notice_decode((string) ($row['Title'] ?? ''));
            $ty = cde_registration_notice_decode((string) ($row['types'] ?? ''));
            $edate = (string) ($row['Ex_date'] ?? '');
            $rsd = (string) ($row['start_date'] ?? '');
            $rend = (string) ($row['end_date'] ?? '');
            $inf = cde_registration_notice_decode((string) ($row['info'] ?? ''));
            $dbPostedBy = cde_registration_notice_decode((string) ($row['posted_by'] ?? ''));
            if (trim($dbPostedBy) !== '') {
                $postedBy = $dbPostedBy;
            }
        }
    }
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Update Registration Date</h1>
        <p class="cde-popup-copy">Edit the saved registration notice and update it directly from this popup.</p>
    </div>
    <form action="updateposted.php" method="post" class="cde-popup-form">
        <input type="hidden" name="no" value="<?php echo (int) $no; ?>">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="title">
                Title
                <input type="text" name="title" id="title" class="cde-popup-input" required value="<?php echo htmlspecialchars($tt, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="typ">
                Type
                <input type="text" name="typ" id="typ" class="cde-popup-input" required value="<?php echo htmlspecialchars($ty, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="date">
                Date
                <input type="text" name="date" id="date" class="cde-popup-input" readonly value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="exd">
                Expired Date
                <input type="date" name="exd" id="exd" class="cde-popup-input" required value="<?php echo htmlspecialchars($edate, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="sd">
                Registration Start Date
                <input type="date" name="sd" id="sd" class="cde-popup-input" required value="<?php echo htmlspecialchars($rsd, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="ed">
                Registration End Date
                <input type="date" name="ed" id="ed" class="cde-popup-input" required value="<?php echo htmlspecialchars($rend, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
        </div>
        <label class="cde-popup-field" for="infor">
            Information
            <textarea name="infor" id="infor" class="cde-popup-textarea" required placeholder="Write information here"><?php echo htmlspecialchars($inf, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </label>
        <label class="cde-popup-field" for="pb">
            Posted By
            <input type="text" name="pb" id="pb" class="cde-popup-input" value="<?php echo htmlspecialchars($postedBy, ENT_QUOTES, 'UTF-8'); ?>" required>
        </label>
        <input type="hidden" name="st" value="register">
        <div class="cde-popup-actions">
            <button type="submit" name="submit" class="cde-popup-btn">Update</button>
            <button type="reset" name="clear" class="cde-popup-btn-secondary">Clear</button>
        </div>
    </form>
</div>
