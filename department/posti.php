
<form action="postedu.php" method="post">
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Post New Information</center></td></tr>

<tr><td>Title:</td><td><input type="text"name="title" size="32" value="ማስታወቂያ" style="width: 300px"></td></tr>
<tr><td>Type:</td><td><input type="text"name="typ" size="32" value="ለርቀት ትምህርት መርሃ-ግብር ተማሪዎች በሙሉ"  style="width: 300px"></td></tr>

<tr><td><b>Information:</b></td><td>
<textarea name="infor" id="infor" cols="50" rows="7">
	
<?php
function read_file_docx($filename){

    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);

    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }// end while

    zip_close($zip);
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}
$filename = "C:\wamp\www\cde[1]\department\postu.docx";// or /var/www/html/file.docx

$content = read_file_docx($filename);
if($content !== false) {

    echo ($content);
}
else {
    echo 'Couldn\'t the file. Please check that file.';
}
$date=date('Y-m-d');
?>	
	
</textarea></td></tr>
<tr><td>Date:</td><td><input type="text" name="date" size="32" value="<?php echo $date;?>" readonly style="width: 300px"></td></tr>
<tr><td>Expired Date:</td><td><input type="date" name="edate" size="32" id="date"  style="width: 300px"></td></tr>
<tr><td>Posted By:</td><td><input type="text" name="pb" style="width: 300px"  value="ትምህርት ክፍሉ ደብረ ማርቆስ ዩኒቨርስቲ"/></td></tr>
<tr><td></td><td>
<input type="submit" value="Post" name="sent" />
<input type="reset" value="Reset" /> 
</td></tr></table>
</form>

