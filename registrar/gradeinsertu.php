
<?php
session_start();
include("../connection.php");
if(isset($_POST['reg']))
{
$id=$_SESSION['sid'];
$fn=$_SESSION['fn'];
$mn=$_SESSION['mn'];
$ln=$_SESSION['ln'];
$sex=$_SESSION['sex'];
$dept=$_SESSION['dpt'];
$yea=$_SESSION['id1'];
$sem=$_SESSION['id2'];
$sec=$_SESSION['sec'];
$c1=$_POST['c1'];
$c2=$_POST['c2'];
$c3=$_POST['c3'];
$c4=$_POST['c4'];
$c5=$_POST['c5'];
$c6=$_POST['c6'];
$c7=$_POST['c7'];
$ch1=$_POST['CR1'];
$ch2=$_POST['CR2'];
$ch3=$_POST['CR3'];
$ch4=$_POST['CR4'];
$ch5=$_POST['CR5'];
$ch6=$_POST['CR6'];
$ch7=$_POST['CR7'];
$g1=$_POST['GR1'];
$g2=$_POST['GR2'];
$g3=$_POST['GR3'];
$g4=$_POST['GR4'];
$g5=$_POST['GR5'];
$g6=$_POST['GR6'];
$g7=$_POST['GR7'];

$tcr=$_POST['tcr'];
$tgp=$_POST['tgp'];
$cgpa=$_POST['resultcurgpa'];
$pcgpa=$_POST['cumGPA'];
$ptc=$_POST['cumCredits'];
$ncgpa=$_POST['resultcumgpa'];	



     $con = mysql_connect('localhost', 'root', '') or die(mysql_error());
           $db = mysql_select_db('cde', $con);
           if($db){

$mm=mysql_query("insert into grade values(' ','$id','$fn','$mn','$ln','$sex','$dept','$yea','$sem','$sec','$c1','$c2','$c3','$c4','$c5','$c6','$c7','$ch1','$ch2','$ch3','$ch4','$ch5','$ch6','$ch7','$g1','$g2','$g3','$g4','$g5','$g6','$g7','$tcr','$tgp','$cgpa','$pcgpa','$ptc','$ncgpa',' ')")or die(mysql_error()); 
          if($mm){
$x='<script type="text/javascript">alert("Successfully registerd!!!!");
window.location=\'gpau.php\';</script>';
echo $x;
		  }
           else {
             echo"<script language=\"javascript\" type=\"text/javascript\">alert('Uploading  is Failed')</script>";

               }
		            }
}
?>