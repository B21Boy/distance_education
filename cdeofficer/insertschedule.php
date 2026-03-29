<?php
include("../connection.php");
require("popup_styles.php");

function cde_popup_read_docx($filename)
{
    $content = '';
    if (!$filename || !file_exists($filename)) {
        return false;
    }

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) {
        return false;
    }

    while ($zip_entry = zip_read($zip)) {
        if (zip_entry_open($zip, $zip_entry) == false) {
            continue;
        }
        if (zip_entry_name($zip_entry) != "word/document.xml") {
            continue;
        }
        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
        zip_entry_close($zip_entry);
    }
    zip_close($zip);

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);

    return strip_tags($content);
}

$template_path = __DIR__ . '/Land Admin.docx';
$template_content = cde_popup_read_docx($template_path);
$scheduleInformation = $template_content !== false ? $template_content : "Template file could not be loaded. Please check cdeofficer/Land Admin.docx.";
$postedBy = "ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት";

$latestSchedule = mysqli_query($conn, "SELECT * FROM module_schedule ORDER BY no DESC LIMIT 1");
if ($latestSchedule instanceof mysqli_result) {
    $existingSchedule = mysqli_fetch_assoc($latestSchedule);
    mysqli_free_result($latestSchedule);
    if (is_array($existingSchedule)) {
        if (isset($existingSchedule['information']) && trim((string) $existingSchedule['information']) !== '') {
            $scheduleInformation = (string) $existingSchedule['information'];
        }
        if (isset($existingSchedule['posted_by']) && trim((string) $existingSchedule['posted_by']) !== '') {
            $postedBy = (string) $existingSchedule['posted_by'];
        }
    }
}
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Update Module Preparation Schedule</h1>
        <p class="cde-popup-copy">Review the generated schedule text before posting it to the module schedule board.</p>
    </div>
    <form action="posteschedule.php" method="post" class="cde-popup-form">
        <label class="cde-popup-field" for="infor">
            Schedule Information
            <textarea name="infor" id="infor" class="cde-popup-textarea" required><?php echo htmlspecialchars($scheduleInformation, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </label>
        <label class="cde-popup-field" for="pb">
            Posted By
            <input type="text" id="pb" name="pb" class="cde-popup-input" value="<?php echo htmlspecialchars($postedBy, ENT_QUOTES, 'UTF-8'); ?>" required>
        </label>
        <div class="cde-popup-actions">
            <button type="submit" name="submit" class="cde-popup-btn">Send</button>
            <button type="reset" name="clear" class="cde-popup-btn-secondary">Clear</button>
        </div>
    </form>
</div>
