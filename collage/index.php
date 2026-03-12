
       <?php
require('../connection.php');

$id=$_SESSION['suid'];

$s=mysql_query("select*from user where UID='$id'");
$rr=mysql_fetch_array($s);
$cc=$rr['c_code'];
?>
        <link href="csss/css1.css" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="csss/startmin.css" rel="stylesheet"/>
            <center>
             <div id="page-wrapper">
                <!-- /.row -->
                
            	<?php
$query = mysql_query("select distinct status,unread,type from payment_table where status=' ' and unread='no' and c_code='$cc'")or die(mysql_error());
while($row=mysql_fetch_array($query))
{
$p=$row['type'];
$query1 = mysql_query("select * from payment_table where status=' ' and unread='no' and c_code='$cc' and type='$p'")or die(mysql_error());
$coun = mysql_num_rows($query1);
if($row1=mysql_fetch_array($query1))
{
$pp=$row['type'];
if($pp=='tutorial')
{
$d='Offering Tutorial Program';	
?>
             
                 <form action="unreaddotutorial.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                           											
                                        <div class="text-right"> 
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
                                       
										<?php
										echo $d;
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
else if($pp=='mexam')
{
$d='Marking Exam';
?>
                
                 <form action="unreaddmexam.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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
else if($pp=='massignment')
{
$d='Marking Assignment';
?>
                
                 <form action="unreaddmassignment.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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

else if($pp=='iexam')
{
$d='Inviglating Final Exam';
?>
                
                 <form action="unreaddifexam.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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
else if($pp=='pexam')
{
$d='Preparing Exam';
?>
                
                 <form action="unreaddpexam.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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
else if($pp=='mexamassign')
{
$d='Marking Exam and Assignment';	
?>

                
                 <form action="unreaddmexamassgin.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">											
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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
else{
$d='Preparing Module';	
?>
                
                 <form action="unreaddpmodule.php" method="post">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">	
                                         <img src="csss/a.png" height="30" width="140" style="margin-left: -20px;">										
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                   	 	
                                        </div>
                                        <div>
										<?php
										echo $d;
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
     }
     ?>               
            </div>
              
              </center>
