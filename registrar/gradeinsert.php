
<?php
session_start();
include("../connection.php");
if(isset($_POST['reg']))
{
$id=$_SESSION['sid'];
$dept=$_POST['dpt'];
$yea=$_POST['yea'];
$sem=$_POST['sem'];
$sec=$_POST['sec'];

$tcr=$_POST['tcr'];
$tgp=$_POST['tgp'];
$cgpa=$_POST['resultcurgpa'];
$pcgpa=$_POST['cumGPA'];
$ptch=$_POST['cumCredits'];
$ptgpoint=$_POST['cumCredits'];
$ncgpa=$_POST['resultcumgpa'];	



     $con = mysql_connect('localhost', 'root', '') or die(mysql_error());
           $db = mysql_select_db('cde', $con);
           if($db){

$mm=mysql_query("insert into grade values(' ','$id','$fn','$mn','$ln','$sex','$dept','$yea','$sem','$sec','$c1','$c2','$c3','$c4','$c5','$c6','$c7','$ch1','$ch2','$ch3','$ch4','$ch5','$ch6','$ch7','$g1','$g2','$g3','$g4','$g5','$g6','$g7','$tcr','$tgp','$cgpa','$pcgpa','$ptc','$ncgpa',' ')")or die(mysql_error()); 
          if($mm){
$x='<script type="text/javascript">alert("Successfully registerd!!!!");
window.location=\'gpa.php\';</script>';
echo $x;
		  }
           else {
             echo"<script language=\"javascript\" type=\"text/javascript\">alert('Uploading  is Failed')</script>";

               }
		            }
}
?>