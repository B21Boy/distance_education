<?php
include("../connection.php");
require("popup_styles.php");

function cde_registration_popup_read_docx($filename)
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

$date = date('Y-m-d');
$templatePath = dirname(__DIR__) . '/postr.docx';
$templateContent = cde_registration_popup_read_docx($templatePath);
$information = $templateContent !== false ? $templateContent : '';
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Post Registration Date</h1>
        <p class="cde-popup-copy">Create a new registration-date notice and post it to the board.</p>
    </div>
    <form action="posted.php" method="post" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="title">
                Title
                <input type="text" name="title" id="title" class="cde-popup-input" required placeholder="Enter the title">
            </label>
            <label class="cde-popup-field" for="typ">
                Type
                <input type="text" name="typ" id="typ" class="cde-popup-input" required placeholder="Enter the type">
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="date">
                Date
                <input type="text" name="date" id="date" class="cde-popup-input" readonly value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label class="cde-popup-field" for="exd">
                Expired Date
                <input type="date" name="exd" id="exd" class="cde-popup-input" required>
            </label>
        </div>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="sd">
                Registration Start Date
                <input type="date" name="sd" id="sd" class="cde-popup-input" required>
            </label>
            <label class="cde-popup-field" for="ed">
                Registration End Date
                <input type="date" name="ed" id="ed" class="cde-popup-input" required>
            </label>
        </div>
        <label class="cde-popup-field" for="infor">
            Information
            <textarea name="infor" id="infor" class="cde-popup-textarea" required placeholder="Write information here"><?php echo htmlspecialchars($information, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </label>
        <label class="cde-popup-field" for="pb">
            Posted By
            <input type="text" name="pb" id="pb" class="cde-popup-input" value="ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት ባህር ዳር ዩኒቨርስቲ" required>
        </label>
        <input type="hidden" name="st" value="register">
        <div class="cde-popup-actions">
            <button type="submit" name="submit" class="cde-popup-btn">Send</button>
            <button type="reset" name="clear" class="cde-popup-btn-secondary">Clear</button>
        </div>
        <?php if ($templateContent === false) { ?>
        <p class="cde-popup-note">The registration template file was not loaded, so the information field is left editable for manual entry.</p>
        <?php } ?>
    </form>
</div>
