<?php
require('../connection.php');
?>
<?php
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM course where course_code='$id'");
		while($row = mysql_fetch_array($result))
			{   
			    $ccode=$row['course_code'];
				$cname=$row['cname'];	
				$dept=$row['department'];
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
 <form action="assignins.php" method="post">
<table>
 <tr>
		<td colspan="2" align="center">Assign Course To Instructor  </td>
</tr>
<tr><td>Course Code:</td><td><input type="text" class="ed" name="cc" readonly style="height:30px; width:180px; color:red;"required value="<?php echo $ccode ?>"/>	
</td></tr>
<tr><td>Course name:</td><td><input type="text"class="ed" name="cn" readonly style="height:30px; width:180px;color:red;" required value="<?php echo $cname ?>"/>
</td></tr>
<tr><td>department:</td>
<td>
 <select name="dc" class="ed" style="height:30px; width:180px;" required>
                        <option selected="selected" value="">Select Department</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");

					$d_program01 = mysql_query("SELECT * FROM department");
					while($getDprog01 = mysql_fetch_array($d_program01)){
						$id = $getDprog01['DName'];
				 ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php } ?>
</select>

</td>
</tr>
<tr>                  
                  <td>Instructor Name:</td>
                  <td>
                  <select name="In"  class="ed" style="height:30px; width:180px;" required>
                        <option selected="selected" value="">Select Instructor</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");

					$d_program = mysql_query("SELECT * FROM department where DName='$dept'");
					if($getDprog = mysql_fetch_array($d_program)){
						$id = $getDprog['Dcode'];
						$d_program11 = mysql_query("SELECT * FROM account where Role='instructor'");
						while($getDprog11 = mysql_fetch_array($d_program11))
						{
						$role=$getDprog11['UID'];
						$d_program1 = mysql_query("SELECT * FROM user where d_code='$id' and UID='$role'");
						if($getDprog1 = mysql_fetch_array($d_program1))
						{
							$uidd=$getDprog1['UID'];
						$name = $getDprog1['fname'].'  '.$getDprog1['lname'];
				 ?>
					<option value="<?php echo $uidd; ?>"><?php echo $name; ?></option>
				<?php }} }?>
                    </select>
                    </td>
                    
                  
 </tr>

						
<tr>			
                    <td>Section:</td>
                    
                    <td>
				<select name="sec"  class="ed" style="height:30px; width:180px;" required>
				<option selected="selected" value="">Select Section</option>
                        <option value="A" >A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="E">E</option>
						</select>
					</td>
                   
 </tr>
<tr>
					<td>Student Class Year:</td>
                  <td>
                <select name="scy" class="ed" style="height:30px; width:180px;" required>
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
     <select  name="sem"  class="ed" style="height:30px; width:180px;"  required>
      <option selected="selected" value="">Select Semister</option>
                        <option value="I">I</option>
						<option value="II">II</option>
						<option value="III">III</option>
				    </select>
				    </td>
 
 </tr>	
<tr><td>Creadit Hour:</td><td><input type="text" name="ch" class="ed" readonly style="height:30px; width:180px;color:red;" required value="<?php echo $ch ?>"/>
	
</td></tr>

<tr><td>Acadamic Year:</td><td>	<input type="text" class="ed" name="ay" readonly  style="height:30px; width:180px;color:red;" required value="<?php echo $ayear ?>"/>
</td></tr>
<tr>
<td></td>
<td>
<input type="submit" value="Assign"  name="assign" id="button1"/>             
<input name="Reset" type="button"  value="Reset" id="button1"/>
</td>
</tr>
 </table>
  </form>   
