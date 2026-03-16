<?php
session_start();
ob_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>Feedback</title>
<link rel="stylesheet" href="setting.css">
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
<script src="javascript/date_time.js"></script>
</head>
<body class="student-portal-page">

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
            <?php include("left.php"); ?>
        </div>

        <!-- Main Content (center) -->
        <div id="content">
            <form action="1.php" method="POST">
            <table cellpadding="5" border="0">
            <tr><td colspan="2"><center>Send feedback Form</center></td></tr>

            <tr><td> Name:</td><td><input type="text" name="faname" id="faname" style="height: 30px;width: 200px;" required="required" placeholder="name" />
            <script type="text/javascript">
                            var f1 = new LiveValidation('faname');
                            f1.add(Validate.Presence,{failureMessage: " Please enter  name "});
                             f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
                         </script>
            </td></tr>
            <tr><td> Email:</td><td><input type="email" name="em" id="emial" style="height: 30px;width: 200px;" required="required" placeholder="email" />
            </td></tr>

            <tr><td>Comment:</td><td><textarea name="feedback" id="feedback" ROWS="15" COLS="24" placeholder="Text" wrap="warp" required="" style="height: 100px;width: 200px;text-align: left;"></textarea>

                   <script type="text/javascript">
                            var f1 = new LiveValidation('feedback');
                            f1.add(Validate.Presence,{failureMessage: " Please enter feedback "});
                             f1.add(Validate.Format,{pattern: /^[0-9a-zA-Z&nbsp; ]+$/ ,failureMessage: " It allows only String"});
                              f1.add( Validate.Length, { minimum: 10, maximum: 10000 } );
                         </script>
                     </td></tr>
            <tr><td></td><td><input type="submit" name="submit" value="Send" style="height: 40px;width: 120px;" id="m">
            <input type="reset" name="clear" value="Clear" style="height: 40px;width: 120px;" id="m"> </td>

            </tr>
                </table>
                </form>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <?php require("leftlogin.php"); ?>
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
        <?php include("footer.php"); ?>
    </div>

</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>