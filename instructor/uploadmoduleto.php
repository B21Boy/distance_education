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
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">

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

				<div id="content" class="clearfix"> 
				
<p>Upload preparing module to cde officer</p>

<?php
 echo '<a rel="facebox" href="uploadnewm.php">Upload module</a>';
 ?>
<table cellpadding="1" cellspacing="1" id="resultTable">
          <thead>
            	<tr>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Code </th>
								<th  style="border-left: 1px solid #C1DAD7">Module<br>Name </th>
								<th  style="border-left: 1px solid #C1DAD7">Credit Hour</th>
								<th>Year</th>
								<th  style="border-left: 1px solid #C1DAD7">department</th> 
								<th>file name </th>
              					<th><font style="margin-left: 30px"> Upload </font></th>
            </tr>
          </thead>
          <tbody>
				<?php
				include('../connection.php');
							$uid=$_SESSION['suid'];
							$result = mysql_query("SELECT * FROM assign_instructor where uid='$uid'");
							while($row = mysql_fetch_array($result))
								{
									$cc=$row['corse_code'];
									$result1 = mysql_query("SELECT * FROM course where course_code='$cc'");
							         $row1 = mysql_fetch_array($result1);
								
						 $files=$row1['FileName'];
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['course_code'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['cname'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['chour'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['ayear'].'</td>';
									echo '<td><div align="right">'.$row['department'].'</div></td>';
								    echo '<td style="border-left: 1px solid #C1DAD7;">'.$row1['FileName'].'</td>';
if ($files==''){
echo '<td><div align="center">'.' | '.'<a rel="facebox" href=uploadnea.php?id=' . $row1["course_code"] .'><img width="30" height="30" src="images/u2.png" /></a>'.'</div></td>';
					}	
					else{
print ("<td><div align='center'>" ."<a href='../material/module/$files'><img  width='30' height='30' src='images/d1.jpg' /></a>". ' | '.'<a rel="facebox" href=uploadnea.php?id=' . $row1["course_code"] .'><img width="30" height="30" src="images/u2.png" /></a>'.'</div></td>');	
					}							    
					echo '</tr>';
					
					
				  }
				
				
				?> 
          </tbody>
       </table>
				</div>
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