
<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
Instructor page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
  <style>
  .main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
  hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 3px solid #ca3d24;
    margin: 1em 0;
    padding: 0; 
}
fieldset{
    border: 2px solid #3cb353;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menuins.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenuins.php");
?>
	
</div><div id="content">
	<div id="contentindex5">
				<div class="clearfix"> 
				<fieldset style="margin-left: -20px;"><legend>Please Select The Following Field</legend>
				<form action=" " method="post">   
                    <table>
                    <tr>
					<td>Select Department:</td>
                  <td>
					<select name="dpt"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select department--</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");
						$id=$_SESSION['suid'];
					$d_program = mysql_query("SELECT DISTINCT department FROM assign_instructor where uid='$id'");
			
					while($getDprog = mysql_fetch_array($d_program)){
						$name = $getDprog['department'];
				 ?>
					<option value="<?php echo $name;  ?>"><?php echo $name; ?></option>
				<?php } ?>
                    </select>
                    </td>
                    <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td rowspan="3">
					<input type="submit" value="Search"  name="search" style="font-size: 25;background-color: #003366;color: white"/></td>
                    </tr>
                   <tr>
					<td>Student Class Year:</td>
                 <td>
					<select name="scy"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select Class Year--</option>
                        <?php
					
					$d_program1 = mysql_query("SELECT DISTINCT Student_class_year FROM assign_instructor where uid='$id'");
			
					while($getDprog1 = mysql_fetch_array($d_program1)){
						$scy = $getDprog1['Student_class_year'];
				 ?>
					<option value="<?php echo $scy;  ?>"><?php echo $scy; ?></option>
				<?php } ?>
                    </select>
                    </td>	
					</tr>
					<tr>				    			  
				  <td>Semister:</td>
                  <td>
					<select name="sem"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select Semister--</option>
                        <?php
						
					$d_program2 = mysql_query("SELECT DISTINCT semister FROM assign_instructor where uid='$id'");
			
					while($getDprog2 = mysql_fetch_array($d_program2)){
						$sem = $getDprog2['semister'];
				 ?>
					<option value="<?php echo $sem;  ?>"><?php echo $sem; ?></option>
				<?php } ?>
                    </select>
                    </td>
 
 						</tr>
 							<tr>				    			  
				  <td>Course Code:</td>
                  <td>
     <select  name="cc"  class="login-form2" style="height:30px; width:180px;"  required>
      <option selected="selected" value="">Select course code</option>
   <?php
				
					$d_program4 = mysql_query("SELECT DISTINCT corse_code FROM assign_instructor where uid='$id'");
			
					while($getDprog4 = mysql_fetch_array($d_program4)){
						$cc = $getDprog4['corse_code'];
				 ?>
					<option value="<?php echo $cc;  ?>"><?php echo $cc; ?></option>
				<?php } ?>
				    </select>
				    </td>
 
 						</tr>
 						</table>
                 </form>
<?php
if(isset($_POST["search"]) && isset($_POST['dpt']))
{
	$dept=$_POST['dpt'];
	$scy=$_POST['scy'];
	$sem=$_POST['sem'];
	$cc=$_POST['cc'];
							
include('../connection.php');
$result1 = mysql_query("SELECT * FROM assignment where department='$dept' and Student_class_year='$scy' and semister='$sem' and status='stud' and ccode='$cc'");
		if($row1 = mysql_fetch_array($result1)){
			
?>
					<hr>
					<table cellpadding="1" cellspacing="1" id="resultTable" >
						<thead>
							<tr>
							   <th  style="border-left: 1px solid #C1DAD7">Student ID</th>
							    <th  style="border-left: 1px solid #C1DAD7">Asignment<br>Number </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>Student<br>class<br>year</th>
								<th>semister</th>
								<th>Submited<br>date</th>
								<th>file name </th>
								<th>Download</th>
							</tr>
						</thead>
						<tbody>
<?php
$result2 = mysql_query("SELECT * FROM assignment where department='$dept' and Student_class_year='$scy' and semister='$sem' and status='stud' and ccode='$cc'");
while($row2 = mysql_fetch_array($result2))
								{
								$files=$row2['fileName'];
									echo '<tr>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['U_ID'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['asno'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['ccode'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['semister'].'</td>';
									echo '<td><div align="right">'.$row2['Submission_date'].'</div></td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['fileName'].'</td>';
					print ("<td><font size='3.5'>" ."<a href='../material/assignment/$files'><img width='30' height='30' src='images/d1.jpg' /></a>". "</td>");
									echo '</tr>';	
									}
?>

					</table>
					<?php
					 }
					 else{
					 	echo'<hr>';
					 	 echo"There is No Submitted Assignment";
					 }
					
					}
					?>
					</fieldset>
				</div>
				</div>
</div>
	 <div id="sidebar">
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
	  </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>
<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
