<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<title>
Administrator page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>

</head>
<body>
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="3">
<?php
    require("menu.php");
?>
</td></tr>
<tr><td>
<?php
	 require("sidemenu.php");
?>
	
</td><td>
	<div id="contentindex5">
<?php
	$tables = array();
	$query = mysqli_query($conn, 'SHOW TABLES');
	while($row = mysqli_fetch_row($query))
	{
		 $tables[] = $row[0];
	}

	$result = "";
	foreach($tables as $table)
	{
		$query = mysqli_query($conn, 'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($query);

		$result .= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query($conn, 'SHOW CREATE TABLE '.$table));
		$result .= "\n\n".$row2[1].";\n\n";

		for ($i = 0; $i < $num_fields; $i++)
		{
			while($row = mysqli_fetch_row($query))
			{
			   $result .= 'INSERT INTO '.$table.' VALUES(';
				 for($j=0; $j<$num_fields; $j++)
				 {
				   $row[$j] = addslashes($row[$j]);
				   $row[$j] = str_replace("\n","\\n",$row[$j]);
				   if(isset($row[$j]))
				   {
					   $result .= '"'.$row[$j].'"' ; 
					}
					else
					{ 
						$result .= '""';
					}
					if($j<($num_fields-1))
					{ 
						$result .= ',';
					}
				}
				$result .= ");\n";
			}
		}
		$result .="\n\n";
	}

//Create Folder
$folder = 'C:/wamp/www/cde[1]/admin/db/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

//$date = date('m-d-Y-h-m-s'); 
$filename = $folder."backup"; 

$handle = fopen($filename.'.sql','w+');
fwrite($handle,$result);
fclose($handle);
?>

	
	<?php
	
        echo "Database Backed Up Successfully!!!<br>";
        echo "Path:$filename";
    ?>

 </div>
        </td>
	 <td>
	 <div id="siderightindexphoto">
	 <div id="siderightindexphoto1">
	 User Profile
	 </div>
	 
		
	 <?php
echo "<b><br><font color=#fffdfd>Welcome:</font><font color=#dbf428>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>"; 
?>
<div id="sidebarr">
<ul>
 <li><a href="updateprofilephoto.php">Change Photo</a></li>
	<li><a href="changepass.php">Change password</a></li>
	 </ul>
</div>
	 </div>
	 <div id="siderightindexadational">
	 <div id="siderightindexadational1">
	 Social link 
	 </div>
	 <div id="siderightindexadational12">
	 <table>
	 <tr><td><div id="facebook"></div></td><td>
	<p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a><p></td></tr>
	<tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
	<tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
	<tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr></table>
	</div>
	 </div>
	  </td>
	 </tr>
	 <tr><td>
<?php
include("../footer.php");
?>
</td></tr>

</div>
</table>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>