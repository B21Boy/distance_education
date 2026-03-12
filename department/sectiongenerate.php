
<?php
include("../connection.php");
$dept=$_GET['id'];
$query1 = mysql_query("select * from student where Department='$dept' and year='1st' and semister='I' and section=' '");
$count=mysql_num_rows($query1);
if($count>='1')
{
	$i=1;
while($row=mysql_fetch_array($query1))
			{
				$no=$row['S_ID'];
$qu = mysql_query("select * from entrance_exam where S_ID='$no' and status='satisfactory'");
$co=mysql_num_rows($qu);					
if($co>='1')	
{
		if($i<=3)
		{
		$no=$row['S_ID'];
		$update=mysql_query("update student set section='A' where S_ID='$no'");	
		}
		else if($i>3 && $i<=6){
		$no=$row['S_ID'];
		$update=mysql_query("update student set section='B' where S_ID='$no'");	
		}
		else if($i>6 && $i<=9){
		$no=$row['S_ID'];
		$update=mysql_query("update student set section='C' where S_ID='$no'");	
		}
		else{
		$no=$row['S_ID'];
		$update=mysql_query("update student set section='D' where S_ID='$no'");	
		}
$i++;
			
}
}
$x='<script type="text/javascript">alert("Succssfully Arranged !!!");
window.location=\'generateclass.php\';</script>';
echo $x;	
}
else
{
$x='<script type="text/javascript">alert("Alredy Arranged !!!");
window.location=\'generateclass.php\';</script>';
echo $x;
}
?>
