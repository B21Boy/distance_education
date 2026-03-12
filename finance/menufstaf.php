
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
<table>
<tr><td>
  <div id="menubar1">
  
  <ul>	
  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>  <li></li>  <li></li>
<?php
$query1 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='tutorial'")
or die(mysql_error());
$coun1 = mysql_num_rows($query1);
$query2 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexamassign'")
or die(mysql_error());
$coun2 = mysql_num_rows($query2);
$query3 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='iexam'")
or die(mysql_error());
$coun3 = mysql_num_rows($query3);
$query4 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='massignment'")
or die(mysql_error());
$coun4 = mysql_num_rows($query4);
$query5 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='mexam'")
or die(mysql_error());
$coun5 = mysql_num_rows($query5);
$query6 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='pexam'")
or die(mysql_error());
$coun6 = mysql_num_rows($query6);
$query7 = mysql_query("select * from payment_table where status='yes' and unread='yes' and payment='check' and type='module'")
or die(mysql_error());
$coun7 = mysql_num_rows($query7);

$total=$coun1+$coun2+$coun3+$coun4+$coun5+$coun6+$coun7;
if($total>='1')
{
?>									
<li><a href="allrequest.php"><font size="4px" color="#f0e459">New Request From CDE Officer[<?php echo $total?>]</font></a></li>
		<?php
		}
		else
		{
			?>
<li><a href="allrequest.php">Request For Employee Worked pay</a></li>
			<?php
		}
		?>
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
							
							<span>Log out</span>
						</a>
					</li>
					
					
					<div class="clearfix"></div>
				</ul>             
	</div>					
</td></tr></table>