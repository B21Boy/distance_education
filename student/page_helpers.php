<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once(__DIR__ . "/../connection.php");
}

function studentIsLoggedIn()
{
    return isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole']);
}

function studentH($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function studentCurrentUserId()
{
    return isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
}

function studentCurrentFullName()
{
    $firstName = isset($_SESSION['sfn']) ? trim((string) $_SESSION['sfn']) : '';
    $lastName = isset($_SESSION['sln']) ? trim((string) $_SESSION['sln']) : '';
    return trim($firstName . ' ' . $lastName);
}

function studentCurrentPhotoPath()
{
    $photo = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
    return $photo !== '' ? $photo : 'userphoto/img1.jpg';
}

function studentSessionValue($key, $default = '')
{
    return isset($_SESSION[$key]) ? trim((string) $_SESSION[$key]) : $default;
}

function studentFormatDate($value, $format = 'M j, Y')
{
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }

    $timestamp = strtotime($value);
    if ($timestamp === false) {
        return $value;
    }

    return date($format, $timestamp);
}

function studentGradePointValue($grade)
{
    $grade = strtoupper(trim((string) $grade));
    $map = array(
        'A+' => 4.00,
        'A' => 4.00,
        'A-' => 3.75,
        'B+' => 3.50,
        'B' => 3.00,
        'B-' => 2.75,
        'C+' => 2.50,
        'C' => 2.00,
        'C-' => 1.75,
        'D' => 1.00,
        'F' => 0.00
    );

    return isset($map[$grade]) ? $map[$grade] : 0.00;
}

function studentSyncSessionData()
{
    global $conn;

    if (!isset($conn) || !($conn instanceof mysqli)) {
        return;
    }

    $userId = studentCurrentUserId();
    if ($userId === '') {
        return;
    }

    if (studentSessionValue('sdpt') === '' || studentSessionValue('syear') === '' || studentSessionValue('ssemister') === '' || studentSessionValue('ssection') === '') {
        $studentStmt = mysqli_prepare($conn, "SELECT Department, year, semister, section FROM student WHERE S_ID = ? LIMIT 1");
        if ($studentStmt) {
            mysqli_stmt_bind_param($studentStmt, 's', $userId);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            $studentRow = $studentResult instanceof mysqli_result ? mysqli_fetch_assoc($studentResult) : null;
            if ($studentResult instanceof mysqli_result) {
                mysqli_free_result($studentResult);
            }
            mysqli_stmt_close($studentStmt);

            if ($studentRow) {
                $_SESSION['sdpt'] = trim((string) ($studentRow['Department'] ?? ''));
                $_SESSION['syear'] = trim((string) ($studentRow['year'] ?? ''));
                $_SESSION['ssemister'] = trim((string) ($studentRow['semister'] ?? ''));
                $_SESSION['ssection'] = trim((string) ($studentRow['section'] ?? ''));
            }
        }
    }

    if (studentSessionValue('sdcode') === '') {
        $userStmt = mysqli_prepare($conn, "SELECT d_code FROM user WHERE UID = ? LIMIT 1");
        if ($userStmt) {
            mysqli_stmt_bind_param($userStmt, 's', $userId);
            mysqli_stmt_execute($userStmt);
            $userResult = mysqli_stmt_get_result($userStmt);
            $userRow = $userResult instanceof mysqli_result ? mysqli_fetch_assoc($userResult) : null;
            if ($userResult instanceof mysqli_result) {
                mysqli_free_result($userResult);
            }
            mysqli_stmt_close($userStmt);

            if ($userRow) {
                $_SESSION['sdcode'] = trim((string) ($userRow['d_code'] ?? ''));
                $_SESSION['sdc'] = trim((string) ($userRow['d_code'] ?? ''));
            }
        }
    }
}

function studentRequireLogin()
{
    if (!studentIsLoggedIn()) {
        header("location:../index.php");
        exit;
    }

    studentSyncSessionData();
}

function studentRenderPageHeader($kicker, $heading, $copy = '', $actionsHtml = '')
{
    ?>
    <div class="student-page-header">
        <div>
            <span class="student-page-kicker"><?php echo studentH($kicker); ?></span>
            <h1 class="student-page-title"><?php echo studentH($heading); ?></h1>
            <?php if ($copy !== '') { ?>
                <p class="student-page-copy"><?php echo studentH($copy); ?></p>
            <?php } ?>
        </div>
        <?php if ($actionsHtml !== '') { ?>
            <div class="student-page-actions">
                <?php echo $actionsHtml; ?>
            </div>
        <?php } ?>
    </div>
    <?php
}

