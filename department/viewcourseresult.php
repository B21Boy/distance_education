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
Department head page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
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
    $first_name = htmlspecialchars($_SESSION['sfn'], ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars($_SESSION['sln'], ENT_QUOTES, 'UTF-8');
    $photo_value = isset($_SESSION['sphoto']) ? trim($_SESSION['sphoto']) : '';
    $photo_path = htmlspecialchars($photo_value, ENT_QUOTES, 'UTF-8');
?>
<div id="container">
    <div id="header">
        <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menudepthead.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenudepthead.php"); ?>
<?php
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
?>
        </div>

        <div id="content">
            <div id="contentindex5">
<?php
include('ps_pagination.php');
$conn = mysql_connect('localhost','root','');
if(!$conn) die("Failed to connect to database!");
$status = mysql_select_db('cde', $conn);
if(!$status) die("Failed to select database!");

$query = "select * from course_result where status='approved' and Department='$dcode'";
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
    echo'<h3>List Of Students Course Result</h3>';
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
            if($c_row=='approved')
            break;
            echo '<td>' . $c_row . '</td>';
            next($row);
            $y = $y + 1;
        }
        echo '</tr>';
        $i = $i + 1;
    }
    echo '</table></form>';
}
?>
<?php echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>'; ?>
            </div>
        </div>

        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>

                <p>
                    <b><font color="blue">Welcome:</font><font color="#e70f0a">(<?php echo $first_name . "&nbsp;&nbsp;&nbsp;" . $last_name; ?>)</font></b>
                </p>
                <?php if ($photo_path !== '') { ?>
                <p><b><img src="<?php echo $photo_path; ?>" width="180" height="160" alt="Department head profile photo"></b></p>
                <?php } ?>

                <div id="sidebarr">
                    <ul>
                        <li><a href="#.html">Change Photo</a></li>
                        <li><a href="changepass.php">Change password</a></li>
                    </ul>
                </div>
            </div>

            <div id="siderightindexadational">
                <div id="siderightindexadational1">
                    Another link
                </div>
                <div id="siderightindexadational12">
                    <table>
                        <tr><td><div id="facebook"></div></td><td><p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a></p></td></tr>
                        <tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
                        <tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
                        <tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include("../footer.php"); ?>
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
