<?php
include '../connection.php';
$title=mysql_real_escape_string($_POST['title']);
$typ=mysql_real_escape_string($_POST['typ']);
$infor=mysql_real_escape_string($_POST['infor']);
$date=mysql_real_escape_string($_POST['date']);
$exdate=mysql_real_escape_string($_POST['edate']);
$pb=mysql_real_escape_string($_POST['pb']);
$sql="INSERT INTO postss (Title,types,dates,Ex_date,info,posted_by)VALUES('$title','$typ','$date','$exdate','$infor','$pb')";
$result=mysql_query($sql);
if(!$result)
{
$x='<script type="text/javascript">alert("Error! not Posted!");
window.location=\'updateposti.php\';</script>';
echo $x;
}
else
{
$x='<script type="text/javascript">alert("Succssfully Posted!!!");
window.location=\'updateposti.php\';</script>';
echo $x;
}
?>

