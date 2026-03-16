<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" href="../setting.css">
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
<script src="../javascript/date_time.js"></script>
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
        <?php require("menu.php"); ?>
    </div>

    <!-- Main row: left | center | right -->
    <div class="main-row">
        <!-- Left Sidebar -->
        <div id="left">
            <?php require("sidemenu.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <div id="contentindex5">
                <?php



                function restoreDatabaseTables($dbHost, $dbUsername, $dbPassword, $dbName, $filePath)
                {
                // Connect & select the database
                $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

                // Temporary variable, used to store current query
                $templine = '';

                // Read in entire file
                $lines = file($filePath);

                $error = '';

                // Loop through each line
                foreach ($lines as $line){
                    // Skip it if it's a comment
                    if(substr($line, 0, 2) == '--' || $line == ''){
                        continue;
                    }

                    // Add this line to the current segment
                    $templine .= $line;

                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';'){
                        // Perform the query
                        if(!$db->query($templine)){
                            $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
                        }

                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
                return !empty($error)?$error:true;

                }
                ?>






             <?php
             $domain="localhost";
            $dbuser="root";
            $dbpass="";
            $dbname="cde";
             $x=0;
            mysql_connect($domain,$dbuser,$dbpass) or die(mysql_error());
            if(mysql_select_db($dbname))
            $x=1;
            else
            $x=2;
            if($x==2)
            {

            mysql_query("create database cde") or die(mysql_error());
                    echo "<br>Your Database is Successfully created";
            }else if($x==1)

            {
            $output = "C:/wamp/www/cde[1]/admin/db/backup.sql";
            $filePath  = "C:/wamp/www/cde[1]/admin/db/backup.sql";
            $restore=restoreDatabaseTables($domain, $dbuser, $dbpass, $dbname, $filePath);
            if($restore)
             echo"<br>Database Is Successfully Is Restore";
             else
             echo"<br>Database Is not Successfully Is Restore";
            }


             ?>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div class="sidebar-panel profile-panel">
                <div class="sidebar-panel-title">User Profile</div>
                <div class="sidebar-panel-body">
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
            </div>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
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
<script nomodule src="https://unpkg.com/ionicons/7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>