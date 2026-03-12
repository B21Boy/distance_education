
<style type="text/css">
   #menu ul{
       width: 1094px;
	   height: 48px;
        padding: 0;
        list-style: none;
        background: #336699;
        border-radius:5px;
        margin-left:21px;
		margin-top:1px;
    }
   #menu ul li{
        display: inline-block;
        position: relative;
        line-height: 21px;
        text-align: left;
    }
  #menu  ul li a{
        display: block;
        margin-top:1px;
        padding: 14px 45px;
        color: #fdfdfd;
        text-decoration: none;
    }
  #menu  ul li a:hover{
	color:#020000;
	background:#eee;
	border-radius:4px;
	height: 17px;
    }
   #menu ul li ul.dropdown{/* Set width of the dropdown */
    	
        width: 280px; 
        background: #336699;
        display: none;
        position: absolute;
       
        
    }
  #menu  ul li:hover ul.dropdown{ /* Display the dropdown */
        display: block;
        z-index: 1;
        border:1 px solid white;
  
    }
  #menu  ul li ul.dropdown li{
        display: block;
        background: #3e413a;
         border:1 px solid white;
         z-index: 999;
    }
</style>
<div id="menu">
    <ul>
        <li><a href="index.php">Home</a></li>
            <li>
            <a href="#">About &#9662;</a>
            <ul class="dropdown">
                <li><a href="#.php">Mission</a></li>
                <li> <a href="#.php">Vision</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li> <a href="gallery.php">Photo Gallery</a></li>
            </ul>
        </li>
        
        <li>
            <a href="#">Rules &#9662;</a>
            <ul class="dropdown">
                <li><a href="newstudents.php">New Applicants</a></li>
                <li><a href="seniorstudents.php">Senior Students</a></li>
           
            </ul>
        </li>
        
                <li>
            <a href="#">Academics &#9662;</a>
            <ul class="dropdown">
                <li><a href="colleges.php">Colleges</a></li>
                <li><a href="#">Instituts</a></li>
                <li> <a href="fields.php">Currently Ongoing Programs</a></li>
            </ul>
        </li>
        
        <li><a href="new.php">Notice</a></li>
            <li><a href="feedback.php">Feedback</a></li>
                <li><a href="help.php">Help</a></li>
    </ul>
    </div>

