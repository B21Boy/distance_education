<?php
session_start();
require('../connection.php');
?>
<style type="text/css">
<!--
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
-->
</style>
 <form action="editexec.php" method="post" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
<table>
 <tr>
		<td colspan="2" align="center"><h3>Upload Prepared Module To CDE Officer</h3></td>
</tr>
<tr><td>Module Code:</td><td>
<select name="cc"  class="login-form2" style="height:30px; width:180px; color:red;"required >
                        <option selected="selected" value="">Choose Module Code</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
					$d_program = mysql_query("SELECT * FROM course where department='$dcode'");
					while($getDprog = mysql_fetch_array($d_program)){
						$id = $getDprog['course_code'];
						
				 ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php 
				} ?>
                    </select>

</td></tr>
<tr><td>Module name:</td><td><input type="text"  name="cn" class="ed" id="brnu"   style="height:30px; width:180px;color:red;" required />
</td></tr>
<tr><td>department:</td><td><input type="text" name="dc" class="ed" id="brnu"   style="height:30px; width:180px;color:red;" required />

</td></tr>



<tr><td>Acadamic Year:</td><td>	<input type="text" name="ay" class="ed" id="brnu"    style="height:30px; width:180px;color:red;" required />
</td></tr>
<tr>
<td>Please browse file: </td>
<td>
 <input type="file" name="image" class="ed"><br /></td></tr>
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
