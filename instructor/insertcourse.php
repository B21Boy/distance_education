<?php
session_start();
include("../connection.php");
$idd=$_SESSION['suid'];
?>
<?php
if (isset($_POST['submit2'])) {
if (
   !empty($_POST['id']) && !empty($_POST['a1']) &&
   is_array($_POST['id']) && is_array($_POST['a1'])&&
     count($_POST['id']) === count($_POST['a1'])
){
    				$dpt=$_SESSION['sdpt'];
				    $scy=$_SESSION['sscy'];
					$sec=$_SESSION['ssec'];
					$sem=$_SESSION['ssem'];
					$ccc=$_SESSION['scc'];
    $name_array = $_POST['id'];
    $age_array = $_POST['a1'];
    $age_array2 = $_POST['f'];
    $age_array3 = $_POST['t'];
    
    

    for ($i = 0; $i < count($name_array); $i++) {


        $id = mysql_real_escape_string($name_array[$i]);
        $as = mysql_real_escape_string($age_array[$i]);
        $ff = mysql_real_escape_string($age_array2[$i]);
		$tt = mysql_real_escape_string($age_array3[$i]);
		
		

		
		$total=$ff+$tt;
		if($total>=90)
		$grade='A+';
		else if($total<90 && $total>=85)
		$grade='A';
		else if($total<85 && $total>=80)
		$grade='A-';
		else if($total<80 && $total>=75)
		$grade='B+';
		else if($total<75 && $total>=70)
		$grade='B';
		else if($total<70 && $total>=65)
		$grade='B-';
		else if($total<65 && $total>=60)
		$grade='C+';
		else if($total<60 && $total>=50)
		$grade='C';
		else if( $total<50 && $total>=45)
		$grade='C-';
		else if($total<45 && $total>=40)
		$grade='D';
		else if($total<40 && $total>=30)
		$grade='FX';
		else
		$grade='F';
	$gv=$grade;
$sql=mysql_query("update course_result set Final='$ff',Total='$total',Grade='$gv' where S_ID='$id' and Department='$dpt' and year='$scy' and semister='$sem' and section='$sec' and C_Code='$ccc'")or die(mysql_error());

      
    											}
 if($sql){
$x='<script type="text/javascript">alert("Successfully Record !!!");window.location=\'postresult.php\';</script>';
echo $x;
	   } 
	}
						}

?>
<?php
if (isset($_POST['submit1'])) {
if (
   !empty($_POST['id']) && !empty($_POST['a1']) &&
   is_array($_POST['id']) && is_array($_POST['a1']) &&
   count($_POST['id']) === count($_POST['a1'])
) {
    $name_array = $_POST['id'];
    $age_array = $_POST['a1'];
    $age_array1 = $_POST['cc'];
    for ($i = 0; $i < count($name_array); $i++) {
    				$dpt=$_SESSION['sdpt'];
				    $scy=$_SESSION['sscy'];
					$sec=$_SESSION['ssec'];
					$sem=$_SESSION['ssem'];

        $id = mysql_real_escape_string($name_array[$i]);
        $as = mysql_real_escape_string($age_array[$i]);
        $ccc = mysql_real_escape_string($age_array1[$i]);
$total=$as+0;
$sql=mysql_query("INSERT INTO course_result (S_ID,uid,C_Code,Department,year,semister,section,Assignment,Total,status) VALUES ('$id','$idd','$ccc','$dpt','$scy','$sem','$sec','$as','$total','post')")or die(mysql_error());
    											} 
    											 if($sql){
$x='<script type="text/javascript">alert("Successfully Record !!!");window.location=\'postresult.php\';</script>';
echo $x;
	   } 
	}
						}
?>

