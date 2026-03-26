<?php
require_once(__DIR__ . "/page_helpers.php");
global $conn;

if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once(__DIR__ . "/../connection.php");
}

$departmentRole = 'Department Head';
$departmentName = departmentCurrentDepartmentName($conn);
$profileName = trim((string) ($_SESSION['sfn'] ?? '') . ' ' . (string) ($_SESSION['sln'] ?? ''));
$profileName = $profileName !== '' ? $profileName : 'Department User';
$profilePhoto = departmentCurrentPhotoPath();
?>
<div class="sidebar-panel profile-panel">
    <div class="sidebar-panel-title">User Profile</div>
    <div class="sidebar-panel-body">
        <div class="sidebar-profile-card">
            <img src="<?php echo departmentH($profilePhoto); ?>" alt="Department head profile photo" class="profile-thumb">
            <div class="sidebar-profile-content">
                <p class="sidebar-profile-kicker"><?php echo departmentH($departmentRole); ?></p>
                <p class="sidebar-profile-name">
                    <strong><?php echo departmentH($profileName); ?></strong>
                    <span><?php echo departmentCurrentUserId() !== '' ? departmentH(departmentCurrentUserId()) : 'Active account'; ?></span>
                </p>
                <p class="sidebar-profile-role">
                    <?php
                    echo $departmentName !== ''
                        ? departmentH($departmentName) . ' department dashboard access'
                        : 'Department dashboard access';
                    ?>
                </p>
            </div>
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
            <li><a href="https://www.facebook.com/" target="_blank" rel="noreferrer"><span class="sidebar-social-badge facebook">Fb</span>Facebook</a></li>
            <li><a href="https://www.twitter.com/" target="_blank" rel="noreferrer"><span class="sidebar-social-badge twitter">Tw</span>Twitter</a></li>
            <li><a href="https://www.youtube.com/" target="_blank" rel="noreferrer"><span class="sidebar-social-badge youtube">YT</span>YouTube</a></li>
            <li><a href="https://www.linkedin.com/" target="_blank" rel="noreferrer"><span class="sidebar-social-badge google">In</span>LinkedIn</a></li>
        </ul>
    </div>
</div>
