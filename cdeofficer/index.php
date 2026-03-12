
       
        <link href="csss/css1.css" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="csss/startmin.css" rel="stylesheet"/>
            <center>
             <div id="page-wrapper">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                        	
           	<?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='tutorial'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>                                    	 	
                                        </div>
                                        <div>Offering Tutorial Program</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddotutorial.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                        	
 <?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='iexam'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>                                      	
                                        	
                                        </div>
                                        <div>Inviglating Final Exam</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddifexam.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
 <?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='mexamassign'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#dbf428">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>
                                        </div>
                                        <div>Marking Exam and Assignment</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddmexamassgin.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
 <?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='massignment'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>
                                        </div>
                                        <div>Marking Assignment</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddmassignment.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                                        <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                        	
           	<?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='mexam'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#eaf50a">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>                                    	 	
                                        </div>
                                        <div>Marking Exam</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddmexam.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    
                    
<div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="text-right">
                                        	
 <?php
$query = mysql_query("select * from payment_table where unread='yes' and status='no' and type='pexam'")
or die(mysql_error());
$coun = mysql_num_rows($query);
if($coun>='1')
{
?>												
<font size="3px" color="#dbf116">New Request[<?php echo $coun?>]</font>                                       	
<?php
}
?>                                      	
                                        	
                                        </div>
                                        <div>Preparing Exam</div>
                                    </div>
                                </div>
                            </div>
                            <a href="unreaddpexam.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
              </center>
