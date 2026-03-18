<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
  <style>
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
/* inline fallback when stylesheet isn't loaded: keep columns, spacing, and proportions */
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

    <!-- Header -->
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <!-- Menu -->
    <div id="menu">
        <?php require("menustud.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenustud.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">

				<div id="content" class="clearfix"> 
				<fieldset style="margin-left: -20px"><legend>Download Module</legend>
				<form action=" " method="post">   
                    <table>
                    <tr>
					<td>Department:</td>
                  <td>
                  
				
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");
                      $uid=$_SESSION['suid'];
					$d_program = mysql_query("SELECT * FROM student where S_ID='$uid'");
					if($getDprog = mysql_fetch_array($d_program)){
						$name = $getDprog['Department'];
				 ?>
				 <input type="text" name="dpt" value="<?php echo $name;?>" readonly style="height:30px; width:180px;"/>
					
				<?php } ?>
                    
                    </td><td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td rowspan="3">
					<input type="submit" value="Search"  name="search" style="font-size: 25;background-color: #003366;color: white"/></td>
                    </tr>
                    <tr>
					<td>Student Class Year:</td>
                  <td>
                <select name="scy"  class="login-form2" style="height:30px; width:180px;" required>
                <option selected="selected" value="">Select Student Class Year</option>
                        <option value="1st">1st</option>
						<option value="2nd">2nd</option>
						<option value="3rd">3rd</option>
						<option value="4th">4th</option>
						<option value="5th">5th</option>
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
	$scy=$_POST['scy'];
	$sem=$_POST['sem'];
							
include('../connection.php');
$result1 = mysql_query("SELECT * FROM course where other_department_takes like '%$dept%' and s_c_year like '%$scy%' and semister='$sem' and status='yes'");
		if($row1 = mysql_fetch_array($result1)){
			
?>
					<hr>
					<table cellpadding="1" cellspacing="1" id="resultTable">
						<thead>
							<tr>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Code </th>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Name </th>
								<th>Credit<br>Hour</th>
								<th>Student<br>class<br>year</th>
								<th>Semister</th>
							<th style="border-left: 1px solid #C1DAD7">Department</th> 
								<th>Year</th>
								<th>file name </th>
								<th>Download</th>	
								
							</tr>
						</thead>
						<tbody>
<?php
$result2 = mysql_query("SELECT * FROM course where other_department_takes like '%$dept%' and s_c_year like '%$scy%' and semister='$sem' and status='yes'");
							while($row0 = mysql_fetch_array($result2))
								{
									 $files=$row0['FileName'];
									echo '<tr>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['course_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['chour'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['s_c_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['semister'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['ayear'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row0['FileName'].'</td>';
print ("<td style='background-color: #243cdb;'><font size='4'>" ."<a style='color:#fffbfb;' href='../material/module/$files'><img width='30' height='30' src='userphoto/d1.jpg' /></a>". "</td>");
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
					 echo"Currently not uploaded Module";
					 }
					 
					}
					?>
					</fieldset>
				</div>
        </div>

        <!-- Right Sidebar -->
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
                        <li><a href="updateprofilephoto.php">Change Photo</a></li>
                        <li><a href="changepass.php">Change password</a></li>
                    </ul>
                </div>
            </div>
            <div id="siderightindexadational">
                <div id="siderightindexadational1">
                    Social link
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

    <!-- Footer -->
    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>