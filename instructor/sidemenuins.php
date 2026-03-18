<?php

if (!isset($conn)) {
	include("../connection.php");
}
$idd = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
?>
<div id="sidebar1">
<ul>
  <li><a class="active" href="#.html">Side Menu</a></li>
  <li><a  href="uploadmodule.php"><span>View Assigned Course</span></a></li>
  <li><a  href="postresult.php">Record course result</a></li>
     <li><a href="viewgrade.php">Post course result</a></li>
  					<?php
$coun = 0;
if ($idd !== '') {
	$query = mysqli_query($conn, "select DISTINCT uid from course_result where status='not' and uid='$idd'");
	if ($query instanceof mysqli_result) {
		$coun = mysqli_num_rows($query);
		mysqli_free_result($query);
	}
}
if($coun>='1')
{
?>									
<li><a href="courseresultrequest.php"><font size="3px" color="#940f0c">Rejected Student result[<?php echo $coun?>]</font></a></li>
		<?php
		}
		else
		{
			?>
<li><a href="courseresultrequest.php">View Request</a></li>
			<?php
		}
		?>
    <li><a href="#">View<span><font size="1px">&#x25BC;</font></span></a>
      <ul>
<li><a  href="viewassgin.php"><span>View uploded Asigment</span></a></li>
<li><a href="preparemoduleschedule.php">View Module Preparation schedule</a></li>
  <li><a href="viewcourse.php">View course result</a></li>
      </ul>
</li>

	<div id="sidedate">
	<li><a class="active" href="#.php"> Calendar</a></li>
	 <?php
	 require("../date.php");
	 ?>
	 </div>
</ul>
</div>
