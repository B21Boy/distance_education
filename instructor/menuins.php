<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('INSTRUCTOR_FACEBOX_ASSETS_LOADED')) {
    define('INSTRUCTOR_FACEBOX_ASSETS_LOADED', true);
    ?>
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
                loadingImage: 'src/loading.gif',
                closeImage: 'src/closelabel.png'
            });
        });
    </script>
    <?php
}

if (!defined('INSTRUCTOR_MENU_DROPDOWN_STYLES')) {
    define('INSTRUCTOR_MENU_DROPDOWN_STYLES', true);
    ?>
    <style>
    body.student-portal-page #menubar1 .menu-dropdown {
        position: relative;
        z-index: 110;
    }
    body.student-portal-page #menubar1 .menu-dropdown:hover,
    body.student-portal-page #menubar1 .menu-dropdown:focus-within,
    body.student-portal-page #menubar1 .menu-dropdown.is-active {
        z-index: 120;
    }
    body.student-portal-page #menubar1 .menu-dropdown-toggle {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding-right: 18px !important;
        cursor: default;
    }
    body.student-portal-page #menubar1 .menu-dropdown:hover > .menu-dropdown-toggle,
    body.student-portal-page #menubar1 .menu-dropdown:focus-within > .menu-dropdown-toggle,
    body.student-portal-page #menubar1 .menu-dropdown.is-active > .menu-dropdown-toggle {
        background: #ffffff !important;
        color: #0f4f79 !important;
        box-shadow: 0 12px 22px rgba(13, 77, 122, 0.18);
    }
    body.student-portal-page #menubar1 .menu-dropdown-toggle::after {
        content: "";
        position: static;
        width: 8px;
        height: 8px;
        margin-top: -2px;
        border-right: 2px solid currentColor;
        border-bottom: 2px solid currentColor;
        transform: rotate(45deg);
        transition: transform 0.18s ease;
    }
    body.student-portal-page #menubar1 .menu-dropdown:hover .menu-dropdown-toggle::after,
    body.student-portal-page #menubar1 .menu-dropdown:focus-within .menu-dropdown-toggle::after,
    body.student-portal-page #menubar1 .menu-dropdown.is-active .menu-dropdown-toggle::after {
        transform: rotate(225deg);
    }
    body.student-portal-page #menubar1 .menu-dropdown-panel {
        position: absolute;
        top: calc(100% + 8px);
        left: 50%;
        min-width: 290px;
        padding: 12px;
        display: grid;
        gap: 8px;
        background: linear-gradient(180deg, #ffffff 0%, #f5f9fd 100%);
        border: 1px solid #cfe0ef;
        border-radius: 18px;
        box-shadow: 0 22px 38px rgba(16, 46, 74, 0.18);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateX(-50%) translateY(8px);
        transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
        z-index: 140;
    }
    body.student-portal-page #menubar1 .menu-dropdown-panel::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: -14px;
        height: 14px;
    }
    body.student-portal-page #menubar1 .menu-dropdown:hover .menu-dropdown-panel,
    body.student-portal-page #menubar1 .menu-dropdown:focus-within .menu-dropdown-panel,
    body.student-portal-page #menubar1 .menu-dropdown.is-active .menu-dropdown-panel {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateX(-50%) translateY(0);
    }
    body.student-portal-page #menubar1 .menu-dropdown-panel a {
        display: flex !important;
        justify-content: flex-start !important;
        min-height: 0 !important;
        padding: 12px 14px !important;
        border-radius: 14px !important;
        background: #eaf3fb !important;
        color: #123f67 !important;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px !important;
        font-weight: 700;
        text-align: left;
        white-space: normal;
        border: 1px solid transparent;
        box-shadow: none !important;
    }
    body.student-portal-page #menubar1 .menu-dropdown-panel a:hover,
    body.student-portal-page #menubar1 .menu-dropdown-panel a:focus,
    body.student-portal-page #menubar1 .menu-dropdown-panel a.active {
        background: linear-gradient(135deg, #0d4d7a, #1d7fa4) !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.24);
        transform: none !important;
    }
    @media (max-width: 720px) {
        body.student-portal-page #menubar1 .menu-dropdown-panel {
            position: static;
            left: auto;
            min-width: 0;
            margin-top: 10px;
            transform: none;
            width: 100%;
            box-shadow: inset 0 0 0 1px #d9e4ef;
        }
        body.student-portal-page #menubar1 .menu-dropdown-panel::before {
            display: none;
        }
        body.student-portal-page #menubar1 .menu-dropdown:hover .menu-dropdown-panel,
        body.student-portal-page #menubar1 .menu-dropdown:focus-within .menu-dropdown-panel,
        body.student-portal-page #menubar1 .menu-dropdown.is-active .menu-dropdown-panel {
            transform: none;
        }
    }
    </style>
    <?php
}

