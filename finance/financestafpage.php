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
Finance Staff page
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
.main-row > #sidebar {
    flex: 0 0 260px !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 18px !important;
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
    <div id="header">
        <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menufstaf.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenufstaf.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
                <center>Well Come To Finance Staff Page</center>
            </div>
        </div>

        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>
                <?php
                $sfn = isset($_SESSION['sfn']) ? htmlspecialchars($_SESSION['sfn'], ENT_QUOTES, 'UTF-8') : '';
                $sln = isset($_SESSION['sln']) ? htmlspecialchars($_SESSION['sln'], ENT_QUOTES, 'UTF-8') : '';
                $sphoto = isset($_SESSION['sphoto']) && !empty($_SESSION['sphoto']) ? htmlspecialchars($_SESSION['sphoto'], ENT_QUOTES, 'UTF-8') : '../userphoto/default.jpg';
                ?>
                <p><b><span style="color:blue">Welcome:</span> <span style="color:#f9160b">(<?php echo $sfn . "&nbsp;&nbsp;&nbsp;" . $sln; ?>)</span></b></p>
                <p><b><img src="<?php echo $sphoto; ?>" width="180" height="160" alt="Profile photo"></b></p>

                <div id="sidebarr">
                    <ul>
                        <li><a href="#.html">Change Photo</a></li>
                        <li><a href="#.html">Change password</a></li>
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
