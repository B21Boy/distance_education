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
<form action="1.php"method="POST" >
<table  cellpadding="5" border="0">
<tr><td colspan="2" ><center>Send feedback Form</center></td></tr>
<tr><td>User Type:</td><td><input type="text" name="ut" id="ut" readonly style="height: 30px;width: 200px;" value="student"/>
</td></tr>
<tr><td> Name:</td><td><input type="text" name="faname" id="faname" style="height: 30px;width: 200px;" required="required"  placeholder="name" />
<script type="text/javascript">
				    var f1 = new LiveValidation('faname');
				    f1.add(Validate.Presence,{failureMessage: " Please enter  name "});
				     f1.add(Validate.Format,{pattern: /^[a-zA-Z]+$/ ,failureMessage: " It allows only String"});
				 </script> 	
</td></tr>
<tr><td> Email:</td><td><input type="email" name="em" id="emial" style="height: 30px;width: 200px;" required="required"  placeholder="email" />
</td></tr>

<tr><td>Comment:</td><td><textarea  name="feedback" id="feedback"  ROWS="15" COLS="24"  placeholder="Text" wrap="warp" required="" style="height: 100px;width: 200px;text-align: left;"></textarea>
         
       <script type="text/javascript">
				    var f1 = new LiveValidation('feedback');
				    f1.add(Validate.Presence,{failureMessage: " Please enter feedback "});
				     f1.add(Validate.Format,{pattern: /^[0-9a-zA-Z&nbsp; ]+$/ ,failureMessage: " It allows only String"});
				      f1.add( Validate.Length, { minimum: 10, maximum: 10000 } );
				 </script>  	
         </td></tr>
<tr><td></td><td><input type="submit"  name="submit" value="Send" style="height: 40px;width: 120px;"id="m">
<input type="reset"  name="clear" value="Clear" style="height: 40px;width: 120px;"id="m"> </td>
</tr>
	</table>
	</form>
</div>
        </div>

        <!-- Right Sidebar -->
        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>


                <?php
                echo "<b><br><font color=blue>Welcome:</font><font color=#ee342f>(".$_SESSION['sfn']."&nbsp;&nbsp;&nbsp;".$_SESSION['sln'].")</font></b><b><br><img src='".$_SESSION['sphoto']."'width=180px height=160px></b>";
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