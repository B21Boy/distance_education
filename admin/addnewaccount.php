<script>
function keyup(me)
{
if(isNaN(me.value))
{
 me.value="";
}
if(!isNaN(me.value))
{
 me.value="";
}
}
</script>
<form action="insertaccount.php" method="POST" name="form1" enctype="multipart/form-data">
<table bgcolor="#f9fbf9" cellpadding="5" border="0">
<tr><td colspan="2" ><center><h2><b>Account Creation Form</b></h2></center></td></tr>
<tr><td>UID:</td>
<td>
                  <select name="uid" id="uid" class="login-form2" style="height:30px; width:200px;" required>
                        <option selected="selected" value="">Choose User ID</option>
                        <?php
                        include('../connection.php');

                    	$d_program = mysqli_query($conn, "SELECT * FROM user");
                    	while($getDprog = mysqli_fetch_array($d_program)){
                        	$id = $getDprog['UID'];
                        	$d_program1 = mysqli_query($conn, "SELECT * FROM account where UID='$id'");
                        	$getDprog1 = mysqli_fetch_array($d_program1);
                        	$uid=$getDprog1['UID'];
                        	
                        	if($uid!=$id)
                        	{
                     ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php }
				} ?>
                    </select>
</td>
				  
</tr>

<tr><td>UserName:</td><td><input type="text" name="un" id="un" style="height: 30px;width: 200px;" required="required"  placeholder="enter user name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('un');
				    f1.add(Validate.Presence,{failureMessage: " Please enter user name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script> 	
				  </td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" id="pass" min="6" style="height: 30px;width: 200px;" required="required"  placeholder="enter password" />
<script type="text/javascript">
				    var f1 = new LiveValidation('pass');
				    f1.add(Validate.Presence,{failureMessage: " Please enter password "});
				     //f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String and number"});
				     f1.add( Validate.Length, { minimum: 3,maximum: 10 } );
				 </script> 	
</td></tr>

<tr><td>Role:</td><td><select name="role" id="role" style="height: 30px;width: 200px;" required>
<option value="">--Please Select---</option>
<option value="administrator">Administrator</option>
<option value="cdeofficer">CDEofficer</option>
<option value="registrar">Registrar</option>
<option value="collage_dean">Collage_Dean</option>
<option value="department_head">Department_head</option>
<option value="instructor">Instructor</option>
<option value="financestaff">Finance_staff</option>
<option value="acadamic_vice_presidant">Acadamic_Vice_Presidant</option>
</select>
</td></tr>
<tr><td></td><td><input type="submit" id="submit" name="submit" style="height: 30px; width: 100px;" value="REGISTER">
<input type="reset" id=id="m" name="validation" style="height: 30px; width: 100px;" value="CANCEL"size="20" >
</td></tr>

</table>
</form>
