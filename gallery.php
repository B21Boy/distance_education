
<?php
session_start();
include("connection.php");
?>
<html>
<head>
<title>
Home page
</title>	
<link rel="stylesheet" type="text/css" href="setting.css">

<script type="text/javascript" src="javascript\date_time.js"></script>

<script type="text/javascript" src="js/sagallery.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script> 
<link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div id="container">

<table><tr><td>
<?php
    require("header.php");
?>
</td></tr><tr><td colspan="2">
<?php
    require("menu.php");
?>
</td></tr>
<tr><td>

<?php
		include("left.php");
	?>				

</td><td>
	<div id="contentindex5">				
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
				
	</div></td>
	 <td>
	 <div id="siderightindexphoto11">
	 <div id="siderightindexphoto112">
	 User Login
	 </div>
	 
	 <?php 
	require("leftlogin.php");
     ?>
	 
	 
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
	  </td>
	 </tr>
	 <tr><td>
<?php
include("footer.php");
?>
</td></tr>

</div>
</table>
</body>
</html>			
				