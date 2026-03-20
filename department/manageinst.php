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
        </div>

        <div id="content">
            <div id="contentindex5">
                <div class="clearfix">
<?php
$dept=$_SESSION['sdc'];
$result1 = mysql_query("SELECT * FROM department where Dcode='$dept'");
$row = mysql_fetch_array($result1);
$dcode=$row['DName'];
echo '<a href="viewassigndinst.php?id='.$dept.'" style="margin-left: 400px">View Assigned Instructor</a>';
?>

                    <table cellpadding="1" cellspacing="1" id="resultTable">
                        <thead>
                            <tr>
                                <th style="border-left: 1px solid #C1DAD7">course<br>code </th>
                                <th style="border-left: 1px solid #C1DAD7">course<br>name</th>
                                <th style="border-left: 1px solid #C1DAD7">chour</th>
                                <th>ayear</th>
                                <th>department</th>
                                <th>Assign Instructor</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include('../connection.php');
                            $result = mysql_query("SELECT * FROM course where department='$dcode'");
                            while($row = mysql_fetch_array($result))
                            {
                                echo '<tr class="record">';
                                echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['course_code'].'</td>';
                                echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['cname'].'</td>';
                                echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['chour'].'</td>';
                                echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['ayear'].'</td>';
                                echo '<td style="border-left: 1px solid #C1DAD7;">'.$row['department'].'</td>';
                                echo '<td><div align="center"><a rel="facebox" href="assign_course_instructorS.php?id='.$row['course_code'].'">Assign</a></div></td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
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
