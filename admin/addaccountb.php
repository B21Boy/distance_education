<?php
session_start();
include("../connection.php");
?>
<html>
<head>
<script src="theme.js"></script>
<title>
Administrator page
</title>
<link rel="stylesheet" type="text/css" href="../setting.css">

<script type="text/javascript" src="../javascript\date_time.js"></script>
<script src="js/validation.js" type="text/javascript"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<!--sa poip up-->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
   <script src="lib/jquery.js" type="text/javascript"></script>
  <script src="src/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'src/loading.gif',
        closeImage   : 'src/closelabel.png'
      })
    })
  </script>
</head>
<body class="light-theme">
<?php
if(isset($_SESSION['sun'])&& isset($_SESSION['spw'])&& isset($_SESSION['sfn'])&& isset($_SESSION['sln'])&& isset($_SESSION['srole']))
{
?>
<div id="container">
<div id="header">
<table>
<tr><td width="1000px" >
 <div id="headtitl"><center>Web Based Distance Education Management System <br>For<br>Bahir Dar University</center></div></td><td><img src="../images/bg.jpg"  style="width:160px;height:98px;"></td></tr>
</table>
<div class="menu-area">
<?php
    require("menu.php");
?>
</div>
</div>
<div class="main-row">
<div id="left">
<?php
    require("sidemenu.php");
?>
</div>
<div id="content">
<div id="contentindex5">
<div id="content" class="clearfix">
<?php
    require("createaccountb.php");
?>
</div>
</div>
</div>
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
<?php
include("../footer.php");
?>
</div>
<?php
}
else
header("location:../index.php");
?>
</body>
</html>