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
					<li>
						<a  href="viewgrade.php">
						
							<span>Prepare Grade Report</span>
						</a>
					</li>
					  <li><a href="registerstudentdata.php">Import Studnet Data</a></li>
					  		<li>
					<?php
					if (!isset($conn)) {
						require_once("../connection.php");
					}

					$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
					$count = 0;
					if ($user_id !== '') {
						$sql = "SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
						$result = mysqli_query($conn, $sql);
						if ($result instanceof mysqli_result) {
							$count = mysqli_num_rows($result);
							mysqli_free_result($result);
						}
					}
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
