
  		<?php
		
class assignment{
			var $con;
			var $query;
			var $res;
			var $destination;
			var $asno;
			var $asv;
			var $ccode;
			var $cname;
			var $dept;
			var $scyear;
			var $sem;
			var $sdate;
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
				$this->destination = "assignment\\" . $_FILES["file"]["name"];//****************upload page******//
				$this->uid=$_POST['uid'];
				$this->asno=$_POST['asno'];
				$this->asv=$_POST['asv'];
				$this->ccode=$_POST['cc']; 
				$this->cname=$_POST['cn'];				
				$this->dept=$_POST['dc'];	 
				$this->scyear=$_POST['scy'];	
				$this->sem=$_POST['sem'];	 
				$this->sdate=$_POST['date'];		 
				$this->fileName=$_FILES['file']['name'];
				$this->tmpName=$_FILES['file']['tmp_name'];
				$this->fileSize=$_FILES['file']['size'];
				$this->fileType=$_FILES['file']['type'];
				
$this->query="insert into assignment values(' ','$this->uid','$this->asno','$this->asv','$this->ccode','$this->cname','$this->dept','$this->scyear','$this->sem','$this->sdate','$this->fileName','$this->tmpName','$this->fileSize','$this->fileType','inst','no')";
				$this->res=mysql_query($this->query,$this->con);
    }
function display()
{
			if(mysql_affected_rows()==1)
			{
$x='<script type="text/javascript">alert("Successfully Uploded !!!");
window.location=\'uploadmodule.php\';</script>';
echo $x;
			}
			else
			{
die("<script>alert('Error! not Uploded!');
window.location=\'uploadmodule.php\';</script>" . mysql_error());	   	
			}
			}
}
$as=new assignment();
$as->connects();
$as->query();
$as->display();
?>
 