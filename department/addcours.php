  	<?php
include("../connection.php");
?>	
  		<?php
		
class Module{
			var $con;
			var $query;
			var $res;
			var $destination;
			var $ccode;
			var  $cname;
			var  $ch;
			var $ayear;
			var $dept;
			var $year;
			var $sem;
			var $fileName;
			var $tmpName;
			var $fileSize;
			var $fileType;
			
function connects()
{
			$this->con=mysql_connect("localhost","root","");
			mysql_select_db("cde");
}
function query()
{

				$this->ccode=$_POST['cd'];
				$this->cname=$_POST['cn'];	
				$this->ch=$_POST['ch'];
				$this->ayear=$_POST['ayear'];	 
				$this->dept=$_POST['dc'];
$this->query="insert into course(course_code,cname,chour,ayear,department) values('$this->ccode','$this->cname','$this->ch','$this->ayear','$this->dept')";
				$this->res=mysql_query($this->query,$this->con);
    }
function display()
{
			if(mysql_affected_rows()==1)
			{
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ipaddress=$http_client_ip;
		}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ipaddress=$http_x_forwarded_for;	
		}else{
			$ipaddress=$_SERVER['REMOTE_ADDR'];
		}
		session_start();
		
		$uid=$_SESSION['suid'];	
				$result=mysql_query("select*from account where UID='$uid'");
				$row=mysql_fetch_array($result);
				$role=$row['Role'];
				
				$time = time();
			$actual_time = date('d M Y @ H:i:s', $time);
			$user=$_SESSION['suid'];
			$status='yes';
			$logid=2;
			$da=date('y-m-d');
mysql_query("INSERT INTO logfile (logid,username,role,status,start_time,activity_type,activity_performed,date,ip_address,end)  VALUES(' ','depthead','Department_Head','$status','$actual_time','Add course',concat('uid[','$uid','] ','role[','$role','] ','status[','$status','] '),'$da','$ipaddress','')");

$x='<script type="text/javascript">alert("Successfully Registerd !!!");
window.location=\'managecourse.php\';</script>';
echo $x;
			}
			else
			{
die("<script>alert('Error! not registerd!');
window.location=\'managecourse.php\';</script>" . mysql_error());	   	
			}
			}
}
$Mod=new Module();
$Mod->connects();
$Mod->query();
$Mod->display();
?>