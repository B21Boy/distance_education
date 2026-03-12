<?php
include("connection.php");
?>
<div class="sidebar-panel">
    <div class="sidebar-panel-title">Announcement</div>
    <div class="sidebar-panel-body">
        <?php
        $sql = $conn->query("SELECT * FROM postss WHERE status='register' ORDER BY dates DESC LIMIT 1");
        if ($row = $sql->fetch_assoc()) {
            echo "<div class=\"announcement-title\"><u>{$row['Title']}</u></div>";
            echo "<div class=\"announcement-subtitle\">{$row['types']}</div>";
            echo "<div class=\"announcement-body\">{$row['info']}</div>";
        } else {
            echo "<div class=\"announcement-body\">No announcements yet.</div>";
        }
        ?>
        <div class="announcement-link">
            <a href="new.php">Read More</a>
        </div>
    </div>
</div>

<div class="sidebar-panel">
    <div class="sidebar-panel-title">Calendar</div>
    <div class="sidebar-panel-body">
        <?php require("date.php"); ?>
    </div>
</div>
