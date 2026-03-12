<table>
<tr><td>
  <div id="menubar1">
  
  <ul>
 <li></li>  <li></li>
					<?php
						$id=$_SESSION['suid'];
$s=mysql_query("select*from user where UID='$id'");
$rr=mysql_fetch_array($s);
$cc=$rr['c_code'];

$query1 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='tutorial'and c_code='$cc'")
or die(mysql_error());
$coun1 = mysql_num_rows($query1);
$query2 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='mexamassign'and c_code='$cc'")
or die(mysql_error());
$coun2 = mysql_num_rows($query2);
$query3 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='iexam'and c_code='$cc'")
or die(mysql_error());
$coun3 = mysql_num_rows($query3);
$query4 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='massignment'and c_code='$cc'")
or die(mysql_error());
$coun4 = mysql_num_rows($query4);
$query5 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='mexam'and c_code='$cc'")
or die(mysql_error());
$coun5 = mysql_num_rows($query5);
$query6 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='pexam'and c_code='$cc'")
or die(mysql_error());
$coun6 = mysql_num_rows($query6);
$query7 = mysql_query("select * from payment_table where status=' ' and unread='no'  and type='module'and c_code='$cc'")
or die(mysql_error());
$coun7 = mysql_num_rows($query7);

$total=$coun1+$coun2+$coun3+$coun4+$coun5+$coun6+$coun7;
if($total>='1')
{
?>									
<li><a href="allrequest.php"><font size="4px" color="#f0e459">New Request From Department[<?php echo $total?>]</font></a></li>
		<?php
		}
		else
		{
			?>
<li><a href="allrequest.php">Request For Employee worked Time</a></li>
			<?php
		}
		?>
		<li><a href="viewacadamicschedul.php">View Acadamic Schedule</a></li>
		
					<li>
					<?php
					$user_id=$_SESSION['suid'];
	$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>='1')
	{
					?>
						<a href="usernotification.php">
							
							<span style="color: #dbf428">Notification[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						else
						{
						?>
						<a href="usernotification.php">
							
							<span >Notification[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						?>
					</li>
					<li>
						<a href="../logout.php">
							
							<span>Log out</span>
						</a>
					</li>
					
					
					<div class="clearfix"></div>
				</ul>             
	</div>					
</td></tr></table>