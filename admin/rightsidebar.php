<?php
$sidebarFirstName = isset($_SESSION['sfn']) ? htmlspecialchars((string) $_SESSION['sfn'], ENT_QUOTES, 'UTF-8') : '';
$sidebarLastName = isset($_SESSION['sln']) ? htmlspecialchars((string) $_SESSION['sln'], ENT_QUOTES, 'UTF-8') : '';
$sidebarPhotoValue = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
$sidebarPhotoPath = $sidebarPhotoValue !== '' ? htmlspecialchars($sidebarPhotoValue, ENT_QUOTES, 'UTF-8') : '../images/default.png';
?>
<div class="sidebar-panel profile-panel">
    <div class="sidebar-panel-title">User Profile</div>
    <div class="sidebar-panel-body">
        <div class="sidebar-profile-name"><strong>Welcome:</strong> <span style="color:#c1110d;">(<?php echo $sidebarFirstName; ?>&nbsp;&nbsp;&nbsp;<?php echo $sidebarLastName; ?>)</span></div>
        <img src="<?php echo $sidebarPhotoPath; ?>" alt="Administrator profile photo" class="profile-thumb">
        <ul class="sidebar-action-list">
            <li><a href="updateprofilephoto.php">Change Photo</a></li>
            <li><a href="changepass.php">Change Password</a></li>
        </ul>
    </div>
</div>
<div class="sidebar-panel social-panel">
    <div class="sidebar-panel-title">Social link</div>
    <div class="sidebar-panel-body">
        <ul class="sidebar-social-links">
            <li><a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">Facebook</a></li>
            <li><a href="https://www.twitter.com/" target="_blank" rel="noopener noreferrer">Twitter</a></li>
            <li><a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer">YouTube</a></li>
            <li><a href="https://plus.google.com/" target="_blank" rel="noopener noreferrer">Google++</a></li>
        </ul>
    </div>
</div>
