<?php
session_start();
include("../connection.php");
?>
<?php
//mag show sang information sang user nga nag login
$user_id=$_SESSION['suid'];
$dept=$_SESSION['sdcode'];
$result=mysql_query("select * from user where UID='$user_id'")or die(mysql_error);
$row=mysql_fetch_array($result);
$FirstName=$row['fname'];
$middleName=$row['lname'];

?>
<?php
$date=date("Y-m-d");
?>
<form action="newnotificationprocess1.php" method="post" onsubmit='return formValidation()'>
<table style="border:2px solid black; border-radius:7px;margin-top:6px;box-shadow:4px 1px 3px black;" width="450px" height="200px" align="center">
<tr bgcolor="" ><td align="center" colspan="4" ><font style="Time New Roman" size='3'>New Message Submit Form</font></td></tr>
<tr>
<td colspan = "2">   </td>
</tr>
<tr>
<td> <font size="3" face="Times New Roman"> Send By:</td>
<td><input type="text" name="M_sender" width="172"  value="<?php echo $user_id;?>"ReadOnly>
</td>
</tr>
<tr>
<td><font size="2" face="Time New Roman">Send To:</td>
<td>
<select name="M_Reciever" style="width: 172">
<?php 
$result1=mysql_query("select * from account where Role='instructor'")or die(mysql_error);
//$result=mysql_query("select UID,fname,lname from user ")or die(mysql_error);
while ($row = mysql_fetch_array($result1)){
?>
 <option value="<?php echo $row['UID'];?>">
     <?php echo $row['UID']; ?>
    </option>
<?php
}
?>        
</select>
</td>
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
<td> <font size="3" face="Times New Roman"> Date:</td>
<td>
<input type="text" name="date_sended" value="<?php echo $date; ?>"ReadOnly>
</td> 
</tr>
<tr>
<td colspan=2 align=center><br><input type='submit' class="button_example" value="Send" name='submitMain' Onclick="return check(this.form);"/> 
</form>
</table>

