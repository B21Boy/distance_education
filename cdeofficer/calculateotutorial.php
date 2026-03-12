<?php
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM payment_table where no='$id'");
		while($row = mysql_fetch_array($result))
			{ 
$tn=$row["Instructors_Name"]; 
$r=$row["Rank"]; 
$ct=$row["Course_Code"]; 
$cr=$row["CrHr"]; 
$d=$row["Department"];
$y=$row["Year"]; 
$s=$row["Section"];
$nh=$row["No_of_hours_she_he_gave_tutorial"]; 
			}
?>
<script type="text/javascript">
function calculateTotal(n1,n2) {
var x=parseFloat(n1)
var y=parseFloat(n2)
var e=x*y
if(e>=0){
addem.total.value=e	
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
<form name="addem" action="updateotutorial.php" method="post">
<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
<br><fieldset><legend><b>List of Instructors Who Have Participated in Offering Tutorial Program</b></legend>
<table  cellpadding="5" border="0">
<tr><td>Tutor's Name:</td><td><input type="text" name="tn" class="ed" value="<?php echo $tn ?>" style="height: 30px;width: 200px;" readonly/> 	
</td></tr>

<tr><td>Rank:</td><td><input type="text" name="rk"class="ed" value="<?php echo $r ?>" style="height: 30px;width: 200px;" readonly/>	
</td></tr>
<tr><td>Course he/she tutored:</td><td><input type="text"class="ed" name="cs" value="<?php echo $ct ?>" style="height: 30px;width: 200px;" readonly /> 	
</td></tr>

<tr><td>CrHr:</td><td><input type="text" name="cr"class="ed" value="<?php echo $cr ?>" style="height: 30px;width: 200px;" readonly/>

</td></tr>


<tr><td>Department:<br><br>Year:<br><br>Section:</td>
<td><fieldset><legend>Students who have taken the course</legend>
<input type="text" name="dept" value="<?php echo $d ?>"class="ed" style="height: 30px;width: 180px;" readonly/> <br><br> 
<input type="text" name="year" value="<?php echo $y ?>"class="ed" style="height: 30px;width: 180px;" readonly/> <br><br>
<input type="text" name="sec" value="<?php echo $s ?>"class="ed" style="height: 30px;width: 180px;" readonly/> <br><br>
</fieldset></td>
</tr>

<tr><td>No of hours she/he gave tutorial:</td><td><input type="text"class="ed" name="nhr" id="nhr" value="<?php echo $nh ?>"  style="height: 30px;width: 200px;" readonly />
 
</td></tr>

<tr><td>payment per hour(Birr):</td><td><input type="text" name="pphr" id="pphr"class="ed"  style="height: 30px;width: 200px;"
 onkeyup="calculateTotal(nhr.value,pphr.value)" required="required"/>
 	<script type="text/javascript">
				    var f1 = new LiveValidation('pphr');
				    f1.add(Validate.Presence,{failureMessage: " Please enter peyment per exam value"});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script> 	
</td></tr>


<tr><td>Total Payment(Birr):</td><td><input type="text" name="total"class="ed" value="0" readonly style="height: 30px;width: 200px;"/>
</td></tr>

<tr><td></td>
<td><input type="submit"  name="submit" value="Save" style="height: 40px;width: 100px;"id="button1">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 100px;"id="button1"> </td>
</tr>
</table></fieldset>
</form>