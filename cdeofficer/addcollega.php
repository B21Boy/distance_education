<?php
include("../connection.php");
session_start();

?>
<form action="registercollage.php" method="POST" name="form1" enctype="multipart/form-data">
<table bgcolor="#f9fbf9" cellpadding="5" border="0">
<tr><td colspan="2" ><center><h2><b>Collage Registration Form</b></h2></center></td></tr>
<tr><td>Collage Code:</td><td><input type="text" name="cc" id="cc" style="height: 30px;width: 200px;" required placeholder="Collage code" />
 	<script type="text/javascript">
				    var f1 = new LiveValidation('cc');
				    f1.add(Validate.Presence,{failureMessage: " Please enter collage code "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z0-9]+$/ ,failureMessage: " It allows only String and number"});
				     f1.add( Validate.Length, {minimum: 2, maximum: 20 } );
				 </script>
 	
				  </td></tr>

<tr><td>Collage Name:</td><td><input type="text" name="cn" id="cn" style="height: 30px;width: 200px;" required="required"  placeholder="Collage name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('cn');
				    f1.add(Validate.Presence,{failureMessage: " Please enter collage name "});
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

<tr><td></td><td><input type="submit" id="submit" name="submit" style="height: 30px; width: 100px;" value="REGISTER">
<input type="reset" id=id="m" name="validation" style="height: 30px; width: 100px;" value="CANCEL"size="20" >
</td></tr>

</table>
</form>
