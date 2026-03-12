<?php
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
	$uid=$_SESSION['suid'];
?>

<div id="sidebar1">
<ul>

  <li><a class="active" href="#.html">Side Menu</a></li>
   <li><a href="#">View Employee worked time</a>
      <ul>
        <li><a href="messageddotutorial.php">Offering Tutorial Program</a></li>
        <li><a href="messageddmexam.php">Marking Exams</a></li>
        <li><a href="messageddmassignment.php">Marking Assignments</a></li>
        <li><a href="messageddifexam.php">Invigilating Final Exams</a></li>
        <li><a href="messageddpexam.php">Preparing Exams</a></li>
        <li><a href="messageddmexamassign.php">Marking Exams and Assignments</a></li>
      </ul>
    </li>
   <?php
$query = "select distinct uid,section,C_Code,year from course_result where status='posted' and reject=' ' and send_to='$dept'";
$result = mysql_query($query);
$count=mysql_num_rows($result);

$query2 = "select distinct department,section,year from grade where status='approve' and checking='pending' and department='$dcode'";
$result2 = mysql_query($query2);
$count2=mysql_num_rows($result2);
$t=$count+$count2;
?>
    <li><a href="#.php"><font size="3px" color="#940f0c">Approve student results[<?php echo $t;?></font>]</a>
    <ul>
        <li><a href="allrequest.php">Course Result[<?php echo $count;?>]</a></li>
        <li><a href="allrequestgr.php">Grade Report[<?php echo $count2;?>]</a></li>
      </ul>
    </li>
<li><a href="#.php">View </a>
    <ul>
    <li><a href="generateclass.php">View Student</a></li>
         <li><a href="viewacadamicschedul.php">View academic schedule</a></li>
        <li><a href="viewcourseresult.php">View Course Result</a></li>
        <li><a href="#.php">View Grade Report</a></li>
      </ul>

</li>
    <li><a href="updatepost.php">Post notice</a></li>
    
    	<div id="sidedate">
	<li><a class="active" href="#.php"> Calendar</a></li>
	 <?php
	 require("../date.php");
	 ?>
	 </div>
</ul>
</div>


      
      
      
      
      
      
