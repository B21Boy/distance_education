<?php
session_start();
	include('../connection.php');
	$id=$_GET['id'];
	$uid=$_SESSION['suid'];
	$result = mysql_query("SELECT * FROM assignment where no='$id'");
		while($row = mysql_fetch_array($result))
			{   
				$asno=$row['asno'];
			    $ccode=$row['ccode'];
				$cname=$row['cname'];	
				$dept=$row['department'];
				$scyear=$row['Student_class_year'];	
				$sem=$row['semister'];
				$sd=$row['Submission_date'];
				$date=date('Y-m-d');
				
			}
			if($date<=$sd)
				{
?>
<form action="assignment.php" method="post" enctype="multipart/form-data"  onSubmit="return validate(this);">
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Upload Assignment</center></td></tr>
<tr><td>Student ID:</td><td><input type="text" name="sid" style="height:30px; width:200px;"readonly value="<?php echo $uid;?>"/>
 	
</td></tr>
<tr><td>Assno:</td><td><input type="text" name="asno" style="height:30px; width:200px;"required="required" readonly value="<?php echo $asno ?>" />
 	
</td></tr>

<tr><td>Course Code:</td><td><input type="text" name="cc"  style="height:30px; width:200px;"required readonly value="<?php echo $ccode ?>"/>	
</td></tr>
<tr><td>Course name:</td><td><input type="text" name="cn"  style="height:30px; width:200px;" required readonly value="<?php echo $cname ?>"/>
</td></tr>

<tr><td>department:</td><td><input type="text" name="dc" readonly style="height:30px; width:200px;" required value="<?php echo $dept ?>"/>

</td></tr>
<tr><td>Student Class Year:</td><td><input type="text" name="scy" readonly style="height:30px; width:200px;" required value="<?php echo $scyear ?>"/>
	
</td></tr>
<tr><td>Semister:</td><td><input type="text" name="sem" readonly style="height:30px; width:200px;" required value="<?php echo $sem ?>"/>
	
</td></tr>	
<tr><td> Date</td><td><input type="text" name="date" style="height:30px; width:200px;" value="<?php echo date('Y-m-d');?>"/>
	
</td></tr>
<tr><td>Filename:</td><td><input type="file" name="file" id="file"  style="height:30px; width:200px;" readonly />
 	
</td></tr>

<tr>
<td></td><td><input type="submit" name="submit" value="Upload" style="height: 40px;width: 100px;"id="m">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 100px;"id="m"> </td>

</tr>
</table>
</form>
<?php
}
else
{
echo'<br><fieldset style="height:100">';
echo"Submission date is Expired";	
echo '<br><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="assignmentsubmit.php">Ok</a>';
echo'</fieldset>';
}

?>
