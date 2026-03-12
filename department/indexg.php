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
                <div class="row">
            	<?php
$query2 = "select distinct department,section,year from grade where status='approve' and checking='pending' and department='$dcode'";
$result2 = mysql_query($query2);
$coun=mysql_num_rows($result2);
while($row=mysql_fetch_array($result2))
{
$s=$row['section'];
$y=$row['year'];

$query1 = mysql_query("select distinct department,section,year from grade where status='approve' and checking='pending' and department='$dcode' and year='$y' and section='$s'")or die(mysql_error());
$coun = mysql_num_rows($query1);
if($row1=mysql_fetch_array($query1))
{	
?>	               
 
                
                 <form action="viewgradeallv.php" method="post">
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
echo'<table>';
echo '<tr><td>Department</td><td><input type=text style=width:80px; name=d readonly value='.$dcode.'></td></tr>';
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
                </div>
              </center>
              
 