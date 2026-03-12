 
<?php
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM payment_table where no='$id'");
		while($row = mysql_fetch_array($result))
			{ 
			     $nm=$row['Instructors_Name'];
				$nem=$row['No_of_Exams_Marked'];
				$r=$row["Rank"]; 
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
<form name="addem" action="updatemexam.php" method="post">
<br><fieldset><legend><b>List of Instructors Who Have Participated in Marking Exams</b></legend>
<table  cellpadding="5" border="0">
<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
<tr><td>Name Of Marking:</td><td><input type="text" name="nm" id="nm" class="ed" value="<?php echo $nm ?>" readonly style="height: 30px;width: 200px;" required="required"  placeholder="Please enter Name Of Marking" />	
</td></tr>
<tr><td>Rank:</td><td><input type="text" name="rk"class="ed" value="<?php echo $r ?>" style="height: 30px;width: 200px;" readonly/>	
</td></tr>
<tr><td>No.of Exams Marked:</td><td><input type="text" name="nem" id="nem"class="ed" value="<?php echo $nem ?>" readonly style="height: 30px;width: 200px;" required="required"  placeholder="Please enter No.of Exams Marked" />

</td></tr>
<tr><td>Payment Per Exam:</td><td><input type="text" name="ppe"class="ed" id="ppe"  style="height: 30px;width: 200px;" onkeyup="calculateTotal(nem.value,ppe.value)" required="required"  placeholder="Please enter value"/>	
<script type="text/javascript">
				    var f1 = new LiveValidation('ppe');
				    f1.add(Validate.Presence,{failureMessage: " Please enter peyment per exam value"});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script> 	
</td></tr>
<tr><td>Total Payment for Exams:</td><td><input type="text"class="ed" name="total" readonly style="height: 30px;width: 200px;"  />

</td></tr>
<tr><td></td>
<td><input type="submit"  name="submit" value="Save" style="height: 40px;width: 120px;"id="button1">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="button1"> </td>

</tr>
</table></fieldset>
</form>


		