if (!isset($conn)) {
    require_once("../connection.php");
}

$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$count = 0;

if ($user_id !== '') {
    $sql = "SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
    $result = mysqli_query($conn, $sql);
    if ($result instanceof mysqli_result) {
        $count = mysqli_num_rows($result);
        mysqli_free_result($result);
    }
}

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$view_items = array(
    array('href' => 'viewassgin.php', 'label' => 'View Uploaded Assignment'),
    array('href' => 'preparemoduleschedule.php', 'label' => 'View Module Preparation Schedule'),
    array('href' => 'viewcourse.php', 'label' => 'View Course Result')
);
$menu_items = array(
    array('href' => 'uploadmoduleto.php', 'label' => 'Upload Prepared Module'),
    array('href' => 'assignmentdownload.php', 'label' => 'Download Submitted Assignment'),
    array('type' => 'dropdown', 'href' => '#', 'label' => 'View', 'items' => $view_items),
    array(
        'href' => 'usernotification.php',
        'label' => 'Notification[' . $count . ']',
        'class' => $count >= 1 ? 'has-alert' : ''
    ),
    array('href' => '../logout.php', 'label' => 'Log out')
);
?>
<nav id="menubar1" aria-label="Instructor navigation">
    <ul>
        <?php foreach ($menu_items as $item) {
            $item_type = isset($item['type']) ? $item['type'] : 'link';
            $item_class = isset($item['class']) ? trim($item['class']) : '';

            if ($item_type === 'dropdown') {
                $dropdown_active = false;
                foreach ($item['items'] as $dropdown_item) {
                    if ($current_page === basename($dropdown_item['href'])) {
                        $dropdown_active = true;
                        break;
                    }
                }
                if ($dropdown_active) {
                    $item_class = trim($item_class . ' active');
                }
                ?>
                <li class="menu-dropdown<?php echo $dropdown_active ? ' is-active' : ''; ?>">
                    <a href="#" onclick="return false;" aria-haspopup="true" aria-expanded="<?php echo $dropdown_active ? 'true' : 'false'; ?>" class="menu-dropdown-toggle<?php echo $item_class !== '' ? ' ' . htmlspecialchars($item_class, ENT_QUOTES, 'UTF-8') : ''; ?>">
                        <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <div class="menu-dropdown-panel">
                        <?php foreach ($item['items'] as $dropdown_item) {
                            $dropdown_class = $current_page === basename($dropdown_item['href']) ? 'active' : '';
                            ?>
                            <a href="<?php echo htmlspecialchars($dropdown_item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $dropdown_class !== '' ? ' class="' . $dropdown_class . '"' : ''; ?>>
                                <?php echo htmlspecialchars($dropdown_item['label'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        <?php } ?>
                    </div>
                </li>
                <?php
                continue;
            }

            if ($current_page === basename($item['href'])) {
                $item_class = trim($item_class . ' active');
            }
            ?>
            <li>
                <a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $item_class !== '' ? ' class="' . htmlspecialchars($item_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
                    <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>
