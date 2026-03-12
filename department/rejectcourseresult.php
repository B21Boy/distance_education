<?php
session_start();
include("../connection.php");
?>
<?php

    $cc=$_SESSION['scode'];
    $d=$_SESSION['sdepartment'];
     $y=$_SESSION['syear'];
      $id=$_SESSION['siid'];
       $s=$_SESSION['ssection'];
	?>
<form action="reject.php" method="post">
<table style="border:2px solid black; border-radius:7px;margin-top:6px;box-shadow:4px 1px 3px black;" width="300px" height="200px" align="center">
<tr><td>Student_ID</td><td><input type="text" name="id" value="<?php echo $_SESSION['siid'] ;?>" </td></tr>
<tr>
<td> <font size="3" face="Times New Roman"> Message:</td>
<td>
<textarea  style="overflow:auto;resize:none" rows="3" cols="19" align="center" name="message" required x-moz-errormessage="Required"
autocomplete='off' onkeypress="return letter_validate(event);"></textarea>
</td>
</tr>
<tr>
<td align="center" colspan="2"><br><br><input type="submit" value="Send"  class="button_example" name="up">
</td></tr></table>
</form>	