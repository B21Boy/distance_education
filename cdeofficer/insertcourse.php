<?php
session_start();
include("../connection.php");
$idd=$_SESSION['suid'];
?>
<?php
if (isset($_POST['submit1'])) {
if (
   !empty($_POST['id']) && !empty($_POST['a1']) &&
   is_array($_POST['id']) && is_array($_POST['a1']) &&
   count($_POST['id']) === count($_POST['a1'])
) {
	$y=date('Y');
    $name_array = $_POST['id'];
    $age_array = $_POST['a1'];
    $age_array1 = $_POST['st'];
    for ($i = 0; $i < count($name_array); $i++) {
        $id = mysql_real_escape_string($name_array[$i]);
        $as = mysql_real_escape_string($age_array[$i]);
		$st = mysql_real_escape_string($age_array1[$i]);
$sql=mysql_query("INSERT INTO entrance_exam  VALUES (' ','$id','$as','$y','$st',' ')")or die(mysql_error());
    											} 
    											 if($sql){
$x='<script type="text/javascript">alert("Successfully Posted !!!");window.location=\'recordresult.php\';</script>';
echo $x;
	   } 
	}
						}
?>

