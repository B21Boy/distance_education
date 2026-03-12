<?php
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM payment_table where no='$id'");
		while($row = mysql_fetch_array($result))
			{ 
			$r=$row["Rank"]; 
			     $nm=$row['Instructors_Name'];
				$nem=$row['No_of_Assignment_Marked'];
			}
?>
<script type="text/javascript">
function calculateTotal(n1,n2) {
var a=parseFloat(n1)
var b=parseFloat(n2)
var c=a*b
if(c>=0){
addem.total.value=c	
}

	}
</script>
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
<form name="addem" action="updatemassignment.php" method="post">
<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
<br><fieldset><legend><b>List of Instructors Who Have Participated in Marking Assignments</b></legend>
<table  cellpadding="5" border="0">

<tr><td>Name Of Marking:</td><td><input type="text" name="nm" id="nm"class="ed" value="<?php echo $nm ?>" style="height: 30px;width: 200px;"readonly required="required" />
 	
</td></tr>
<tr><td>Rank:</td><td><input type="text" name="rk"class="ed" value="<?php echo $r ?>" style="height: 30px;width: 200px;" readonly/>	
</td></tr>
<tr><td>No.of Assignments Marked:</td><td><input type="text" name="nem"class="ed" id="nem"value="<?php echo $nem ?>" style="height: 30px;width: 200px;" readonly required="required"  />
	
</td></tr>


<tr><td>Payment Per Assignments:</td><td><input type="text"class="ed" name="ppe" id="ppe"  style="height: 30px;width: 200px;" required="required" onkeyup="calculateTotal(nem.value,ppe.value)"/>
 	<script type="text/javascript">
				    var f1 = new LiveValidation('ppe');
				    f1.add(Validate.Presence,{failureMessage: " Please enter payment per Assignment value "});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script> 
</td></tr>


<tr><td>Total Payment for Assignments:</td><td><input type="text"class="ed" name="total" id="total" value="0"readonly style="height: 30px;width: 200px;" required="required"/>
	
</td></tr>
<tr><td></td>
<td><input type="submit"  name="submit" value="Save" style="height: 40px;width: 100px;"id="button1">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 100px;"id="button1"> </td>

</tr>
</table></fieldset>
</form>