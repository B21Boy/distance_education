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
<?php
$uid=$_SESSION['suid'];
$dpt=$_SESSION['sdpt'];
$sem=$_SESSION['ssemister'];
$sec=$_SESSION['ssection'];
$yea=$_SESSION['syear'];
							
include('../connection.php');
$result1 = mysql_query("SELECT * FROM assignment where department='$dpt' and Student_class_year='$yea' and semister='$sem'and status='inst' ORDER BY Submission_date DESC");
		if($row1 = mysql_fetch_array($result1)){
			
?>
					<hr>
					<table cellpadding="1" cellspacing="1" id="resultTable">
						<thead>
							<tr>
							<th  style="border-left: 1px solid #C1DAD7">Instructor Name</th>
							    <th  style="border-left: 1px solid #C1DAD7">Assignment<br>Number </th>
							    <th  style="border-left: 1px solid #C1DAD7">Assignment<br>Value</th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>code </th>
								<th  style="border-left: 1px solid #C1DAD7">course<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>Student<br>class<br>year</th>
								<th>semister</th>
								<th>Submission<br>date</th>
								<th>file name </th>
								<th>Download</th>
								
							</tr>
						</thead>
						<tbody>
<?php  
$result11 = mysql_query("SELECT * FROM assignment where department='$dpt' and Student_class_year='$yea' and semister='$sem'and status='inst' ORDER BY Submission_date DESC");
while($row2 = mysql_fetch_array($result11))
								{
$files=$row2['fileName'];

$iid=$row2['U_ID'];
$result12 = mysql_query("SELECT * FROM user where UID='$iid'");
$row12 = mysql_fetch_array($result12);
$fn=$row12['fname'];
$ln=$row12['lname'];
$fnm=$fn.'    '.$ln;

									echo '<tr>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$fnm.'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['asno'].'</td>';
										echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['assignment_value'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['ccode'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['department'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['Student_class_year'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['semister'].'</td>';
									echo '<td><div align="left">'.$row2['Submission_date'].'</div></td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row2['fileName'].'</td>';
 print ("<td style='background-color: #243cdb;'><font size='4'>" ."<a style='color:#fffbfb;' href='../material/assignment/$files'><img width='30' height='30' src='userphoto/d1.jpg' /></a>". "</td>");
		
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
					 echo"currently not uploaded";
					 }
					 
					
					?>
					
				</div>
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