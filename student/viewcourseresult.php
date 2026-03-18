<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>
Student page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript\date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<style>
/* inline fallback when stylesheet isn't loaded: keep columns, spacing, and proportions */
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

    <!-- Header -->
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <!-- Menu -->
    <div id="menu">
        <?php require("menustud.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenustud.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">



		<?php
	//Include the PS_Pagination id
		include('ps_pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','root','');
	if(!$conn) die("Failed to connect to database!");
	$status = mysql_select_db('cde', $conn);
	if(!$status) die("Failed to select database!");
?>
<?php
		
		$dpt=$_SESSION['sdpt'];
		$scy=$_SESSION['syear'];
		$sec=$_SESSION['ssection'];
		$sem=$_SESSION['ssemister'];
		$uid=$_SESSION['suid'];	
$query = "select * from course_result where Department='$dpt' and year='$scy' and semister='$sem' and section='$sec' and S_ID='$uid'";
	$pager = new PS_Pagination($conn, $query, 5, 1);
	$rs = $pager->paginate();

$result = mysql_query($query);

if (!$result) 
{
	$message = 'ERROR:' . mysql_error();
	return $message;
}
else
{
	$i = 0;
	echo '<form action=" " method=post><table cellpadding="1" cellspacing="1" id="resultTable"><tr>';	
	while ($i < mysql_num_fields($result))
	{
		$meta = mysql_fetch_field($result, $i);
		if($meta->name=='status')
		break;
		echo '<th>' . $meta->name . '</th>';
		$i = $i + 1;
	}
	echo '</tr>';
	
	$i = 1;
	while ($row = mysql_fetch_row($result)) 
	{	
		echo '<tr>';
		$count = count($row);
		$y = 1;
		while ($y < $count)
		{
			$c_row = current($row);
			if($c_row=='approved' || $c_row=='post'|| $c_row=='posted')
			break;
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
	if($row1 = mysql_fetch_array($rs))
		echo '</tr>';
		$i = $i + 1;
	}
	echo '</table></form>';
	
}
						
?>
							 
	<?php
		//echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
				 

                 ?>
                                        <!-- /block -->
</div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>


                <?php
                echo "<b><br><font color=blue>Welcome:</font><font color=#f9160b>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
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
        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>
