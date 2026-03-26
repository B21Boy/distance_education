<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>
CDE Officer page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<div id="header">
<?php
    require("header.php");
?>
</div>
<div id="menu">
<?php
    require("menucdeo.php");
?>
</div>
<div class="main-row">
<div id="left">
<?php
	 require("sidemenucdeo.php");
?>
	
</div><div id="content">
	<div id="contentindex5">

<?php
$y=date('Y');
$query = "select * from entrance_exam where year='$y'";
$result = mysql_query($query);

	$i = 0;
	echo '<form action=" " method=post><table cellpadding="1" cellspacing="1" id="resultTable"><tr>';	
	while ($i < mysql_num_fields($result))
	{
		$meta = mysql_fetch_field($result, $i);
		if($meta->name =='Account')
		break;
		echo '<th>' . $meta->name . '</th>';
		$i = $i + 1;
	}
	echo '</tr>';
	
	$i = 0;
	while ($row = mysql_fetch_row($result)) 
	{	
		echo '<tr>';
		$count = count($row);
		$y = 0;
		while ($y < $count)
		{
			$c_row = current($row);
			
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '</tr>';
		$i = $i + 1;
	}
	echo '</table></form>';
	
?>
</div></div>
	 <div id="sidebar">
<?php
    require("officer_sidebar.php");
?>
	 </div>
	 </div>
	 <div id="footer">
<?php
include("../footer.php");
?>
    </div>
</div>

<?php
}
else
{
header("location:../index.php");
exit;
}
?>
</body>
</html>
