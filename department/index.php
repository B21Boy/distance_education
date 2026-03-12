
       <?php

require('../connection.php');
$dept=$_SESSION['sdc'];
	$uid=$_SESSION['suid'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
?>
        <link href="csss/css1.css" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="csss/startmin.css" rel="stylesheet"/>
            <center>
             <div id="page-wrapper">
                <!-- /.row -->
            
            	<?php
$query = mysql_query("select distinct uid,section,C_Code,year from course_result where status='posted' and reject=' ' and send_to='$dept'")or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$id=$row['uid'];
$s=$row['section'];
$cc=$row['C_Code'];
$y=$row['year'];
$query1 = mysql_query("select * from course_result where status='posted' and reject=' ' and uid='$id' and section='$s' and C_Code='$cc' and year='$y' and send_to='$dept'")or die(mysql_error());
$coun = mysql_num_rows($query1);
if($row1=mysql_fetch_array($query1))
{
	
	$d=$row1['Department'];
	
	
?>	               
 
                
                 <form action="approvecourseresult.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
                                        <?php
echo'<table><tr styele=color:white><td>Instructor Name</td><td><input type=text style=width:80px; name=id readonly value='.$id.'></td></tr>';
echo '<tr><td>Course Name</td><td><input type=text style=width:80px; name=cc readonly value='.$cc.'></td></tr>';
echo '<tr><td>Department</td><td><input type=text style=width:80px; name=d readonly value='.$d.'></td></tr>';
echo '<tr><td>Year</td><td><input type=text style=width:80px; name=y readonly value='.$y.'></td></tr>';
 echo '<tr><td>Section</td><td><input type=text style=width:80px; name=s readonly value='.$s.'></td></tr></table>';
                                        	?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <a href="">
                                <div class="panel-footer">
                                  <span class="pull-left"> <input type="submit" style="background-color: pink" name="view" value="View Details"/> </span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    
                                </div>
                            </a>
                        </div>
                    </div>
                    </form>
     <?php
     }
     }
     ?>               
            </div>
             
              </center>
