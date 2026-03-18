	<?php
	if (!isset($conn)) {
		include("../connection.php");
	}
	?>
<script src="js/validation.js" type="text/javascript"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
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
<style>
.dropdown {
    float: left;
    overflow: hidden;
    
}
.dropdown .dropbtn1 {
    font-size: 15px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color:inherit;
    font-family: inherit;
    margin-left: 30px;
    margin-top: 4px;
    
}
.dropdown:hover .dropbtn1 {
    	color:#fffbfb;
	background:#2C5463;
	border-radius:5px;
}
.dropdown-content {
    display: none;
    position: absolute;
  background:#336699;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
   margin-left: 30px;
}

.dropdown-content a {
    float: none;
    color: #ffffff;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
     margin-left: -1px;
     font-size: 15px; 
}

.dropdown-content a:hover {
    background-color:#2C5463;
    color:#ffffff;
    font-size: 15px;
   
    
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
<table>
<tr><td>
  <div id="menubar1">
  
  <ul>
					<li>
						<a  href="managecourse.php">
							
							<span>Register course</span>
						</a>
					</li>
					<li>
						<a href="manageinst.php">
							
							<span>Assign instructor</span>
						</a>
					</li>
					
					 
					
<div class="dropdown">
    <button class="dropbtn1">Prepare Employee worked time<span><font size="2px">&#x25BC;</font></span></button>
    <div class="dropdown-content">
      <a  rel="facebox"href="offeringtutorial.php">Offering Tutorial Program</a>
      <a rel="facebox" href="markingexam.php">Marking Exams</a>
      <a  rel="facebox"  href="markingassignment.php">Marking Assignments</a>
      <a rel="facebox" href="invigilatingfexam.php">Invigilating Final Exams</a>
      <a rel="facebox" href="preparingexam.php">Preparing Exams</a>
      <a rel="facebox"  href="markingexamassign.php">Marking Exams and Assignments</a>
    </div>
</div>
					<li>
					<?php
					$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
	$count = 0;
	if ($user_id !== '') {
		$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
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
