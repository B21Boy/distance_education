
<head>
<!--sa poip up-->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
   <script src="lib/jquery.js" type="text/javascript"></script>
  <script src="src/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'src/loading.gif',
        closeImage   : 'src/closelabel.png'
      })
    })
  </script>
</head>

<table>
<tr><td>
  <div id="menubar1">
  <ul>
             	<?php
$queryt = mysql_query("select * from payment_table where unread='yes' and status='no' and type='tutorial'")or die(mysql_error());
$count = mysql_num_rows($queryt);

$queryi = mysql_query("select * from payment_table where unread='yes' and status='no' and type='iexam'")or die(mysql_error());
$couni = mysql_num_rows($queryi);

$querymea =mysql_query("select * from payment_table where unread='yes' and status='no' and type='mexamassign'")or die(mysql_error());
$counmea = mysql_num_rows($querymea);

$queryma= mysql_query("select * from payment_table where unread='yes' and status='no' and type='massignment'")or die(mysql_error());
$counma = mysql_num_rows($queryma);

$queryme= mysql_query("select * from payment_table where unread='yes' and status='no' and type='mexam'")or die(mysql_error());
$counme = mysql_num_rows($queryme);

$querype = mysql_query("select * from payment_table where unread='yes' and status='no' and type='pexam'")or die(mysql_error());
$counpe = mysql_num_rows($querype);

$total=$count+$couni+$counmea+$counma+$counme+$counpe;
?>
  <li><a href="cdeofficerpage.php">Calculate Employee Worked Fee<span style="color: #dbf428">[<?php echo $total; ?>] </span></a> </li>
<li><a href="preparemoduleschedule.php">Post module Preparation schedule</a> </li>

  				
					<?php
					$user_id=$_SESSION['suid'];
	$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>='1')
	{
					?>
					<li>
						<a href="usernotification.php">
							
							<span style="color: #dbf428">Notification[<?php echo $count; ?>] </span>
						</a></li>
						<?php
						}
						else
						{
						?>
						<li><a href="usernotification.php">
							
							<span >Notification[<?php echo $count; ?>] </span>
						</a></li>
						<?php
						}
						?>
					
<li>                  
<a href="../logout.php">
							
							<span>Log out</span></a></li></ul>
</div>
</td></tr></table>
