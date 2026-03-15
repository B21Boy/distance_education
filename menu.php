<!-- navigation menu styled inline to avoid caching issues -->
<style type="text/css">
    /* copy of styling from src/menu.php with background color and hover effects */
    #menu ul {
        width: 1094px;
        height: 48px;
        padding: 0;
        list-style: none;
        background: #336699;
        border-radius: 5px;
        margin-left: 21px;
        margin-top: 1px;
        white-space: nowrap;
    }
    #menu ul li {
        display: inline-block;
        position: relative;
        line-height: 21px;
        text-align: left;
    }
    #menu ul li a {
        display: block;
        margin-top: 1px;
        padding: 14px 30px;
        color: #fdfdfd;
        text-decoration: none;
        cursor: pointer;
    }
    #menu ul li a:hover {
        color: #020000;
        background: #eee;
        border-radius: 4px;
        /* don't change height on hover so layout stays stable */
    }
    /* dropdown styling */
    #menu ul li ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #28527a;
        padding: 8px 0;
        list-style: none;
        border-radius: 4px;
        min-width: 220px;
        max-width: 260px;
        max-height: 280px;
        overflow-y: auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        z-index: 1000;
        transition: opacity 0.2s ease, transform 0.2s ease;
        opacity: 0;
        transform: translateY(6px);
    }
    #menu ul li:hover > ul,
    #menu ul li ul.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
    #menu ul li ul li {
        display: block;
    }
    #menu ul li ul li a {
        padding: 10px 18px;
        white-space: nowrap;
        color: #fdfdfd;
    }
    #menu ul li ul li a:hover {
        background: #eee;
        color: #020000;
    }
</style>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About <ion-icon     name="chevron-down-outline"></ion-icon></a>  <ul>
             <li><a href="#.php">Mission </a></li>
                <li> <a href="#.php">Vision</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li> <a href="gallery.php">Photo Gallery</a></li>
         </ul>
        </li>
        <li><a href="#">Rules <ion-icon name="chevron-down-outline"></ion-icon></a> <ul>
               <li><a href="newstudents.php">New Applicants</a></li>
                <li><a href="seniorstudents.php">Senior Students</a></li>
        </ul></li>
        <li><a href="#">Academics <ion-icon name="chevron-down-outline"></ion-icon></a> <ul>
            

                <li><a href="colleges.php">Colleges</a></li>
                <li><a href="#">Instituts</a></li>
                <li> <a href="fields.php">Currently Ongoing Programs</a></li>

        </ul></li>
        <li><a href="new.php">Notice</a></li>
        <li><a href="appl_accept.php">Application</a></li>
        <li><a href="servicefees.php">Service fees</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="help.php">Help</a></li>
    </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#menu ul li a').forEach(function(a) {
        const icon = a.querySelector('ion-icon');
        if (icon) {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const ul = this.nextElementSibling;
                if (ul && ul.tagName === 'UL') {
                    const isVisible = ul.style.display === 'block';
                    ul.style.display = isVisible ? 'none' : 'block';
                    ul.classList.toggle('show', !isVisible);
                    icon.setAttribute('name', isVisible ? 'chevron-down-outline' : 'chevron-up-outline');
                }
            });
        }
    });
});
</script>
