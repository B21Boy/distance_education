 
<?php
session_start();
	include('../connection.php');
	$id=$_GET['id'];
	$result = mysql_query("SELECT * FROM course where course_code='$id'");
		while($row = mysql_fetch_array($result))
			{ 
			     $cc=$row['course_code'];
				$ch=$row['chour'];
				$cn=$row['cname'];
				$mn=$cc.'    '.$cn;
				$sn=$row['Sender_name'];
				
			}
			$_SESSION['sname']=$sn;
						    $iname=$row['Sender_name'];
							$result1 = mysql_query("SELECT * FROM user where UID='$sn'");
							$r=mysql_fetch_array($result1);
							$fn=$r['fname'];
							$ln=$r['lname'];
							$fna=$fn.'    '.$ln;	
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
<form name="addem" action="insertmodulepayment.php" method="post">
<br><fieldset><legend><b>Fill Instructors Who Have Participated in Preparing Module</b></legend>
<table  cellpadding="5" border="0">

<tr><td>Instructor Name:</td><td><input type="text" name="in" class="ed" value="<?php echo $fna ?>" readonly style="height: 30px;width: 200px;" required="required"  />	
</td></tr>
<input type="hidden" name="ccode" value="<?php echo $cc ?>">
<tr><td>Module Name:</td><td><input type="text" name="mn" id="mn"class="ed" value="<?php echo $mn ?>" readonly style="height: 30px;width: 200px;" required="required" />

</td></tr>
<tr><td>Credit Hour:</td><td><input type="text" name="ch" id="ch"class="ed" value="<?php echo $ch ?>" readonly style="height: 30px;width: 200px;" required="required"/>

</td></tr>
<tr><td>No.of Pages Prepared:</td><td><input type="text" name="np" id="np"class="ed" style="height: 30px;width: 200px;" required="required"  placeholder="Please enter No.of pages prepared" />
<script type="text/javascript">
				    var f1 = new LiveValidation('np');
				    f1.add(Validate.Presence,{failureMessage: " Please enter number of pages"});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script> 
</td></tr>
<tr><td>Payment Per Page:</td><td><input type="text" name="pp" id="pp" class="ed"  style="height: 30px;width: 200px;" 
onkeyup="calculateTotal(np.value,pp.value)" required="required"  placeholder="Please enter value"/>	
<script type="text/javascript">
				    var f1 = new LiveValidation('pp');
				    f1.add(Validate.Presence,{failureMessage: " Please enter peyment per page value"});
				     f1.add(Validate.Format,{pattern: /^[0-9]+$/ ,failureMessage: " It allows only Number"});
				 </script> 	
</td></tr>
<tr><td>Total Payment for Modules:</td><td><input type="text" name="total" class="ed" readonly style="height: 30px;width: 200px;"  />

</td></tr>
<tr><td></td>
<td><input type="submit"  name="submit" value="Send TO Finance" style="height: 40px;width: 120px;"id="button1">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="button1"> </td>

</tr>
</table></fieldset>
</form>


		