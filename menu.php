<!-- navigation menu styled inline to avoid caching issues -->
<style type="text/css">
    /* inline nav styling to avoid cache issues */
    #menu > nav {
        position: relative;
    }
    #menu > nav > ul {
        width: calc(100% - 42px);
        min-height: 52px;
        padding: 6px 14px;
        list-style: none;
        background: linear-gradient(135deg, #1d5f95, #0f3f68);
        border-radius: 10px;
        margin-left: 21px;
        margin-top: 1px;
        box-sizing: border-box;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 16px;
        box-shadow: 0 14px 26px rgba(8, 32, 58, 0.22);
    }
    #menu > nav > ul > li {
        position: relative;
        flex: 0 0 auto;
        list-style: none;
    }
    #menu > nav > ul > li > a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 10px 14px;
        color: #f7fbff;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.15px;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    #menu > nav > ul > li > a ion-icon {
        font-size: 15px;
        transition: transform 0.2s ease;
    }
    #menu > nav > ul > li:hover > a,
    #menu > nav > ul > li:focus-within > a,
    #menu > nav > ul > li.is-open > a {
        color: #0f406a;
        background: #ffffff;
        box-shadow: 0 8px 18px rgba(7, 30, 56, 0.16);
        transform: translateY(-1px);
    }
    #menu > nav > ul > li:hover > a ion-icon,
    #menu > nav > ul > li:focus-within > a ion-icon,
    #menu > nav > ul > li.is-open > a ion-icon {
        transform: rotate(180deg);
    }
    #menu > nav > ul > li > ul {
        position: absolute;
        top: calc(100% + 12px);
        left: 0;
        min-width: 240px;
        max-width: 320px;
        margin: 0;
        padding: 12px;
        list-style: none;
        border-radius: 16px;
        border: 1px solid rgba(129, 176, 214, 0.45);
        background: linear-gradient(180deg, #1f5d8f 0%, #12395e 100%);
        box-shadow: 0 20px 40px rgba(8, 28, 49, 0.28);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(12px);
        transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
    }
    #menu > nav > ul > li > ul::before {
        content: "";
        position: absolute;
        top: -8px;
        left: 24px;
        width: 16px;
        height: 16px;
        background: #1d5787;
        border-top: 1px solid rgba(129, 176, 214, 0.45);
        border-left: 1px solid rgba(129, 176, 214, 0.45);
        transform: rotate(45deg);
    }
    #menu > nav > ul > li:hover > ul,
    #menu > nav > ul > li:focus-within > ul,
    #menu > nav > ul > li.is-open > ul {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0);
    }
    #menu > nav > ul > li > ul > li + li {
        margin-top: 6px;
    }
    #menu > nav > ul > li > ul > li {
        display: block;
    }
    #menu > nav > ul > li > ul > li > a {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        color: #f5fbff;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.06);
        white-space: normal;
        line-height: 1.35;
        transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
    }
    #menu > nav > ul > li > ul > li > a:hover,
    #menu > nav > ul > li > ul > li > a:focus {
        background: #ffffff;
        color: #0f406a;
        transform: translateX(4px);
    }
    @media (max-width: 900px) {
        #menu > nav > ul {
            justify-content: flex-start;
            gap: 10px;
        }
        #menu > nav > ul > li > ul {
            position: static;
            min-width: 100%;
            max-width: none;
            margin-top: 8px;
            transform: none;
        }
        #menu > nav > ul > li > ul::before {
            display: none;
        }
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
        <li><a href="online register/online.php">online Register <ion-icon name="chevron-down-outline"></ion-icon></a>
        <ul>
            

                <li><a href="online register/online.php">New Student</a></li>
                <li><a href="online register/seniar.php">Senior Student</a></li>
                

        </ul>
    
    </li>
        <li><a href="help.php">Help</a></li>
    </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownLinks = Array.from(document.querySelectorAll('#menu > nav > ul > li > a')).filter(function(link) {
        const next = link.nextElementSibling;
        return next && next.tagName === 'UL';
    });

    function closeAllDropdowns(exceptLink) {
        dropdownLinks.forEach(function(link) {
            if (link !== exceptLink) {
                link.parentElement.classList.remove('is-open');
                link.setAttribute('aria-expanded', 'false');
            }
        });
    }

    dropdownLinks.forEach(function(link) {
        link.setAttribute('aria-haspopup', 'true');
        link.setAttribute('aria-expanded', 'false');

        link.addEventListener('click', function(e) {
            e.preventDefault();
            const item = link.parentElement;
            const shouldOpen = !item.classList.contains('is-open');
            closeAllDropdowns(link);
            item.classList.toggle('is-open', shouldOpen);
            link.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#menu > nav')) {
            closeAllDropdowns(null);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns(null);
        }
    });
});
</script>
