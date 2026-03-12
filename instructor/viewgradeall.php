<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Instructor page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menuins.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenuins.php");
?>
	
</td><td>
	<div id="contentindex5">
	<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
?>
<?php
if(isset($_POST['search']))
{
	$dept1=$_POST['dpt'];
	$scy1=$_POST['scy'];
	$sem1=$_POST['sem'];
	$sec1=$_POST['sec'];
	
$_SESSION['dpt']=$dept1;
$_SESSION['yea']=$scy1;
$_SESSION['sem']=$sem1;
$_SESSION['sec']=$sec1;
}
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
$sec=$_SESSION['sec'];
?>
<fieldset><legend><b>List of Students Grade report</b></legend>
<table><tr><td bgcolor="003366" width="100px" align="center"><a href="viewgrade.php"  style="color: #ffffff;font-size: 30px;text-decoration: none;">Back</a></td>
<form action="" method="post">
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php 
$count_item=mysql_query("SELECT * FROM grade where status='approved' and department='$dept' and year='$yea' and semister='$sem' and section='$sec'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?></p>	
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td bgcolor="#003366" width="120px" align="center"><a href="#.php"  style="color: #ffffff;font-size: 20px;text-decoration: none;">Post Grade</a></td>
</tr></table>	<br/>					
									<?php
$query1 =mysql_query("SELECT * FROM grade where status='approved' and department='$dept' and year='$yea' and semister='$sem' and section='$sec'" )
or die(mysql_error());
?>

<?php	
							
$sql = "SELECT * FROM grade where status='approved' and department='$dept' and year='$yea' and semister='$sem' and section='$sec'" ;
	 
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn, $sql, 1, 8);
 	//The paginate() function returns a mysql result set for the current page
	$rs = $pager->paginate();
							
							
	$count_my_message = mysql_num_rows($query1);	
	if ($count_my_message != '0'){
		while($row=mysql_fetch_array($rs))
		{
$id=$row['sid'];
$fn=$row['fname'];
$mn=$row['mname'];
$ln=$row['lname'];
$name=$fn.'  '.$mn.'  '.$ln;
$sex=$row['sex'];
$dept=$row['department'];
$yea=$row['year'];
$sem=$row['semister'];
$sec=$row['section'];
$c1=$row['c1'];
$c2=$row['c2'];
$c3=$row['c3'];
$c4=$row['c4'];
$c5=$row['c5'];
$c6=$row['c6'];
$c7=$row['c7'];
$ch1=$row['ch1'];
$ch2=$row['ch2'];
$ch3=$row['ch3'];
$ch4=$row['ch4'];
$ch5=$row['ch5'];
$ch6=$row['ch6'];
$ch7=$row['ch7'];
$g1=$row['g1'];
$g2=$row['g2'];
$g3=$row['g3'];
$g4=$row['g4'];
$g5=$row['g5'];
$g6=$row['g6'];
$g7=$row['g7'];

$tcr=$row['tcr'];
$tgp=$row['tgp'];
$cgpa=$row['cgpa'];
$pcgpa=$row['pcgpa'];
$ptc=$row['ptc'];
$ncgpa=$row['ncgpa'];	
		
?>
<table border="1" id="resultTable" cellspacing="0" width="100%" >
<tr>

<th bgcolor="#CAE8EA">Name</th>
<th><?php echo $name;?> </th>
<th bgcolor="#CAE8EA">ID_No</th>
<th><?php echo $id;?></th>
</tr>
<tr >
<th bgcolor="#CAE8EA">Sex</th>
<th colspan="3" align="left"><?php echo $sex;?></th>	
	
</tr>
<tr>
<th bgcolor="#CAE8EA">
Department:<br/>
Year:<br/>
Semister:<br/>
Section:
</th>
<th colspan="3" align="left">
<?php echo $dept;?><br/>
<?php echo $yea;?><br/>
<?php echo $sem;?><br/>
<?php echo $sec;?>
</th>	
</tr>
</table>
<br/>
<table border="1" id="resultTable" cellspacing="0" width="100%">
<tr bgcolor="#CAE8EA">
<th>Ctitle</th>
<th>Chour</th>
<th>Grade</th>
<th>Grade point</th>
</tr>
<tr>
<td><center><?php echo $c1;?></center></td>
<td><center><?php echo $ch1;?></center></td>
<td><center><?php echo $g1;?></center></td>
<td>
<center><?php 
if($g1=='A'|| $g1=='a')
$gp=$ch1*4;
else if($g1=='A+'|| $g1=='a+')
$gp=$ch1*4;
else if($g1=='A'|| $g1=='a')
$gp=$ch1*4;
else if($g1=='A-'|| $g1=='a-')
$gp=$ch1*3.75;
else if($g1=='B+'|| $g1=='b+')
$gp=$ch1*3.5;
else if($g1=='B'|| $g1=='b')
$gp=$ch1*3;
else if($g1=='B-'|| $g1=='b-')
$gp=$ch1*2.75;
else if($g1=='C+'|| $g1=='c+')
$gp=$ch1*2.5;
else if($g1=='C'|| $g1=='c')
$gp=$ch1*2;
else if($g1=='C-'|| $g1=='c-')
$gp=$ch1*1.75;
else if($g1=='D'|| $g1=='d')
$gp=$ch1*1;
else
$gp=$ch1*0;
echo $gp;?></center>
</td>
</tr>	
<tr>
<td><center><?php echo $c2;?></center></td>
<td><center><?php echo $ch2;?></center></td>
<td><center><?php echo $g2;?></center></td>
<td>
<center><?php 
if($g2=='A'|| $g2=='a')
$gp=$ch2*4;
else if($g2=='A+'|| $g2=='a+')
$gp=$ch2*4;
else if($g2=='A'|| $g2=='a')
$gp=$ch2*4;
else if($g2=='A-'|| $g2=='a-')
$gp=$ch2*3.75;
else if($g2=='B+'|| $g2=='b+')
$gp=$ch2*3.5;
else if($g2=='B'|| $g2=='b')
$gp=$ch2*3;
else if($g2=='B-'|| $g2=='b-')
$gp=$ch2*2.75;
else if($g2=='C+'|| $g2=='c+')
$gp=$ch2*2.5;
else if($g1=='C'|| $g2=='c')
$gp=$ch2*2;
else if($g2=='C-'|| $g2=='c-')
$gp=$ch2*1.75;
else if($g2=='D'|| $g2=='d')
$gp=$ch2*1;
else
$gp=$ch2*0;
echo $gp;?></center>
</td>
</tr>
<tr>
<td><center><?php echo $c3;?></center></td>
<td><center><?php echo $ch3;?></center></td>
<td><center><?php echo $g3;?></center></td>
<td>
<center><?php 
if($g3=='A'|| $g3=='a')
$gp=$ch3*4;
else if($g3=='A+'|| $g3=='a+')
$gp=$ch3*4;
else if($g3=='A'|| $g3=='a')
$gp=$ch3*4;
else if($g3=='A-'|| $g3=='a-')
$gp=$ch3*3.75;
else if($g3=='B+'|| $g3=='b+')
$gp=$ch3*3.5;
else if($g3=='B'|| $g3=='b')
$gp=$ch3*3;
else if($g3=='B-'|| $g3=='b-')
$gp=$ch3*2.75;
else if($g3=='C+'|| $g3=='c+')
$gp=$ch3*2.5;
else if($g3=='C'|| $g3=='c')
$gp=$ch3*2;
else if($g3=='C-'|| $g3=='c-')
$gp=$ch3*1.75;
else if($g3=='D'|| $g3=='d')
$gp=$ch3*1;
else
$gp=$ch3*0;
echo $gp;?></center>
</td>
</tr>
<tr>
<td><center><?php echo $c4;?></center></td>
<td><center><?php echo $ch4;?></center></td>
<td><center><?php echo $g4;?></center></td>
<td>
<center><?php 
if($g4=='A'|| $g4=='a')
$gp=$ch4*4;
else if($g4=='A+'|| $g4=='a+')
$gp=$ch4*4;
else if($g4=='A'|| $g4=='a')
$gp=$ch4*4;
else if($g4=='A-'|| $g4=='a-')
$gp=$ch4*3.75;
else if($g4=='B+'|| $g4=='b+')
$gp=$ch4*3.5;
else if($g4=='B'|| $g4=='b')
$gp=$ch4*3;
else if($g4=='B-'|| $g4=='b-')
$gp=$ch4*2.75;
else if($g4=='C+'|| $g4=='c+')
$gp=$ch4*2.5;
else if($g4=='C'|| $g4=='c')
$gp=$ch4*2;
else if($g4=='C-'|| $g4=='c-')
$gp=$ch4*1.75;
else if($g4=='D'|| $g4=='d')
$gp=$ch4*1;
else
$gp=$ch4*0;
echo $gp;?></center>
</td>
</tr>
<tr>
<td><center><?php echo $c5;?></center></td>
<td><center><?php echo $ch5;?></center></td>
<td><center><?php echo $g5;?></center></td>
<td>
<center><?php 
if($g5=='A'|| $g5=='a')
$gp=$ch5*4;
else if($g5=='A+'|| $g5=='a+')
$gp=$ch5*4;
else if($g5=='A'|| $g5=='a')
$gp=$ch5*4;
else if($g5=='A-'|| $g5=='a-')
$gp=$ch5*3.75;
else if($g5=='B+'|| $g5=='b+')
$gp=$ch5*3.5;
else if($g5=='B'|| $g5=='b')
$gp=$ch5*3;
else if($g5=='B-'|| $g5=='b-')
$gp=$ch5*2.75;
else if($g5=='C+'|| $g5=='c+')
$gp=$ch5*2.5;
else if($g5=='C'|| $g5=='c')
$gp=$ch5*2;
else if($g5=='C-'|| $g5=='c-')
$gp=$ch5*1.75;
else if($g5=='D'|| $g5=='d')
$gp=$ch5*1;
else
$gp=$ch5*0;
echo $gp;?></center>
</td>
</tr>
<tr>
<td><center><?php echo $c6;?></center></td>
<td><center><?php echo $ch6;?></center></td>
<td><center><?php echo $g6;?></center></td>
<td>
<center><?php 
if($g6=='A'|| $g6=='a')
$gp=$ch6*4;
else if($g6=='A+'|| $g6=='a+')
$gp=$ch6*4;
else if($g6=='A'|| $g6=='a')
$gp=$ch6*4;
else if($g6=='A-'|| $g6=='a-')
$gp=$ch6*3.75;
else if($g6=='B+'|| $g6=='b+')
$gp=$ch6*3.5;
else if($g6=='B'|| $g6=='b')
$gp=$ch6*3;
else if($g6=='B-'|| $g6=='b-')
$gp=$ch6*2.75;
else if($g6=='C+'|| $g6=='c+')
$gp=$ch6*2.5;
else if($g6=='C'|| $g6=='c')
$gp=$ch6*2;
else if($g6=='C-'|| $g6=='c-')
$gp=$ch6*1.75;
else if($g6=='D'|| $g6=='d')
$gp=$ch6*1;
else
$gp=$ch6*0;
echo $gp;?></center>
</td>
</tr>
<tr>
<td><center><?php echo $c7;?></center></td>
<td><center><?php echo $ch7;?></center></td>
<td><center><?php echo $g7;?></center></td>
<td>
<center><?php 
if($g7=='A'|| $g7=='a')
$gp=$ch7*4;
else if($g7=='A+'|| $g7=='a+')
$gp=$ch7*4;
else if($g7=='A'|| $g7=='a')
$gp=$ch7*4;
else if($g7=='A-'|| $g7=='a-')
$gp=$ch7*3.75;
else if($g7=='B+'|| $g7=='b+')
$gp=$ch7*3.5;
else if($g7=='B'|| $g7=='b')
$gp=$ch7*3;
else if($g7=='B-'|| $g7=='b-')
$gp=$ch7*2.75;
else if($g7=='C+'|| $g7=='c+')
$gp=$ch7*2.5;
else if($g7=='C'|| $g7=='c')
$gp=$ch7*2;
else if($g7=='C-'|| $g7=='c-')
$gp=$ch7*1.75;
else if($g7=='D'|| $g7=='d')
$gp=$ch7*1;
else
$gp=$ch7*0;
echo $gp;?></center>
</td>
</tr>
<tr>
	<th bgcolor="#CAE8EA">Total</th>
	<td><center><?php echo $tcr;?></center></td>
	<td></td>
	<td><center><?php echo $tgp;?></center></td>
</tr>
<tr>
	<th bgcolor="#CAE8EA">Semister AVG</th>
	
	<td colspan="3" bgcolor="blue" style="color: white;"><center><?php echo $cgpa;?></center></td>
	
</tr>	
</table>
<br/>
<table border="1" id="resultTable" cellspacing="0" width="100%">
<tr bgcolor="#CAE8EA">
<td></td>	
<td>Chours</td>
<td>Grade point</td>
<td>GPA</td>
</tr>
<tr>
<td bgcolor="#CAE8EA">Previous Total</td>	
<td><center><?php echo $ptc;?></center></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><center><?php echo $pcgpa;?></center></td>
</tr>	

<tr>
<td bgcolor="#CAE8EA">Semister Total</td>	
<td><center><?php echo $tcr;?></center></td>
<td><center><?php echo $tgp;?></center></td>
<td><center><?php echo $cgpa;?></center></td>
</tr>
<tr>
<td bgcolor="#CAE8EA">Comulative</td>	
<td><center><?php echo $ptc+$tcr;?></center></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td bgcolor="blue" style="color: white;"><center><?php echo $ncgpa;?></center></td>
</tr>
</table>
</form>
<?php
	echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';

								
								}
								}else{ ?>
								<div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
								<?php } ?>
									
                        <!-- /block -->
                
</fieldset>	

</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=#fffdfd>Welcome:</font><font color=#dbf428>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="#.html">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Another link 
	 </div>
	 <div id="siderightindexadational12">
	 <table>
	 <tr><td><div id="facebook"></div></td><td>
	<p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
	<tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
	<tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
	<tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>
	</div>
	 </div>
	  </td>
	 </tr>
	 <tr><td>
<?php
include("../footer.php");
?>
</td></tr>

</div>
</table>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
