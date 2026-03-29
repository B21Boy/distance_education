<?php
include("../connection.php");
$date=date('Y/m/d');
?>
<form action="posted.php" method="post">
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Post Application Date</center></td></tr>

<tr><td>Title:</td><td><input type="text" name="title" size="32"  required placeholder="Enter the title" style="width: 300px"/>
</td></tr>
<tr><td>Type:</td><td><input type="text" name="typ" size="32" required placeholder="Enter the type" style="width: 300px"/></td></tr>
<tr><td>Date:</td><td><input type="text" name="date" size="32"  readonly  value="<?php echo $date;?>" style="width: 300px"/></td></tr>
<tr><td>Expired Date:</td><td><input type="date" name="exd" size="32"  required style="width: 300px"/></td></tr>
<tr><td>Application Start Date:</td><td><input type="date" name="sd" size="32"  required style="width: 300px"/></td></tr>
<tr><td>Application End Date:</td><td><input type="date" name="ed" size="32"  required  style="width: 300px"/></td></tr>
<tr><td><b>Information:</b></td><td>
<textarea name="infor" required  cols="34" rows="7" style="width: 300px">
	
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

 $filename = "C:\wamp\www\cde[1]\posta.docx";// or /var/www/html/file.docx

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
<tr><td>Posted By:</td><td><input type="text" style="width: 300px" name="pb"  value="ተከታታይና ርቀት ትምህርት ማስተባበሪያ ዳይሬክቶሬት ባህር ዳር  ዩኒቨርስቲ" readonly/></td></tr>
<tr><td></td><td><input type="hidden" style="width: 300px" name="st"  value="apply" readonly/></td></tr>
<tr><td></td>
<td><input type="submit"  name="submit" value="Send" style="height: 40px;width: 120px;"id="m"/>
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="m"/> </td>

</tr>
</table>
</form>

