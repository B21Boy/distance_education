

<?php
include("../connection.php");
$dept=$_GET['id'];
$query1 = mysql_query("select * from student where Department='$dept' and year='1st' and semister='I' and section!=' ' and status=' ' ORDER BY section,FName ASC")or die(mysql_error());
$count=mysql_num_rows($query1);

if($count>='1')
{
$aa=mysql_query("SELECT * FROM student where Department='$dept' ORDER BY S_ID DESC LIMIT 1");
	$t=mysql_fetch_array($aa);
	$b=$t['S_ID'];
		$x ='ACC/';
		$x1 ='LAW/';
		$x2 ='MNGT/';
		$x3 ='ECNS/';
		$d=date('y');
		$dd=$d-8;
		function add_nol($number,$add_nol) {
		   while (strlen($number)<$add_nol) {
		       $number = "0".$number;
		   }
		   return $number;
		}
		for($y=1;$y<=$count;$y++){

	     	if($dept=='Accounting')
			$id=$x."".add_nol($y,4).'/'.$dd;
			else if($dept=='law')
			$id=$x1."".add_nol($y,4).'/'.$dd;
			else if($dept=='Economics')
			$id=$x3."".add_nol($y,4).'/'.$dd;
			else if($dept=='Managament')
			$id=$x2."".add_nol($y,4).'/'.$dd;
			
			if($row=mysql_fetch_array($query1))
			{
				$no=$row['S_ID'];
$qu = mysql_query("select * from entrance_exam where S_ID='$no' and status='satisfactory'");
$co=mysql_num_rows($qu);					
if($co>='1')	
{
$update0=mysql_query("update entrance_exam set S_ID='$id' where S_ID='$no'");				
$update=mysql_query("update student set S_ID='$id',status='ok' where S_ID='$no'");
$update1=mysql_query("update user set UID='$id' where UID='$no'");
$q = mysql_query("select * from user where UID='$id'");
		$rr=mysql_fetch_array($q);
		$sid=$rr['UID'];
$update2=mysql_query("update account set UID='$id' where UID='$sid'");
			
}
			}
		}	
		if($update)
		{
$x='<script type="text/javascript">alert("Succssfully Generated !!!");
window.location=\'generateclass.php\';</script>';
echo $x;	
		}

}
else
{
$x='<script type="text/javascript">alert("Alredy Generated !!!");
window.location=\'generateclass.php\';</script>';
echo $x;
}

?>
