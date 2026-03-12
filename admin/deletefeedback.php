<?php
include('../connection.php');

$idd=$_GET['id'];
 $sql = mysql_query("delete from feed_back where email='$idd'")or die(mysql_error());
 if($sql)
 {
$x='<script type="text/javascript">alert("Deleted Successfully!!!");window.location=\'viewfeedback.php\';</script>';
echo $x;	
 }
?>