
	<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
Registrar Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>

</head>
<body class="light-theme">
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
    require("menuro.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenuro.php");
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
  <script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,widtd=900, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("print_content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('<html><head><title>List of Passer</title>'); 
<script src="theme.js"></script>
   docprint.document.write('</head><body onLoad="self.print()" style="width:600px;border:-10px solid red;margin-left:400px; font-size:16px; font-family:TimesNewRoman;">');          
   docprint.document.write(content_vlue);          
   docprint.document.write('</body></html>'); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
<div id="print_content">
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
$co=mysql_query("SELECT * FROM grade where department='$dept' and  section='$sec' and status='approved' and checking='pending'");
$c=mysql_num_rows($co);
if($c>='1'){
?>
<fieldset><legend><b>List of Students Grade report</b></legend>
<form action="" method="post">
<table><tr><td bgcolor="003366" width="100px" align="center"><a href="viewgrade.php"  style="color: #ffffff;font-size: 30px;text-decoration: none;">Back</a></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php 
$count_item=mysql_query("SELECT * FROM grade where department='$dept'  and section='$sec' and status='approved'  and checking='pending'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?></p>	
</td></tr></table>	<br/>					
<?php	
							
$sql = "SELECT * FROM grade where department='$dept' and section='$sec' and status='approved' and checking='pending'" ;
	$pager = new PS_Pagination($conn, $sql, 1, 1);
	$rs = $pager->paginate();											
$stcr=0;
$stgp=0;
$scgpa=0;
$ncgpa=0;
while($row1=mysql_fetch_array($rs))
	{
$id=$row1['sid'];
$ss=mysql_query("SELECT * FROM student where S_ID='$id'" ) or die(mysql_error());
if($row=mysql_fetch_array($ss))
{
$fn=$row['FName'];
$mn=$row['mname'];
$ln=$row['LName'];
$name=$fn.'  '.$mn.'  '.$ln;
$sex=$row['Sex'];
$dept1=$row['Department'];
$yea1=$row['year'];
$sem1=$row['semister'];
$sec1=$row['section'];
}
			
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
<?php echo $dept1;?><br/>
<?php echo $yea1;?><br/>
<?php echo $sem1;?><br/>
<?php echo $sec1;?>
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
<?php
$sql0 = "SELECT * FROM course_result where department='$dept1' and year='$yea1' and semister='$sem1' and section='$sec1' and S_ID='$id' and status='approved' and status2='pending'" ;
$re=mysql_query($sql0);	
while($row11=mysql_fetch_array($re))
	{
$cc=$row11['C_Code'];
$g=$row11['Grade'];
$query1 = "select * from course where course_code='$cc'";
$result1 = mysql_query($query1);
$rr=mysql_fetch_array($result1);
$ch1=$rr['chour'];

?>
<tr>
<td><center><?php echo $cc;?></center></td>
<td><center><?php echo $ch1;?></center></td>
<td><center><?php echo $g;?></center></td>
<td>
<center><?php 

 if($g=='A+'|| $g=='a+')
$gp=$ch1*4;
else if($g=='A' || $g=='a')
$gp=$ch1*4;
else if($g=='A-'|| $g=='a-')
$gp=$ch1*3.75;
else if($g=='B+'|| $g=='b+')
$gp=$ch1*3.5;
else if($g=='B'|| $g=='b')
$gp=$ch1*3;
else if($g=='B-'|| $g=='b-')
$gp=$ch1*2.75;
else if($g=='C+'|| $g=='c+')
$gp=$ch1*2.5;
else if($g=='C'|| $g=='c')
$gp=$ch1*2;
else if($g=='C-'|| $g=='c-')
$gp=$ch1*1.75;
else if($g=='D'|| $g=='d')
$gp=$ch1*1;
else
$gp=$ch1*0;
echo $gp;?></center>
</td>
</tr>	
<?php
$stcr=$ch1+$stcr;
$stgp=$gp+$stgp;
$scgpa=$stgp/$stcr;

}
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
$sec=$_SESSION['sec'];

$qq=mysql_query("SELECT * FROM grade where department='$dept' and section='$sec' and sid='$id' and status='approved' and checking='pending'");
if($rq=mysql_fetch_array($qq))
{
$ptch=$rq['stcrh'];
$ptgp=$rq['stgpoint'];
$pcgpa=$rq['sgpa'];	
}


?>
<tr>
	<th bgcolor="#CAE8EA">Total</th>
	<td><center><?php echo $stcr;?></center></td>
	<td></td>
	<td><center><?php echo $stgp;?></center></td>
</tr>
<tr>
	<th bgcolor="#CAE8EA">Semister AVG</th>
	
	<td colspan="3" bgcolor="blue" style="color: white;"><center><?php echo round($scgpa,2);?></center></td>
	
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
<td><center><?php echo $ptch;?></center></td>
<td><center><?php echo $ptgp;?></center></td>
<td><center><?php echo $pcgpa;?></center></td>
</tr>	

<tr>
<td bgcolor="#CAE8EA">Semister Total</td>	
<td><center><?php echo $stcr;?></center></td>
<td><center><?php echo $stgp;?></center></td>
<td><center><?php 
$s=round($scgpa,2);
 echo $s;?></center></td>
</tr>
<tr>
<td bgcolor="#CAE8EA">Comulative</td>	
<td><center><?php echo $ptch+$stcr;?></center></td>
<td><center><?php echo $ptgp+$stgp;?></center></td>
<?php
$ncgpa=($ptgp+$stgp)/($ptch+$stcr);
$n=round($ncgpa,2);
?>
<td bgcolor="blue" style="color: white;"><center><?php echo $n;?></center></td>
</tr>
<?php
include("../connection.php");
mysql_query("insert into grade values(' ','$id','$dept','$yea','$sem','$sec','$stcr','$stgp','$s','$ptch','$ptgp','$pcgpa','$n','approve','pending')");
mysql_query("update grade set checking='ok' where department='$dept' and year='$yea' and sid='$id' and status='approved' and checking='pending'");
?>
</table>
</form>
<?php
	echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';

								}
		echo'</fieldset>';
		
		
		
				
}
else
{ 
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
$sec=$_SESSION['sec'];
?>
<fieldset><legend><b>List of Students Grade report</b></legend>
<form action="" method="post">
<table><tr><td bgcolor="003366" width="100px" align="center"><a href="viewgrade.php"  style="color: #ffffff;font-size: 30px;text-decoration: none;">Back</a></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
<p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php 
$count_item=mysql_query("SELECT DISTINCT S_ID FROM course_result where department='$dept' and year='$yea' and semister='$sem' and section='$sec' and status='approved' and status2='pending'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);	
echo"<font color='red'>".($count)."</font>"; ?></p>	
</td></tr></table>	<br/>					
<?php	
	if($count>='1')
	{						
$sql = "SELECT DISTINCT S_ID FROM course_result where department='$dept' and year='$yea' and semister='$sem' and section='$sec' and status='approved' and status2='pending'" ;
	$pager = new PS_Pagination($conn, $sql, 1, 1);
	$rs = $pager->paginate();											
$stcr=0;
$stgp=0;
$scgpa=0;
$ncgpa=0;
while($row1=mysql_fetch_array($rs))
	{
$id=$row1['S_ID'];
$ss=mysql_query("SELECT * FROM student where S_ID='$id'" ) or die(mysql_error());
if($row=mysql_fetch_array($ss))
{
$fn=$row['FName'];
$mn=$row['mname'];
$ln=$row['LName'];
$name=$fn.'  '.$mn.'  '.$ln;
$sex=$row['Sex'];
$dept=$row['Department'];
$yea=$row['year'];
$sem=$row['semister'];
$sec=$row['section'];
}
			
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
<?php


$sql0 = "SELECT * FROM course_result where department='$dept' and year='$yea' and semister='$sem' and section='$sec' and S_ID='$id' and status='approved' and status2='pending'" ;
$re=mysql_query($sql0);	
while($row11=mysql_fetch_array($re))
	{
$cc=$row11['C_Code'];
$g=$row11['Grade'];
$query1 = "select * from course where course_code='$cc'";
$result1 = mysql_query($query1);
$rr=mysql_fetch_array($result1);
$ch1=$rr['chour'];

?>
<tr>
<td><center><?php echo $cc;?></center></td>
<td><center><?php echo $ch1;?></center></td>
<td><center><?php echo $g;?></center></td>
<td>
<center><?php 

 if($g=='A+'|| $g=='a+')
$gp=$ch1*4;
else if($g=='A' || $g=='a')
$gp=$ch1*4;
else if($g=='A-'|| $g=='a-')
$gp=$ch1*3.75;
else if($g=='B+'|| $g=='b+')
$gp=$ch1*3.5;
else if($g=='B'|| $g=='b')
$gp=$ch1*3;
else if($g=='B-'|| $g=='b-')
$gp=$ch1*2.75;
else if($g=='C+'|| $g=='c+')
$gp=$ch1*2.5;
else if($g=='C'|| $g=='c')
$gp=$ch1*2;
else if($g=='C-'|| $g=='c-')
$gp=$ch1*1.75;
else if($g=='D'|| $g=='d')
$gp=$ch1*1;
else
$gp=$ch1*0;
echo $gp;?></center>
</td>
</tr>	
<?php
$stcr=$ch1+$stcr;
$stgp=$gp+$stgp;
$scgpa=$stgp/$stcr;

$ptch=0;
$ptgp=0;
$pcgpa=0;
}
?>
<tr>
	<th bgcolor="#CAE8EA">Total</th>
	<td><center><?php echo $stcr;?></center></td>
	<td></td>
	<td><center><?php echo $stgp;?></center></td>
</tr>
<tr>
	<th bgcolor="#CAE8EA">Semister AVG</th>
	
	<td colspan="3" bgcolor="blue" style="color: white;"><center><?php echo round($scgpa,2);?></center></td>
	
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
<td><center><?php echo $ptch;?></center></td>
<td><center><?php echo $ptgp;?></center></td>
<td><center><?php echo $pcgpa;?></center></td>
</tr>	

<tr>
<td bgcolor="#CAE8EA">Semister Total</td>	
<td><center><?php echo $stcr;?></center></td>
<td><center><?php echo $stgp;?></center></td>
<td><center><?php
$s=round($scgpa,2);
 echo $s;?></center></td>
</tr>
<tr>
<td bgcolor="#CAE8EA">Comulative</td>	
<td><center><?php echo $ptch+$stcr;?></center></td>
<td><center><?php echo $ptgp+$stgp;?></center></td>
<?php
$ncgpa=($ptgp+$stgp)/($ptch+$stcr);
$n=round($ncgpa,2);
?>
<td bgcolor="blue" style="color: white;"><center><?php echo $n; ?></center></td>
</tr>
<?php
include("../connection.php");
mysql_query("insert into grade values(' ','$id','$dept','$yea','$sem','$sec','$stcr','$stgp','$s','$ptch','$ptgp','$pcgpa','$n','approve','pending')");

?>
</table>
</form>
<center><a href="javascript:Clickheretoprint()"><font size="5"color="#3d80c2">Print it Now!</font></a>	</center>
<?php
	echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';

								}
	}	
	else
	echo" No New request Found";
//mysql_query("update course_result set status2='ok' where department='$dept' and year='$yea' and semister='$sem' and section='$sec' and  status='approved' and status2='pending'")or die(mysql_query());							
}
?>
</fieldset>	

</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#f9160b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
?>
<div id="sidebarr">
<ul>
 <li><a href="#.html">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
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
