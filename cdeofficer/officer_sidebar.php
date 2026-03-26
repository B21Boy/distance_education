<?php
$officer_first_name = htmlspecialchars(isset($_SESSION['sfn']) ? (string) $_SESSION['sfn'] : 'User', ENT_QUOTES, 'UTF-8');
$officer_last_name = htmlspecialchars(isset($_SESSION['sln']) ? (string) $_SESSION['sln'] : '', ENT_QUOTES, 'UTF-8');
$officer_photo_value = '';

if (isset($photo_path) && trim((string) $photo_path) !== '') {
    $officer_photo_value = trim((string) $photo_path);
} elseif (isset($_SESSION['sphoto']) && trim((string) $_SESSION['sphoto']) !== '') {
    $officer_photo_value = trim((string) $_SESSION['sphoto']);
}

$officer_photo_path = $officer_photo_value !== ''
    ? htmlspecialchars($officer_photo_value, ENT_QUOTES, 'UTF-8')
    : '../images/default.png';
?>
<div class="sidebar-panel profile-panel">
    <div class="sidebar-panel-title">User Profile</div>
    <div class="sidebar-panel-body">
        <div class="sidebar-profile-card">
            <p class="sidebar-profile-kicker">CDE Officer</p>
            <p class="sidebar-profile-name">
                <strong>Welcome:</strong>
                <span>(<?php echo $officer_first_name; ?>&nbsp;&nbsp;&nbsp;<?php echo $officer_last_name; ?>)</span>
            </p>
            <p class="sidebar-profile-role">Your account shortcuts are available below.</p>
            <img src="<?php echo $officer_photo_path; ?>" alt="CDE officer profile photo" class="profile-thumb">
        </div>
        <ul class="sidebar-action-list">
            <li><a href="updateprofilephoto.php">Change Photo</a></li>
            <li><a href="changepass.php">Change Password</a></li>
        </ul>
    </div>
</div>
<div class="sidebar-panel social-panel">
    <div class="sidebar-panel-title">Social Link</div>
    <div class="sidebar-panel-body">
        <ul class="sidebar-social-links">
            <li><a href="https://www.facebook.com/"><span class="sidebar-social-badge facebook">Fb</span>Facebook</a></li>
            <li><a href="https://www.twitter.com/"><span class="sidebar-social-badge twitter">Tw</span>Twitter</a></li>
            <li><a href="https://www.youtube.com/"><span class="sidebar-social-badge youtube">YT</span>YouTube</a></li>
            <li><a href="https://plus.google.com/"><span class="sidebar-social-badge google">G+</span>Google+</a></li>
        </ul>
    </div>
</div>
