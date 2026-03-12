<script type="text/javascript">
function test(a){
var x = (a.options[a.selectedIndex].value); 
 var element=document.getElementById('dc');
 var element1=document.getElementById('ac');
 if(x=='department_head' || x=='instructor'){
 	element.style.display='block';
 	element1.style.display='block';

 	   var x1 = (element.options[element.selectedIndex].value); 
 		$('[name=dc]').val(x1);
 }
   
 else if(x=='collage_dean'){
 	element1.style.display='block';
 	element.style.display='none';

 	 	   var x2 = (element1.options[element1.selectedIndex].value); 
 		$('[name=ac]').val(x2);
 }
  else {
  	element2.style.display='none';
 	element1.style.display='none';

 }
}

</script>
<div id="m">
<form action="insertuser.php" method="POST" name="form1" enctype="multipart/form-data">
<table bgcolor="#f9fbf9" cellpadding="5" border="0">
<tr><td colspan="2" ><center><h2><b>User Information Registration Form</b></h2></center></td></tr>
<tr><td>UID:</td><td><input type="text" name="uid" id="uid"  style="height: 30px;width: 200px;" required  placeholder="Enter user id"/>
 	<script type="text/javascript">
				    var f1 = new LiveValidation('uid');
				    f1.add(Validate.Presence,{failureMessage: " Please enter user id "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script> 
				  </td></tr>

<tr><td>FirstName:</td><td><input type="text" name="fname" id="fname" style="height: 30px;width: 200px;" required="required"  placeholder="first_name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('fname');
				    f1.add(Validate.Presence,{failureMessage: " Please enter First name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script> 	
				  </td></tr>
<tr><td>Last Name:</td><td><input type="text" name="lname" id="lname" style="height: 30px;width: 200px;" required="required"  placeholder="last_name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('lname');
				    f1.add(Validate.Presence,{failureMessage: " Please enter Last name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				     f1.add( Validate.Length, { minimum: 2,maximum: 20 } );
				 </script> 	
</td></tr>
<tr><td>Sex:</td><td><select name="sex" id="sex" style="height: 30px;width: 200px;" required>
<option value="">--Please Select---</option>
<option value="male">Male</option>
<option value="female">Female</option>
</select>
<script type="text/javascript">
				    var f1 = new LiveValidation('sex');
				    f1.add(Validate.Presence,{failureMessage: " Please select sex "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z &nbsp;]+$/ ,failureMessage: " It allows only String"});
				 </script> 
</td></tr>
<tr><td>Email:</td><td><input  type="email" name="email" id="email" style="height: 30px;width: 200px;"  required="required"  placeholder="Enter Email" />
 
<script type="text/javascript">
function ValidateEmail(inputText)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(inputText.value.match(mailformat))
{
form1.email.focus();
return true;
}
else
{
alert("You have entered an invalid email address!");
form1.email.focus();
return false;
}
}
</script>
</td></tr>
<tr><td>Phone:</td><td><input type="text" value="+251" name="phone" id="phone" style="height: 30px;width: 200px;" required="required"  placeholder="phone" />
 <script type="text/javascript">
				    var f1 = new LiveValidation('phone');
				   f1.add(Validate.Presence,{failureMessage: " It cannot be empty"});
				   f1.add(Validate.Format,{pattern: /^[0-9+]+$/ ,failureMessage: " It allows only numbers"});
				   f1.add( Validate.Length, { minimum: 10, maximum: 14 } );
				 </script>
</td></tr>

<tr><td>Location:</td><td><input type="text" name="loc" id="loc" style="height: 30px;width: 200px;" required="required"  placeholder="enter location" />
<script type="text/javascript">
				    var f1 = new LiveValidation('loc');
				    f1.add(Validate.Presence,{failureMessage: " Please enter Location"});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String and Number"});
				 </script> 	
</td></tr>

<tr><td>User Type:</td>
<td>
  <select name="ct" onchange="test(this)" style="width: 200px;height:30px;"> 
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
<tr><td>&nbsp;</td>
<td>
                  <select name="ac" id="ac" style='display:none;height:30px; width: 200px' onchange="test(this)"> 
                        <option selected="selected" value="">Choose Collage Name</option>
						<?php
						include('../connection.php');

						$d_program = mysqli_query($conn, "SELECT * FROM collage");
						while($getDprog = mysqli_fetch_array($d_program)){
							$id = $getDprog['Ccode'];
					 ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php 
				} ?>
                    </select>
</td>
				  
</tr>
<tr><td>&nbsp;</td>
<td>
                   <select name="dc" id="dc" style='display:none;height:30px; width: 200px' onchange="test(this)" > 
                        <option selected="selected" value="">Choose Department Name</option>
						<?php
						include('../connection.php');

						$d_program = mysqli_query($conn, "SELECT * FROM department");
						while($getDprog = mysqli_fetch_array($d_program)){
							$id = $getDprog['Dcode'];
					 ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php 
				} ?>
                    </select>
</td>
				  
</tr>

<tr><td>User Photo</td><td><input type="file" name="photo" required><br></td></tr>
<tr><td></td><td><input type="submit" id="submit" name="submit" style="height: 30px; width: 100px;" value="REGISTER">
<input type="reset" id=id="m" name="validation" style="height: 30px; width: 100px;" value="CANCEL"size="20" >
</td></tr>

</table>
</form>
</div>