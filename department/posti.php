<?php
function departmentReadDocxContent(string $filename): string
{
    if ($filename === '' || !file_exists($filename) || !class_exists('ZipArchive')) {
        return '';
    }

    $zip = new ZipArchive();
    if ($zip->open($filename) !== true) {
        return '';
    }

    $content = $zip->getFromName('word/document.xml') ?: '';
    $zip->close();

    if ($content === '') {
        return '';
    }

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
    $content = str_replace('</w:r></w:p>', PHP_EOL, $content);
    return trim(strip_tags($content));
}

$date = date('Y-m-d');
$defaultInfo = departmentReadDocxContent(__DIR__ . '/postu.docx');
?>
<style>
.department-popup-form {
    width: min(100%, 620px);
    padding: 12px;
    font-family: Arial, Helvetica, sans-serif;
}
.department-popup-form table {
    width: 100%;
    border-collapse: collapse;
}
.department-popup-form td {
    padding: 8px 6px;
    vertical-align: top;
}
.department-popup-form input[type="text"],
.department-popup-form input[type="date"],
.department-popup-form textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #c8d8e8;
    border-radius: 10px;
    box-sizing: border-box;
}
.department-popup-form textarea {
    min-height: 180px;
    resize: vertical;
}
.department-popup-actions {
    display: flex;
    gap: 10px;
}
.department-popup-actions input {
    min-height: 40px;
    padding: 0 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
}
.department-popup-actions input[type="submit"] {
    background: #215fb8;
    color: #ffffff;
}
.department-popup-actions input[type="reset"] {
    background: #e9eef5;
    color: #294663;
}
</style>
<form action="postedu.php" method="post" class="department-popup-form">
<table cellpadding="5" border="0">
<tr><td colspan="2"><center><strong>Post New Information</strong></center></td></tr>
<tr><td>Title:</td><td><input type="text" name="title" value="ማስታወቂያ" required></td></tr>
<tr><td>Type:</td><td><input type="text" name="typ" value="ለርቀት ትምህርት መርሃ-ግብር ተማሪዎች በሙሉ" required></td></tr>
<tr>
<td><b>Information:</b></td>
<td><textarea name="infor" id="infor" required><?php echo htmlspecialchars($defaultInfo, ENT_QUOTES, 'UTF-8'); ?></textarea></td>
</tr>
<tr><td>Date:</td><td><input type="text" name="date" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>" readonly></td></tr>
<tr><td>Expired Date:</td><td><input type="date" name="edate" id="date"></td></tr>
<tr><td>Posted By:</td><td><input type="text" name="pb" value="ትምህርት ክፍሉ ደብረ ማርቆስ ዩኒቨርስቲ" required></td></tr>
<tr>
<td></td>
<td>
    <div class="department-popup-actions">
        <input type="submit" value="Post" name="sent">
        <input type="reset" value="Reset">
    </div>
</td>
</tr>
</table>
</form>
