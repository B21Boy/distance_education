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
	     				mysql_connect("localhost","root","");
						mysql_select_db("cde");
						$id=$_SESSION['suid'];
?>
	
</div><div id="content">
	<div id="contentindex5">

<fieldset style="margin-left: -20px;"><legend>Post Student Course Result</legend>
<form action="viewcourseresult.php" method="post">   
                    <table>
                    <tr>
					<td>Select Department:</td>
                  <td>
					<select name="dpt"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select department--</option>
                        <?php
						
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
				  <td>Section:</td>
                  <td>
					<select name="sec"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select Section--</option>
                        <?php
					
					$d_program3 = mysql_query("SELECT DISTINCT section FROM assign_instructor where uid='$id'");
			
					while($getDprog3 = mysql_fetch_array($d_program3)){
						$sec= $getDprog3['section'];
				 ?>
					<option value="<?php echo $sec;  ?>"><?php echo $sec; ?></option>
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
 						
 						 						<tr>				    			  
				  <td>Send To:</td>
                  <td>
					<select name="uu"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select Department Code--</option>
                        <?php
					
					$d_program3 = mysql_query("SELECT DISTINCT department FROM assign_instructor where uid='$id'");
					while($getDprog3 = mysql_fetch_array($d_program3)){
					$de= $getDprog3['department'];
					$d_program4 = mysql_query("SELECT * from department where DName='$de'");
					$getDprog4 = mysql_fetch_array($d_program4);
						$u= $getDprog4['Dcode'];
				 ?>
					<option value="<?php echo $u;  ?>"><?php echo $u; ?></option>
				<?php } ?>
                    </select>
                    </td>
 
 						</tr>
 						</table>
                 </form>
                 

</fieldset>
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
