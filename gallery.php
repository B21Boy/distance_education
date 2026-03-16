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
<title>Gallery</title>
<link rel="stylesheet" href="setting.css">
<link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="js/sagallery.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
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
            <!--body-->
            <div id="gallerycontainer">
                <ul class="portfolio-area" style="width: 860px;">
                <h3>Click for images to Zoom</h3>
                <table cellspacing="8" cellpadding="8"><tr ><td>

                        <li class="portfolio-item2" data-id="id-0" data-type="cat-item-4">
                  <span class="image-block">
                    <a class="image-zoom" href="images/thumbs/p1.jpg" rel="prettyPhoto[gallery]">
                    <img width="200" height="140" src="images/thumbs/p1.jpg" alt="selam" title="Click Here  To Zoom" />
                    </a>
                    </span>
                   <div class="home-portfolio-text">
                    <h4 class="post-title-portfolio"><a href="#" rel="bookmark">image1</a></h4>

                    </div>
                    </li>
                       </td>
                       <td>
                        <li class="portfolio-item2" data-id="id-1" data-type="cat-item-2">

                   <span class="image-block">
                    <a class="image-zoom" href="images/thumbs/p2.jpg" rel="prettyPhoto[gallery]">
                    <img width="200" height="140" src="images/thumbs/p2.jpg" alt="Up" title="Click Here  To Zoom" />
                    </a>
                    </span>
                   <div class="home-portfolio-text">
                    <h4 class="post-title-portfolio"><a href="#" rel="bookmark">image2</a></h4>

                    </div>


                    </li>
                    </td>
                 </tr>
                    <tr> <td>
                        <li class="portfolio-item2" data-id="id-2" data-type="cat-item-1">

                   <span class="image-block">
                    <a class="image-zoom" href="images/thumbs/p3.jpg" rel="prettyPhoto[gallery]">
                    <img width="200" height="140" src="images/thumbs/p3.jpg" alt="Cars 2" title="Click Here To Zoom" />
                    </a>
                    </span>
                   <div class="home-portfolio-text">
                    <h4 class="post-title-portfolio"><a href="#" rel="bookmark">image3</a></h4>
                    </div>
                    </li>
                       </td><td>
                    <li class="portfolio-item2" data-id="id-3" data-type="cat-item-4">

                   <span class="image-block">
                    <a class="image-zoom" href="images/thumbs/p4.jpg" rel="prettyPhoto[gallery]">
                    <img width="200" height="140" src="images/thumbs/p4.jpg" alt="Toy Story 3" title="Click Here  To Zoom" />
                    </a>
                    </span>
                   <div class="home-portfolio-text">
                    <h4 class="post-title-portfolio"><a href="#" rel="bookmark">image4</a></h4>
                    </div>
                    </li></td></tr>
                             </table>
                        <div class="column-clear"></div>
                    </ul>
                <div class="clearfix"></div>
            </div>

            <!--body-->
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
				