<?php
session_start();
$dept=$_SESSION['dpt'];
$yea=$_SESSION['yea'];
$sem=$_SESSION['sem'];
$id=$_GET['id'];
$conn=mysql_connect("localhost","root","") or die(mysql_error());
	$sdb=mysql_select_db("cde",$conn) or die(mysql_error()); 
$query3=mysql_query("select * from student where department='$dept' and year='$yea' and semister='$sem' and S_ID='$id'");

if($row=mysql_fetch_assoc($query3))
{
		$y=$row['year'];
	$s=$row['semister'];
	if($y=='1st' and $s=='I'){		
			$query1=mysql_query("update student set semister='II',unread='yes' where  department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='1st' and $s=='II'){		
$query1=mysql_query("update student set semister='III',year='1st',unread='yes' where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='1st' and $s=='III'){		
			$query1=mysql_query("update student set semister='I',year='2nd',unread='yes' where  department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='2nd' and $s=='I'){		
$query1=mysql_query("update student set semister='II',year='2nd',unread='yes'  where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			
			else if($y=='2nd' and $s=='II'){		
$query1=mysql_query("update student set semister='III',year='2nd',unread='yes'  where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='2nd' and $s=='III'){		
$query1=mysql_query("update student set semister='I',year='3rd',unread='yes'  where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='3rd' and $s=='I'){		
$query1=mysql_query("update student set semister='II',year='3rd',unread='yes'  where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
			else if($y=='3rd' and $s=='II'){		
$query1=mysql_query("update student set semister='III',year='3rd',unread='yes'  where department='$dept' and year='$yea' and semister='$sem' and unread='not' and S_ID='$id'");
			$x='<script type="text/javascript">alert("Succssfully Updated!!!");
			window.location=\'studentlist.php\';</script>';
			echo $x;
			}
}
else
{
$x='<script type="text/javascript">alert("Already updated");
window.location=\'studentlist.php\';</script>';
echo $x;	
}
?>