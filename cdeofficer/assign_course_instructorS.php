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
				$file=$row['FileName'];
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
background-color:#00CCFF;
height: 34px;
}
</style>
<SCRIPT language="javascript">
function addCombo() {
	var textb = document.getElementById("dc");
	var combo = document.getElementById("combo");
	combo.value=combo.value +textb.value + ", ";
	textb.value = "";
}

function addCombo1() {
	var textb = document.getElementById("scy");
	var combo = document.getElementById("combo1");
	combo.value=combo.value +textb.value + ", ";
	textb.value = "";
}
</SCRIPT>
 <form action="editexec.php" method="post">
<table>
 <tr>
		<td colspan="2" align="center">Upload Module To Students</td>
</tr>
<tr><td>Module Code:</td><td><input type="text" class="ed" id="brnu"  name="cc" readonly style="height:30px; width:180px; color:red;"required value="<?php echo $ccode ?>"/>	
</td></tr>
<tr><td>Module name:</td><td><input type="text" class="ed" id="brnu"  name="cn" readonly style="height:30px; width:180px;color:red;" required value="<?php echo $cname ?>"/>
</td></tr>
<tr><td>
	 Selected Department:</td>
	 <td>
 <input name="combo" type="text" class="ed" id="combo" size="40" required/>
</td></tr>
<tr><td></td><td>
					<select name="dc" id="dc"  style="height:30px; width:180px;"  class="ed">
                      <option value="">--select department--</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");

					$d_program = mysql_query("SELECT * FROM department");
					while($getDprog = mysql_fetch_array($d_program)){
						$name = $getDprog['DName'];
				 ?>
					<option value="<?php echo $name;  ?>"><?php echo $name; ?></option>
				<?php } ?>
                    </select>
 <input name="button" type="button" style="cursor:pointer;" onclick="addCombo()" value="Add" id="button1" />
</td></tr>
<tr><td>
	  Student Class Year: </td>
	 <td>
 <input name="combo1" type="text" class="ed" id="combo1" size="40" required/>
</td></tr>

<tr>
					<td></td>
                  <td>
                <select name="scy"  id="scy" style="height:30px; width:200px;"  class="ed" id="brnu" >
                <option selected="selected" value="">Select Student Class Year</option>
                        <option value="1st">1st</option>
						<option value="2nd">2nd</option>
						<option value="3rd">3rd</option>
						<option value="4th">4th</option>
				    </select>
			<input name="button" type="button" style="cursor:pointer;" onclick="addCombo1()" value="Add" id="button1" />
				    </td>	
</tr>
<tr>				    			  
				  <td>Semister:</td>
                  <td >
     <select  name="sem"  class="ed" id="brnu" style="height:30px; width:180px;"  required  >
      <option selected="selected" value="">Select Semister</option>
                        <option value="I">I</option>
						<option value="II">II</option>
						<option value="III">III</option>
				    </select>
				    </td>
 
 </tr>	
<tr><td>Creadit Hour:</td><td><input type="text" name="ch" class="ed" id="brnu"  readonly style="height:30px; width:180px;color:red;" required value="<?php echo $ch ?>"/>
	
</td></tr>

<tr><td>Acadamic Year:</td><td>	<input type="text" name="ay" class="ed" id="brnu"  readonly  style="height:30px; width:180px;color:red;" required value="<?php echo $ayear ?>"/>
</td></tr>
<tr>
<td>File</td>
<td><input type="text" name="image" value="<?php echo $file ?>" class="ed" readonly style="height:30px; width:180px;"></td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr><td></td><td>
<input type="submit" value="Upload" id="button1" name="assign"/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          
<input name="Reset" type="button" id="button1" value="Reset" />
</td>
</tr>
 </table>
  </form>   
