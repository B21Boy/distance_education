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
Director page
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
        <?php require("menudir.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenudir.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
<?php
$con=mysql_connect("localhost","root","");
$result = mysql_query("SELECT * FROM acadamic_calender WHERE semister='Semister one'");
$result1 = mysql_query("SELECT * FROM acadamic_calender WHERE semister='Semister two'");
echo "<table border='1' style='width:590px;' align='center'><font color=white>
<tr>
<th bgcolor='#408c70' colspan='3'><font color='white' size='5'>Semister One</th></tr>
<tr>
<th bgcolor='#336699'><font color='white' size='5'>No</th>
<th bgcolor='#336699'><font color=white size='5'>Dates</th>
<th bgcolor='#336699'><font color=white size='5'>Activities</th>
</tr>";
echo'</font>';
while($row = mysql_fetch_array($result))
{
    print ("<tr>");
    print ("<td><font size='2'>" . $row['no'] . "</td>");
    print ("<td><font size='2'>" . $row['dates'] . "</td>");
    print ("<td><font size='2'>" . $row['activities'] . "</td>");
    print ("</tr>");
}
echo"<tr>
<th bgcolor='#408c70' colspan='3'><font color='white' size='5'>Semister Two</th></tr>";
while($row1 = mysql_fetch_array($result1))
{
    print ("<tr>");
    print ("<td><font size='2'>" . $row1['no'] . "</td>");
    print ("<td><font size='2'>" . $row1['dates'] . "</td>");
    print ("<td><font size='2'>" . $row1['activities'] . "</td>");
    print ("</tr>");
}
print( "</table>");

mysql_close($con);
?>
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
                <p><b><img src="<?php echo $photo_path; ?>" width="180" height="160" alt="Vice president profile photo"></b></p>
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
