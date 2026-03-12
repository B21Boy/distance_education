 
<?php
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM course_result where no='$id'");
		while($row = mysql_fetch_array($result))
			{ 
$sid=$row["S_ID"]; 
$a1=$row["Assignment"];
$f=$row["Final"];
$t=$row['Total'];
$g=$row['Grade'];			
			}
			
?>
<script type="text/javascript">
function calculateTotal(n1,n2) {
var a=parseFloat(n1)
var b=parseFloat(n2)
var c=a+b
if(c>=0){
addem.total.value=c	
}
}
</script>
<form name="addem" action="updatecourserequest.php" method="post">
<br><fieldset><legend><b>Calculate grade results and send to department</b></legend>
<table  cellpadding="5" border="0">
<input type="hidden" name="roomid" value="<?php echo $id=$_GET['id'] ?>">
<tr><td>Student_ID:</td><td><input type="text" name="sid" id="nm" readonly value="<?php echo $sid ?>"  style="height: 30px;width: 200px;" />	
</td></tr>
<tr><td>Assignment </td><td><input type="text" name="as1" id="nem" value="<?php echo $a1 ?>"  style="height: 30px;width: 200px;" />

</td></tr>
<tr><td>Final</td><td><input type="text" name="fin" id="ppe" value="<?php echo $f ?>" style="height: 30px;width: 200px;" />		
</td></tr>
<tr><td>Total</td><td><input type="text" name="total" readonly value="<?php echo $t ?>" style="height: 30px;width: 200px;"  />

</td></tr>

<tr><td>Grade</td><td><input type="text" name="g" id="g" readonly value="<?php echo $g ?>" style="height: 30px;width: 200px;"/>

</td></tr>
<tr>
<td><input type="submit"  name="submit" value="Send" style="height: 40px;width: 120px;"id="m"></td>
<td><input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="m"> </td>

</tr>
</table></fieldset>
</form>



		