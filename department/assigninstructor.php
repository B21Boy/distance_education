
	
<form action="assigninst.php"method="POST" >
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Instructor registration Form</center></td></tr>


<tr><td>Instructor ID:</td><td><input type="text" name="insid" id="insid" style="height: 30px;width: 200px;" required="required"  placeholder="instructor id" />
<script type="text/javascript">
				    var f1 = new LiveValidation('insid');
				    f1.add(Validate.Presence,{failureMessage: " Please enter instructor id "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>


<tr><td>Instructor Fname:</td><td><input type="text" name="fn" id="fn" style="height: 30px;width: 200px;" required="required"  placeholder="instructor first name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('fn');
				    f1.add(Validate.Presence,{failureMessage: " Please enter instructor first name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>


<tr><td>Instructor Lname:</td><td><input type="text" name="ln" id="ln" style="height: 30px;width: 200px;" required="required"  placeholder="instructor last name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('ln');
				    f1.add(Validate.Presence,{failureMessage: " Please enter instructor last name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>


<tr><td>Email Address:</td><td><input type="text" name="add" id="add" style="height: 30px;width: 200px;" required="required"  placeholder="email address" />
<script type="text/javascript">
				    var f1 = new LiveValidation('add');
				    f1.add(Validate.Presence,{failureMessage: " Please enter Email address"});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>
<tr><td>Location:</td><td><input type="text" name="lo" id="lo" style="height: 30px;width: 200px;" required="required"  placeholder="instructor last name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('lo');
				    f1.add(Validate.Presence,{failureMessage: " Please enter location "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>


<tr><td>department Code:</td><td><input type="text" name="dcode" id="dcode" style="height: 30px;width: 200px;" required="required"  placeholder="email address" />
<script type="text/javascript">
				    var f1 = new LiveValidation('dcode');
				    f1.add(Validate.Presence,{failureMessage: " Please enter department code "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>

<tr>
<td><input type="submit"  name="submit" value="Register" style="height: 40px;width: 120px;"id="m"></td>
<td><input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="m"> </td>

</tr>
</table>
</form>
	