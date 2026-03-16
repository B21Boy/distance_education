<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
Director page
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
    require("menudir.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenudir.php");
?>
	
</td><td>
	<div id="contentindex5">
		<form action=" " method="post"> 
					<table><tr>				    			  
				  <td>Department:</td>
                  <td>
					<select name="dpt"  class="login-form2"  style="height:30px; width:180px;" required>
                        <option value="">--select department--</option>
                        <?php
						
					$d_program2 = mysql_query("SELECT DISTINCT Department FROM student");
			
					while($getDprog2 = mysql_fetch_array($d_program2)){
						$sem = $getDprog2['Department'];
				 ?>
					<option value="<?php echo $sem;  ?>"><?php echo $sem; ?></option>
				<?php } ?>
                    </select>
                    </td>
 <td>
					<input type="submit" value="Search"  name="search" style="font-size: 25;background-color: #003366;color: white"/></td>
 						</tr></table>
 						 </form>
 						 <?php
 						 if(isset($_POST['search']))
 						 {
						 	$sem=$_POST['dpt'];			
	$sql = mysql_query("SELECT * FROM student where Department='$sem' ORDER BY year ASC");		
	

	$query1 = mysql_query("SELECT * FROM student where Sex='female' and Department='$sem'");	
	$query2 = mysql_query("SELECT * FROM student where Sex='male' and Department='$sem'");				
	$count_my_message = mysql_num_rows($query1);
	$count_my_message1 = mysql_num_rows($query2);
							echo'Total Number of male students:   '.$count_my_message1.'</br>';
								echo'Total Number of female students:   '.$count_my_message.'</br>';
						 	?>
						 	<table cellpadding="0" cellspacing="0" id="resultTable" style="margin-left: -20px">
          <thead>
         
          <tr>
<th>Student ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>semister</th>
<th>section</th>
<th>College</th>
<th>Department</th>
<th>Program</th>
<th>year</th>

</tr>
          </thead>
          <tbody>
        <?php
while($row1 = mysql_fetch_array($sql)){	
$id=$row1["S_ID"]; 
									
?>

<tr>
<div class="post"  id="del<?php echo $id; ?>">
<td><?php echo $row1["S_ID"]; ?></td>
<td><?php echo $row1["FName"]; ?></td>
<td><?php echo $row1["LName"]; ?></td>
<td><?php echo $row1["Sex"]; ?></td>
<td><?php echo $row1["semister"]; ?></td>
<td><?php echo $row1["section"]; ?></td>
<td><?php echo $row1["College"]; ?></td>
<td><?php echo $row1["Department"]; ?></td>
<td><?php echo $row1["program"]; ?></td> 
<td><?php echo $row1["year"]; ?></td>  

</div>		
								<?php }
									
								
								?>
								
								
								</tr>
          </tbody>
       </table>  
       <?php
      
      
       }
       ?>          
                   
 </div>
  </td>
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