function studentRenderSidebar()
{
    $fullName = studentCurrentFullName();
    $profilePhoto = studentCurrentPhotoPath();
    ?>
    <section class="sidebar-panel">
        <div class="sidebar-panel-title">User Profile</div>
        <div class="sidebar-panel-body">
            <div class="student-sidebar-profile">
                <span class="sidebar-profile-kicker">Student</span>
                <img src="<?php echo studentH($profilePhoto); ?>" alt="Student profile photo" class="profile-thumb">
                <p class="sidebar-profile-name"><strong><?php echo studentH($fullName !== '' ? $fullName : 'Student User'); ?></strong></p>
                <p class="sidebar-profile-role">Student account</p>
            </div>
            <ul class="sidebar-action-list">
                <li><a href="updateprofilephoto.php">Change Photo</a></li>
                <li><a href="changepass.php">Change Password</a></li>
            </ul>
        </div>
    </section>

    <section class="sidebar-panel social-panel">
        <div class="sidebar-panel-title">Social Links</div>
        <div class="sidebar-panel-body">
            <ul class="sidebar-social-links">
                <li><a href="https://www.facebook.com/"><span class="sidebar-social-badge facebook">F</span>Facebook</a></li>
                <li><a href="https://www.twitter.com/"><span class="sidebar-social-badge twitter">T</span>Twitter</a></li>
                <li><a href="https://www.youtube.com/"><span class="sidebar-social-badge youtube">Y</span>YouTube</a></li>
                <li><a href="https://plus.google.com/"><span class="sidebar-social-badge google">G</span>Google+</a></li>
            </ul>
        </div>
    </section>
    <?php
}

function studentRenderPageStart($documentTitle, $kicker, $heading, $copy = '', $options = array())
{
    $bodyClass = isset($options['body_class']) && trim((string) $options['body_class']) !== ''
        ? trim((string) $options['body_class'])
        : 'student-portal-page light-theme';
    $includeTableCss = !empty($options['include_table_css']);
    $actionsHtml = isset($options['actions_html']) ? (string) $options['actions_html'] : '';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title><?php echo studentH($documentTitle); ?></title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<?php if ($includeTableCss) { ?>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<?php } ?>
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
body.student-portal-page #container {
    max-width: 1600px !important;
    width: calc(100% - 28px) !important;
    margin: 12px auto 24px !important;
}
body.student-portal-page #header,
body.student-portal-page #menu,
body.student-portal-page #footer {
    width: 100% !important;
}
body.student-portal-page .main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 28px !important;
    align-items: flex-start !important;
}
body.student-portal-page .main-row > #left {
    flex: 0 0 290px !important;
    max-width: 290px !important;
}
body.student-portal-page .main-row > #content {
    flex: 1 1 auto !important;
    min-width: 0 !important;
}
body.student-portal-page .main-row > #sidebar {
    flex: 0 0 300px !important;
    max-width: 300px !important;
}
body.student-portal-page #contentindex5 {
    width: 100% !important;
}
@media (max-width: 1180px) {
    body.student-portal-page .main-row {
        flex-wrap: wrap !important;
    }
    body.student-portal-page .main-row > #left {
        flex: 0 0 260px !important;
        max-width: 260px !important;
    }
    body.student-portal-page .main-row > #sidebar {
        flex: 1 1 100% !important;
        max-width: 100% !important;
    }
}
@media (max-width: 860px) {
    body.student-portal-page .main-row {
        flex-direction: column !important;
    }
    body.student-portal-page .main-row > #left,
    body.student-portal-page .main-row > #content,
    body.student-portal-page .main-row > #sidebar {
        flex: 1 1 100% !important;
        max-width: 100% !important;
        width: 100% !important;
    }
}
</style>
</head>
<body class="<?php echo studentH($bodyClass); ?>">
<div id="container">
    <div id="header"><?php require(__DIR__ . "/header.php"); ?></div>
    <div id="menu"><?php require(__DIR__ . "/menustud.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require(__DIR__ . "/sidemenustud.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="student-page-shell">
                    <?php studentRenderPageHeader($kicker, $heading, $copy, $actionsHtml); ?>
    <?php
}

function studentRenderPageEnd()
{
    ?>
                </div>
            </div>
        </div>
        <div id="sidebar">
            <?php studentRenderSidebar(); ?>
        </div>
    </div>
    <div id="footer"><?php include(__DIR__ . "/../footer.php"); ?></div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
    <?php
}
?>
