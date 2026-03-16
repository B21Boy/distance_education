
<html>
<head>
<script src="theme.js"></script>
</head>
<body class="light-theme">
<?php

include("../connection.php");

$M_ID=$_GET['M_ID'];
	$sql = "SELECT UID, M_Reciever,M_sender,M_ID FROM message, user WHERE message.M_sender=user.UID AND M_ID='$M_ID' ";
	$result1=mysql_query($sql);
	while($row = mysql_fetch_array($result1))
			{
				$u_id=$row['UID'];
				$M_Reciever=$row['M_Reciever'];
			}
?>	

<?php
$date=date("Y-m-d");
?>
<form action="notificationprocess1.php" method="post" onsubmit='return formValidation()'>
<table style="border:2px solid black; border-radius:7px;margin-top:6px;box-shadow:4px 1px 3px black;" width="300px" height="200px" align="center">
<input type="hidden" name="ud_id" value="<?php echo $M_ID=$_GET['M_ID'];?>">
<input type="hidden" name="M_Reciever" value="<?php echo $u_id;?>">
<input type="hidden" name="M_sender" value="<?php echo $M_Reciever;?>">
<tr>
<td colspan = "2">   </td>
</tr>
<tr>
<td> <font size="3" face="Times New Roman"> Message:</td>
<td>
<textarea  style="overflow:auto;resize:none" rows="3" cols="19" align="center" name="message" required x-moz-errormessage="Required"autocomplete='off' onkeypress="return letter_validate(event);"></textarea>
</td>
</td>
</tr>
<tr>
<td colspan = "2">   </td>
</tr>
<tr>
<td align="center" colspan="2"><br><br><input type="submit" value="Send"  class="button_example" id="up" Onclick="return check(this.form);">
</td></tr></table>
</form>						
