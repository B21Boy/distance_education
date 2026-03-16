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
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>