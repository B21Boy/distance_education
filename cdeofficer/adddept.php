
<form action="registerdept.php" method="POST" name="form1" enctype="multipart/form-data">
<table bgcolor="#f9fbf9" cellpadding="5" border="0">
<tr><td colspan="2" ><center><h2><b>Department Registration Form</b></h2></center></td></tr>
<tr><td>Department Code:</td><td><input type="text" name="dc" id="dc" style="height: 30px;width: 200px;" required="required"  placeholder="department code"/>
 	<script type="text/javascript">
				    var f1 = new LiveValidation('dc');
				    f1.add(Validate.Presence,{failureMessage: " Please enter department code "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String and number"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script> 
				  </td></tr>

<tr><td>Department Name:</td><td><input type="text" name="dn" id="dn" style="height: 30px;width: 200px;" required="required"  placeholder="department name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('dn');
				    f1.add(Validate.Presence,{failureMessage: " Please enter department name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script> 	
				  </td></tr>

<tr><td>Location:</td><td><input type="text" name="loc" id="loc" style="height: 30px;width: 200px;" required="required"  placeholder="enter location" />
<script type="text/javascript">
				    var f1 = new LiveValidation('loc');
				    f1.add(Validate.Presence,{failureMessage: " Please enter Location"});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String and Number"});
				 </script> 	
</td></tr>

<tr><td>Collage Code:</td><td>
 <select name="cc" id="cc" class="login-form2" style="height:30px; width:200px;" required>
                        <option selected>--Choose collage code--</option>
                        <?php
						mysql_connect("localhost","root","");
						mysql_select_db("cde");

					$d_program = mysql_query("SELECT * FROM collage");
					while($getDprog = mysql_fetch_array($d_program)){
						$id = $getDprog['Ccode'];
				 ?>
					<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php } ?>
                    </select>

</td></tr>
<tr><td></td><td><input type="submit" id="submit" name="submit" style="height: 30px; width: 100px;" value="REGISTER">
<input type="reset" id=id="m" name="validation" style="height: 30px; width: 100px;" value="CANCEL"size="20" >
</td></tr>

</table>
</form>
