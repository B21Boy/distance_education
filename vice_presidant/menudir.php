<?php
$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
?>
<nav id="menubar1" aria-label="Vice president navigation">
    <ul>
        <li><a href="index.php"<?php echo $current_page === 'index.php' ? ' class="active"' : ''; ?>>View Generated report</a></li>
        <li><a href="viewacadamicschedul.php"<?php echo $current_page === 'viewacadamicschedul.php' ? ' class="active"' : ''; ?>>View academic schedule</a></li>
        <li><a href="../logout.php">Log out</a></li>
    </ul>
</nav>
