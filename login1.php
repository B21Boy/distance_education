<head>
<script src="theme.js"></script>
<script language ="javascript" >
var tim;
var min =1;
var sec =10;
function f1()
{
f2();
}
function f2() 
{
		if (parseInt(sec) > 0)
		{
		sec = parseInt(sec) - 1;
		document.getElementById("showtime").innerHTML = min+" :" + sec;
		tim = setTimeout("f2()", 1000);
		}
		else
		 {
		if (parseInt(sec) == 0)
		 {
		min = parseInt(min) - 1;
		
		if (parseInt(min) == 0) 
		{
		clearTimeout(tim);
		location.href ="index.php";
		
		}
		else
		 {
		sec = 60;
		document.getElementById("showtime").innerHTML = min+" :" + sec;
		tim = setTimeout("f2()", 1000);
		}
		}
		}
}
</script> 
<style>
#container1 {
 position: relative;
 width: 180px;
 height: 280px;
 background: lighter;
 margin-top: -15px;
 box-shadow: 5 4px 7px rgba(0, 0, 0, .1);
 background-color: #aeaeae;
}
 
.form {
 margin: 0 auto;
 margin-top: 20px;
 
} 
.label1 {
 color: #020200;
 display: inline-block;
 margin-left: 18px;
 padding-top: 10px;
 font-size: 17px;
}
.input {
 font-family: "Helvetica Neue", Helvetica, sans-serif;
 font-size: 12px;
 outline: none;
}
 
.input[type=text],
.input[type=password] {
 color: #000;
 padding-left: 10px;
 margin: 10px;
 margin-top: 12px;
 margin-left: 18px;
 width: 150px;
 height: 30px;
 border: 1px solid #41b47a;
 border-radius: 10px;

 -webkit-transition: all .4s ease;
 -moz-transition: all .4s ease;
 transition: all .4s ease;
}
 
.input[type=text]:hover,
.input[type=password]:hover {
 border: 1px solid #41b47a;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 5px #D6AE58;
}
 
.input[type=text]:focus{
 border: 1px solid #a8c9e4;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
}
.input[type=password]:focus {
 border: 1px solid #a8c9e4;
 box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
}


.btn{
  background:#3594D2;

  padding-top:5px;
  padding-bottom:5px;
  color:white;
  border-radius:4px;
  border: #2980b9 1px solid;
  padding-left: 10px;
  margin-top:20px;
  margin-bottom:20px;
  float:left;
  margin-left:26px;
  font-weight:800;
  font-size:15px;
}

.btn:hover{
  background:#0b2231; 
}
</style>
</head>
<body onload="f1()">
<div id="container1">
  	<div class="login">
  
        <form action="" method="post" class="form">
		<label class="label1" for="username">Username:</label>
           <input type="text" id="username" name="un" placeholder="Username" required class="input" readonly>
            <label for="password" class="label1">Password:</label>
            <input type="password" id="password" name="pass" placeholder="Password" required class="input" readonly>
<input type="submit" id="submit" class="btn" name="login" value="Login" style="height: 34px; margin-left: 15px; width: 60px; padding: 5px; border: 3px double rgb(204, 204, 204);"/>
<input type="reset" id="reset" class="btn" name="reset" value="Reset" style="height: 34px; margin-left: 15px; width: 60px; padding: 5px; border: 3px double rgb(204, 204, 204);" />
</div>

		
</div>
<?php
include("connection.php");
$sql1=mysql_query("select * from attempt");
$c=mysql_num_rows($sql1);
if($c>0)
$sql=mysql_query("delete from attempt");	
?>
		</form>
	<font color=red><font size=3px>Wait 10 Seconds
<div id="showtime"></div></font></font>
</body>
