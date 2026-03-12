<script src="js/validation.js" type="text/javascript"></script>
<?php
session_start();
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM assign_instructor where no='$id'");
		while($row = mysql_fetch_array($result))
			{   
			$cc=$row['corse_code'];
			$result1 = mysql_query("SELECT * FROM course where course_code='$cc'");
			 $row1 = mysql_fetch_array($result1);
			    $ccode=$row['corse_code'];
				$cname=$row['cname'];	
				$iname=$row['Iname'];
				$dept=$row['department'];
				$sec=$row['section'];
				$scyear=$row['Student_class_year'];	
				$sem=$row['semister'];
				$ch=$row['chour'];
				$ayear=$row['ayear'];
			}
?>	
<style type="text/css">
.ed{
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
margin-bottom: 4px;
}
#button1{
text-align:center;
font-family:Arial, Helvetica, sans-serif;
border-style:solid;
border-width:thin;
border-color:#00CCFF;
padding:5px;
background-color:#508abb;
color: white;
height: 34px;
width: 100px;
}

</style>
<form action="assignment.php" method="post" enctype="multipart/form-data"  onSubmit="return validate(this);">
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Upload Assignment</center></td></tr>
<tr><td>User ID:</td><td><input type="text" name="uid" id="uid" class="ed" readonly value="<?php echo $_SESSION['suid'] ?>" style="height: 30px;width: 200px;" required="required"/>	
</td></tr>
<tr><td>Assignment No:</td><td><input type="text" name="asno" style="height: 30px;width: 200px;"class="ed" required="required"  placeholder="Assignment no" />
 	
</td></tr>
<tr><td>Assignment Value:</td><td><input type="text" name="asv" id="asv" style="height: 30px;width: 200px;"class="ed" required="required"  placeholder="Assignment Value" />
 	<script type="text/javascript">
				    var f1 = new LiveValidation('asv');
				    f1.add(Validate.Presence,{failureMessage: " Please Enter Assignment  value"});
				     f1.add(Validate.Format,{pattern: /^[0-9()%]+$/ ,failureMessage: " It allows only Number"});
				 </script>
</td></tr>
<tr><td>Course Code:</td><td><input type="text"class="ed" name="cc" readonly style="height:30px; width:200px;"required value="<?php echo $ccode ?>"/>	
</td></tr>
<tr><td>Course name:</td><td><input type="text"class="ed" name="cn" readonly style="height:30px; width:200px;" required value="<?php echo $cname ?>"/>
</td></tr>

<tr><td>department:</td><td><input type="text"class="ed" name="dc" readonly style="height:30px; width:200px;" required value="<?php echo $dept ?>"/>

</td></tr>
<tr><td>Student Class Year:</td><td><input type="text" name="scy"class="ed" readonly style="height:30px; width:200px;" required value="<?php echo $scyear ?>"/>
	
</td></tr>
<tr><td>Semister:</td><td><input type="text" name="sem"class="ed" readonly style="height:30px; width:200px;" required value="<?php echo $sem ?>"/>
	
</td></tr>
<tr><td>Submission Date</td><td><input type="date" name="date"class="ed" style="height: 30px;width: 200px;" required="required"  placeholder="instructor last name" />
	
</td></tr>
<tr><td>Filename:</td><td><input type="file" name="file" id="file"class="ed" style="height: 30px;width: 200px;" required="required"  placeholder="instructor id" />
 	
</td></tr>

<tr>
<td></td><td><input type="submit" name="submit" value="Upload" style="height: 40px;width: 120px;"id="button1">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="button1"> </td>

</tr>
</table>
</form>

