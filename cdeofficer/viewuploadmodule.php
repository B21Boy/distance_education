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
Cde officer page
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
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
	<div id="contentindex5">

<div id="content" class="clearfix"> 
<h2>Download module and upload to student									
<a  style="background-color:#2684d9;color:#fffbfb;text-decoration: none;" href="viewuploadmoduleall.php"><i class="icon-envelope-alt"></i><font size="4px">View All Module</font></a></h2>
<?php
	$sql="SELECT * FROM course WHERE status='no'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>='1')
	{?>
<table cellpadding="0" cellspacing="0" id="resultTable" style="margin-left: -20px">
          <thead>
         
            	<tr >
            					<th  style="border-left: 1px solid #C1DAD7">Sender Name</th>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Code </th>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">Credit Hour</th>
								<th>Year</th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>file name </th>
              					<th> Download|Upload </th>
              					<th>Clike Here</th>
            </tr>
          </thead>
          <tbody>
        
				<?php
				include('../connection.php');
						
							$result = mysql_query("SELECT * FROM course where status='no'");
							while($row = mysql_fetch_array($result))
								{
							$iname=$row['Sender_name'];
							$result1 = mysql_query("SELECT * FROM user where UID='$iname'");
							$r=mysql_fetch_array($result1);
							$fn=$r['fname'];
							$ln=$r['lname'];
							$fna=$fn.'    '.$ln;
						 $files=$row['FileName'];
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$fna.'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['course_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['chour'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['ayear'].'</td>';
									echo '<td><div align="right">'.$row['department'].'</div></td>';
								    echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['FileName'].'</td>';

echo "<td><div align='center'><a href='../material/module/$files'><img width='30' height='30' src='images/d1.jpg' /></a>".' | '.'<a rel="facebox" href=assign_course_instructorS.php?id=' . $row["course_code"] .'><img  width="30" height="30" src="images/u2.png" /></a>'.' </div></td>';
echo '<td ><div align="center"><a style="color:blue;size=4" rel="facebox" href="feemodule.php?id=' . $row["course_code"] .'">Calculate payment load</a></div></td>';	
					echo '</tr>';
					
					
				  }
				
				?> 
          </tbody>
       </table >
       <?php
       }
       else
       {
	   	echo"Currently Not Uploaded module";
	   }
	   ?>
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
