<script src="js/validation.js" type="text/javascript"></script>
<div id="sidebar1">
<ul>
  <li><a class="active" href="#.html">Side Link</a></li>
     <li><a href="#">Add Programs<span><font size="1px">&#x25BC;</font></span></a>
      <ul>
        <li><a  href="managecollage.php">Add  College</a></li>
        <li><a href="managedept.php">Add  Department</a></li>
      </ul>
    </li>
  					<li>
					<?php
					$user_id=$_SESSION['suid'];
	$sql="SELECT * FROM course WHERE status='no'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>='1')
	{
					?>
						<a href="viewuploadmodule.php">
							
							<span style="color: red">View Uploded Module[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						else
						{
						?>
						<a href="viewuploadmodule.php">
							
							<span >View Uploded Module[<?php echo $count; ?>] </span>
						</a>
						<?php
						}
						?>
					</li>
<li><a href="#">Post Announcment<span><font size="1px">&#x25BC;</font></span></a>
      <ul>
  <li><a href="updateposti.php">Post updated Information</a></li>
  <li><a href="updatepost.php">Post registration date</a></li>
  <li><a href="updateposta.php">Post Application date</a></li>
      </ul>
</li>   
    <li><a href="#">View<span><font size="1px">&#x25BC;</font></span></a>
      <ul>
<li><a href="viewacadamicschedul.php">View acadamic schedule</a></li>
<li><a href="postresult.php">View Entrance Exam Result</a></li>
      </ul>
</li> 
    <li><a href="recordresult.php">Post Entrance Exam Result</a></li>
   
    

   	<div id="sidedate">
	<li><a class="active" href="#.php"> Calendar</a></li>
	 <?php
	 require("../date.php");
	 ?>
	 </div>
</ul>
</div>
