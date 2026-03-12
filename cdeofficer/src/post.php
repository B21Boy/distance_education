
<!--------body  --->
<h2 align="center">Post New Information</h2>
<form action="post.php" method="POST" onsubmit='return formValidation()'>
Title:<input type="text"name="title" size="32" id="type"  placeholder="Enter the title"><br>
Type:<input type="text"name="typ" size="32" id="typ"  placeholder="Enter the type"><br>
Expired Date:<input type="date" name="date" size="32" id="date"  placeholder="the date"><br>
<b>Information:</b>
<textarea name="infor" id="infor" placeholder="Write information here" cols="34" rows="7"></textarea><br>
User name<input type="text" name="user_id"  id="user_id"/><br>
<input value="Post" name="sent" type="Submit" Onclick="return check(this.form);"/>
<input value="Reset" type="Reset"> 
</form>

<?php
 if(isset($_POST['sent']))
 {
$user_id=$_POST['user_id'];
$title=$_POST['title'];
 $exdate=$_POST['date'];
 $date=date('Y-m-d');
 $typ=$_POST['typ'];
 $infor=$_POST['infor'];
 $conn = mysql_connect('localhost','root','');
mysql_select_db("cde", $conn);

if($exdate>=$date)
			{
$sql=mysql_query("INSERT INTO postss (Title,types,dates,Ex_date,info,User_name)VALUES('$title','$typ','$date','$exdate','$infor','$user_id')") or die(mysql_error());
							if(!$sql)
					{
						die("Data not posted:".mysql_error());
					}
					else
					{
						
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Successfully post";
					}
			}
	else
			{
				echo "Please check Expired date";
			}

 }

?>
