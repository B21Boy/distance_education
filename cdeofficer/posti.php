<?php
require("popup_styles.php");

function cde_popup_read_docx($filename)
{
    $content = '';
    if (!$filename || !file_exists($filename)) {
        return false;
    }

    if (class_exists('ZipArchive')) {
        $zipArchive = new ZipArchive();
        if ($zipArchive->open($filename) !== true) {
            return false;
        }

        $documentIndex = $zipArchive->locateName('word/document.xml');
        if ($documentIndex === false) {
            $zipArchive->close();
            return false;
        }

        $content = $zipArchive->getFromIndex($documentIndex);
        $zipArchive->close();
    } elseif (function_exists('zip_open')) {
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
    } else {
        return false;
    }

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);

    return strip_tags($content);
}

$template_paths = array(
    dirname(__DIR__) . '/postu.docx',
    dirname(__DIR__) . '/department/postu.docx'
);
$template_content = false;
foreach ($template_paths as $template_path) {
    $template_content = cde_popup_read_docx($template_path);
    if ($template_content !== false) {
        break;
    }
}
if ($template_content !== false) {
    $template_content = str_replace(
        array('በደብረ ማርቆስ', 'ደብረ ማርቆስ'),
        array('በባህር ዳር', 'ባህር ዳር'),
        $template_content
    );
}
$date = date('Y-m-d');
?>
<div class="cde-popup-card">
    <div class="cde-popup-header">
        <span class="cde-popup-kicker">CDE Officer</span>
        <h1 class="cde-popup-title">Post Updated Information</h1>
        <p class="cde-popup-copy">Prepare a new notice and publish it to the announcement board.</p>
    </div>
    <form action="postedu.php" method="post" class="cde-popup-form">
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="title">
                Title
                <input type="text" name="title" id="title" class="cde-popup-input" value="ማስታወቂያ" required>
            </label>
            <label class="cde-popup-field" for="typ">
                Type
                <input type="text" name="typ" id="typ" class="cde-popup-input" value="ለርቀት ትምህርት መርሃ-ግብር ተማሪዎች በሙሉ" required>
            </label>
        </div>
        <label class="cde-popup-field" for="infor">
            Information
            <textarea name="infor" id="infor" class="cde-popup-textarea"><?php echo $template_content !== false ? htmlspecialchars($template_content, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
        </label>
        <div class="cde-popup-grid">
            <label class="cde-popup-field" for="date">
                Date
                <input type="text" name="date" id="date" class="cde-popup-input" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </label>
            <label class="cde-popup-field" for="edate">
                Expired Date
                <input type="date" name="edate" id="edate" class="cde-popup-input" required>
            </label>
        </div>
        <label class="cde-popup-field" for="pb">
            Posted By
            <input type="text" name="pb" id="pb" class="cde-popup-input" value="ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት ባህር ዳር ዩኒቨርስቲ" required>
        </label>
        <div class="cde-popup-actions">
            <button type="submit" value="Post" name="sent" class="cde-popup-btn">Post</button>
            <button type="reset" class="cde-popup-btn-secondary">Reset</button>
        </div>
    </form>
</div>
