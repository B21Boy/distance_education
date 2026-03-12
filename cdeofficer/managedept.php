<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
CDE Officer page
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
    require("menucdeo.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenucdeo.php");
?>
	
</td><td>
	<div id="contentindex5">
				<div id="content" class="clearfix">
				
				

					
					<a rel="facebox" href="adddept.php" style="margin-left: 500px">Add Department</a>
					
<table cellpadding="1" cellspacing="1" id="resultTable">
						<thead>
							<tr>
								<th  style="border-left: 1px solid #C1DAD7">Department Code </th>
								<th  style="border-left: 1px solid #C1DAD7">Department Name</th>
								<th  style="border-left: 1px solid #C1DAD7">Location</th> 
								<th  style="border-left: 1px solid #C1DAD7">Collage Code</th>
								 
							</tr>
						</thead>
						<tbody>
						<?php
							include('../connection.php');
							$result = mysql_query("SELECT * FROM department");
							while($row = mysql_fetch_array($result))
								{
									echo '<tr class="record">';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Dcode'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['DName'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Location'].'</td>';
									echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['Ccode'].'</td>';
									
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