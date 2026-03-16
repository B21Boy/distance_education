<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
    require("menucdeo.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenucdeo.php");
?>
	
</td><td>
	<div id="contentindex5">
	
	<form action="insertcourse.php" name="addem" method="post">
	<table cellpadding="1" cellspacing="1" id="resultTable" >
<?php
if(isset($_POST['search']))
	{
$idd=$_SESSION['suid'];
	 				$dpt=$_POST['dpt'];
	 				$_SESSION['sdpt']=$dpt;
				?>
						<thead>
							<tr>
							   <th  style="border-left: 1px solid #C1DAD7">Student Temo_ID</th>
							    <th  style="border-left: 1px solid #C1DAD7">Result </th>
							     <th  style="border-left: 1px solid #C1DAD7">Status </th>
							</tr>
						</thead>
						<tbody>
<?php		
$sql=mysql_query("select * from student where Department='$dpt' and year='1st' and semister='I' ORDER BY S_ID ASC");
while($row = mysql_fetch_array($sql))
{
		$sid=$row['S_ID'];
			echo '<tr>';
echo '<td style="border-left: 1px solid #C1DAD7;"><input type=text name=id[] readonly value='.$row['S_ID'].' style=width:100px></td>';
			echo '<td style="border-left: 1px solid #C1DAD7;"><input type=text required name=a1[] id=a1[] style=width:50px></td>';
			echo '<td style="border-left: 1px solid #C1DAD7;">
			<select name=st[] id=st[] style="width: 150px;" required>
			<option value="">--Please Select---</option>
			<option value="satisfactory">satisfactory</option>
            <option value="unsatisfactory">unsatisfactory</option>
            </select></td>';
			echo '</tr>';
?>
<script type="text/javascript">
				    var f1 = new LiveValidation('a1[]');
				    f1.add(Validate.Presence,{failureMessage: " Please enter result value"});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script>
				 <?php
}
?>
				 
<tr><td></td><td colspan="3"><input type="submit"  name="submit1"  style="width:60px;background-color: #336699;; color: white" value="Post"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset"   style="width:60px;background-color: #336699;; color: white" value="Clear"/></td></tr>
<?php	
}
?>

</tbody>
</table>
</form>


</div></td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 <?php
echo "<b><br><font color=blue>Welcome:</font><font color=#e70f0a>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
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