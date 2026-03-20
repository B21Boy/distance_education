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
				<fieldset><legend>Please Select The following Field</legend>
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
                <select name="scy"  class="login-form2" style="height:30px; width:180px;" required>
                <option selected="selected" value="">Select Student Class Year</option>
                        <option value="1st">1st</option>
						<option value="2nd" >2nd</option>
						<option value="3rd" >3rd</option>
						<option value="4th" >4th</option>
						<option value="5th" >5th</option>
				    </select>
				    </td>	
					</tr>
                   <tr>				    			  
				  <td>Semister:</td>
                  <td>
     <select  name="sem"  class="login-form2" style="height:30px; width:180px;"  required>
      <option selected="selected" value="">Select Semister</option>
                        <option value="I">I</option>
						<option value="II">II</option>
						<option value="III">III</option>
				    </select>
				    </td>
 
 						</tr>

 						</table>
                 </form>
<?php
if(isset($_POST["search"]) && isset($_POST['dpt']))
{
	$dept=$_POST['dpt'];
	$sem=$_POST['sem'];
	$scy=$_POST['scy'];
	include('../connection.php');
$result1 = mysql_query("SELECT * FROM assignment where department='$dept' and semister='$sem' and Student_class_year='$scy'");
		if($row1 = mysql_fetch_array($result1)){
?>
					<hr>
					<table cellpadding="1" cellspacing="1" id="resultTable" >
						<thead>
							<tr>
							    <th  style="border-left: 1px solid #C1DAD7">Assignment<br>Number </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>Student<br>class<br>year</th>
								<th>semister</th>
								<th>Submission<br>date</th>
								<th>file name </th>
							</tr>
						</thead>
						<tbody>
						<?php
							include('../connection.php');
	$result = mysql_query("SELECT * FROM assignment where department='$dept' and semister='$sem' and Student_class_year='$scy'");
							while($row = mysql_fetch_array($result))
								{
						
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['asno'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['ccode'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['semister'].'</td>';
									echo '<td><div align="right">'.$row['Submission_date'].'</div></td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['fileName'].'</td>';
									echo '</tr>';
								}
							?> 
						</tbody>
					</table>
					
					<?php
					}
					 else
					 {
					 	echo'<hr>';
					 echo" There is no uploaded Assignment";
					 }
					 
					}
					?>
					</fieldset>
				</div>
				</div></div>
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
