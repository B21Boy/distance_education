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
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 3px solid #ca3d24;
    margin: 1em 0;
    padding: 0;
}
fieldset{
    border: 2px solid #3cb353;
    margin-left: -15px;
}
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
        </div>

        <div id="content">
            <div id="contentindex5">
<?php
include('ps_pagination.php');
$conn = mysql_connect('localhost','root','');
if(!$conn) die("Failed to connect to database!");
$status = mysql_select_db('cde', $conn);
if(!$status) die("Failed to select database!");
$uid=$_SESSION['suid'];
?>
                <fieldset><legend><b>List of Instructors who have participated in offering tutorial program</b></legend>
                <form action="" method="post">
                <p align="center" style="color: #2773d8;font-family: time new romans;font-size: 17;">Number of record:<?php
$count_item=mysql_query("select * from payment_table where UID='$uid' and type='tutorial'" ) or die(mysql_error());
$count=mysql_num_rows($count_item);
echo"<font color='red'>".($count)."</font>"; ?></p>
<?php
$query1 = mysql_query("select * from payment_table where UID='$uid' and type='tutorial'")
or die(mysql_error());

$sql = "SELECT * FROM payment_table where UID='$uid' and type='tutorial'";
$pager = new PS_Pagination($conn, $sql, 10,1);
$rs = $pager->paginate();

$count_my_message = mysql_num_rows($query1);
if ($count_my_message != '0'){
?>
                <table border="1" id="resultTable" cellspacing="0">
                <tr bgcolor="#CAE8EA">
                <th rowspan="2">No</th>
                <th rowspan="2">Sender<br>UID</th>
                <th rowspan="2">Tutors<br>Name</th>
                <th rowspan="2">Rank</th>
                <th rowspan="2">Course<br>he/she<br>tutored</th>
                <th rowspan="2">Cr<br>Hr</th>
                <th colspan="3">Students Who have taken the course</th>
                <th rowspan="2">No_of<br>hours<br>she/he<br>gave<br>tutorial</th>
                </tr>
                <tr bgcolor="#CAE8EA">
                <th>Department</th>
                <th>Year</th>
                <th>Section</th>
                </tr>
<?php
while($row = mysql_fetch_array($rs)){
$id=$row["no"];
?>
                <tr>
                <div class="post" id="del<?php echo $id; ?>">
                <td><?php echo $row["no"]; ?></td>
                <td><?php echo $row["UID"]; ?></td>
                <td><?php echo $row["Instructors_Name"]; ?></td>
                <td><?php echo $row["Rank"]; ?></td>
                <td><?php echo $row["Course_Code"]; ?></td>
                <td><?php echo $row["CrHr"]; ?></td>
                <td><?php echo $row["Department"]; ?></td>
                <td><?php echo $row["Year"]; ?></td>
                <td><?php echo $row["Section"]; ?></td>
                <td><?php echo $row["No_of_hours_she_he_gave_tutorial"]; ?></td>
                </div>
<?php } ?>
                </tr></table>
                </form>
<?php
echo '<div style="text-align:center">'.$pager->renderFullNav().'</div>';
}else{ ?>
                <div class="alert alert-info"><i class="icon-info-sign"></i> <font size="3px">No New Request found!</div>
<?php } ?>
                </fieldset>
            </div>
        </div>

        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>

                <p>
                    <b><font color="blue">Welcome:</font><font color="#f9160b">(<?php echo $first_name . "&nbsp;&nbsp;&nbsp;" . $last_name; ?>)</font></b>
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
