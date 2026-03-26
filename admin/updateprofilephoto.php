<?php
session_start();
include(__DIR__ . '/../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Administrator page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
.profile-photo-shell {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
}
.profile-photo-layout {
    display: grid;
    grid-template-columns: minmax(240px, 320px) minmax(0, 1fr);
    gap: 24px;
    align-items: start;
}
.profile-photo-preview {
    border: 1px solid #dce6f2;
    border-radius: 18px;
    background: #ffffff;
    padding: 20px;
    text-align: center;
}
.profile-photo-preview img {
    width: 100%;
    max-width: 240px;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 18px;
    border: 1px solid #d8e3ee;
    background: #eef4fa;
}
.profile-photo-preview p {
    margin: 14px 0 0;
    color: #4a6480;
    line-height: 1.6;
}
.profile-photo-form-panel {
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    padding: 22px;
}
.profile-photo-form-grid {
    display: grid;
    gap: 16px;
}
.profile-photo-label {
    display: grid;
    gap: 8px;
    color: #173a5e;
    font-weight: 700;
}
.profile-photo-file {
    border: 1px solid #bfd0e2;
    border-radius: 12px;
    padding: 12px;
    background: #f9fbfe;
}
.status-message {
    margin: 0 0 16px;
    padding: 14px 16px;
    border-radius: 12px;
    font-weight: 700;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.status-message.is-hidden {
    opacity: 0;
    visibility: hidden;
}
.status-success {
    background: #e8f7ea;
    border: 1px solid #7ecb87;
    color: #1b5e20;
}
.status-error {
    background: #fdeaea;
    border: 1px solid #e38b8b;
    color: #8a1f1f;
}
@media (max-width: 860px) {
    .profile-photo-layout {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    $photoValue = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
    $photoPath = $photoValue !== '' ? htmlspecialchars($photoValue, ENT_QUOTES, 'UTF-8') : '../images/default.png';
    $statusType = (string) ($_GET['type'] ?? '');
    $statusMessage = (string) ($_GET['message'] ?? '');
    $statusTimeout = 4000;
?>
<div id="container">
    <div id="header"><?php require('header.php'); ?></div>
    <div id="menu"><?php require('menu.php'); ?></div>
    <div class="main-row">
        <div id="left"><?php require('sidemenu.php'); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="profile-photo-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">Admin</span>
                            <h1 class="admin-page-title">Update Profile Photo</h1>
                            <p class="admin-page-copy">Upload a new profile image for your admin account. JPG, PNG, GIF, and WEBP images up to 2MB are supported.</p>
                        </div>
                    </div>
                    <?php if ($statusMessage !== '') { ?>
                    <div id="statusMessage" class="status-message <?php echo $statusType === 'success' ? 'status-success' : 'status-error'; ?>" data-timeout="<?php echo $statusTimeout; ?>" role="<?php echo $statusType === 'success' ? 'status' : 'alert'; ?>" aria-live="polite">
                        <?php echo htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <?php } ?>
                    <div class="profile-photo-layout">
                        <div class="profile-photo-preview">
                            <img src="<?php echo $photoPath; ?>" alt="Current profile photo">
                            <p>Your current profile photo appears here. Uploading a new image will replace the old one immediately.</p>
                        </div>
                        <div class="profile-photo-form-panel">
                            <form action="updatephoto.php" method="POST" enctype="multipart/form-data" class="profile-photo-form-grid">
                                <label class="profile-photo-label" for="photo">
                                    Choose New Photo
                                    <input class="profile-photo-file" type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/gif,image/webp" required>
                                </label>
                                <div class="admin-page-form-row">
                                    <button type="submit" id="submit" name="submit" class="admin-page-btn">Change Photo</button>
                                    <button type="reset" class="admin-page-btn-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require('rightsidebar.php'); ?></div>
    </div>
    <div id="footer"><?php include('../footer.php'); ?></div>
</div>
<?php
} else {
    header('location:../index.php');
    exit;
}
?>
<script>
(function () {
    var statusMessage = document.getElementById('statusMessage');
    if (!statusMessage) {
        return;
    }
    var timeout = parseInt(statusMessage.getAttribute('data-timeout'), 10);
    if (isNaN(timeout) || timeout < 0) {
        timeout = 4000;
    }
    window.setTimeout(function () {
        statusMessage.classList.add('is-hidden');
        window.setTimeout(function () {
            if (statusMessage.parentNode) {
                statusMessage.parentNode.removeChild(statusMessage);
            }
        }, 300);
        if (window.history && window.history.replaceState) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }, timeout);
})();
</script>
</body>
</html>
