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
        padding: 14px 45px;
        color: #fdfdfd;
        text-decoration: none;
    }
    #menu ul li a:hover {
        color: #020000;
        background: #eee;
        border-radius: 4px;
        height: 17px;
    }
    #menu ul li ul.dropdown { /* dropdown styles kept if needed */
        width: 280px;
        background: #336699;
        display: none;
        position: absolute;
    }
    #menu ul li:hover ul.dropdown { /* show dropdown */
        display: block;
        z-index: 1;
        border: 1px solid white;
    }
    #menu ul li ul.dropdown li {
        display: block;
        background: #3e413a;
        border: 1px solid white;
        z-index: 999;
    }
</style>

<nav class="student-menu">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Rules</a></li>
        <li><a href="#">Academics</a></li>
        <li><a href="new.php">Notice</a></li>
        <li><a href="appl_accept.php">Application</a></li>
        <li><a href="servicefees.php">Service fees</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="help.php">Help</a></li>
    </ul>
</nav>
