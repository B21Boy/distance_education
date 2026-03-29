<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once(__DIR__ . "/../connection.php");
}

function departmentIsLoggedIn(): bool
{
    return isset($_SESSION['sun'], $_SESSION['spw'], $_SESSION['sfn'], $_SESSION['sln'], $_SESSION['srole']);
}

function departmentSyncDepartmentSession(): void
{
    if (!empty($_SESSION['sdc']) || empty($_SESSION['suid'])) {
        return;
    }

    global $conn;
    if (!isset($conn) || !($conn instanceof mysqli)) {
        require_once(__DIR__ . "/../connection.php");
    }

    if (!isset($conn) || !($conn instanceof mysqli)) {
        return;
    }

    $userId = trim((string) $_SESSION['suid']);
    if ($userId === '') {
        return;
    }

    $stmt = mysqli_prepare($conn, "SELECT d_code, c_code FROM user WHERE UID = ? LIMIT 1");
    if (!$stmt) {
        return;
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $departmentCode, $collegeCode);
    if (mysqli_stmt_fetch($stmt)) {
        $_SESSION['sdc'] = trim((string) ($departmentCode ?? ''));
        $_SESSION['sdcode'] = trim((string) ($departmentCode ?? ''));
        $_SESSION['sccode'] = trim((string) ($collegeCode ?? ''));
    }
    mysqli_stmt_close($stmt);
}

function departmentRequireLogin(): void
{
    if (!departmentIsLoggedIn()) {
        header("location:../index.php");
        exit;
    }

    departmentSyncDepartmentSession();
}

function departmentH($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function departmentCurrentUserId(): string
{
    return isset($_SESSION['suid']) ? trim((string) $_SESSION['suid']) : '';
}

function departmentCurrentDepartmentCode(): string
{
    return isset($_SESSION['sdc']) ? trim((string) $_SESSION['sdc']) : '';
}

function departmentCurrentDepartmentName(mysqli $conn): string
{
    $departmentCode = departmentCurrentDepartmentCode();
    if ($departmentCode === '') {
        return '';
    }

    $stmt = mysqli_prepare($conn, "SELECT DName FROM department WHERE Dcode = ? LIMIT 1");
    if (!$stmt) {
        return '';
    }

    mysqli_stmt_bind_param($stmt, 's', $departmentCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result instanceof mysqli_result ? mysqli_fetch_assoc($result) : null;
    if ($result instanceof mysqli_result) {
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);

    return isset($row['DName']) ? trim((string) $row['DName']) : '';
}

function departmentCurrentPhotoPath(): string
{
    $photo = isset($_SESSION['sphoto']) ? trim((string) $_SESSION['sphoto']) : '';
    return $photo !== '' ? $photo : 'userphoto/img1.jpg';
}

function departmentFetchUnreadMessages(mysqli $conn, string $userId): array
{
    if ($userId === '') {
        return [];
    }

    $sql = "SELECT m.M_ID, m.M_sender, m.message, m.date_sended,
                   COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.fname, u.lname)), ''), m.M_sender) AS sender_name
            FROM message m
            LEFT JOIN user u ON u.UID = m.M_sender
            WHERE m.M_reciever = ? AND m.status = 'no'
            ORDER BY m.date_sended DESC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function departmentFetchPaymentRows(mysqli $conn, string $userId, string $type): array
{
    if ($userId === '' || $type === '') {
        return [];
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM payment_table WHERE UID = ? AND type = ? ORDER BY no DESC");
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, 'ss', $userId, $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function departmentFetchCourses(mysqli $conn): array
{
    $departmentCode = departmentCurrentDepartmentCode();
    $departmentName = departmentCurrentDepartmentName($conn);
    $userId = departmentCurrentUserId();

    $conditions = [];
    $params = [];
    $types = '';

    if ($departmentName !== '') {
        $conditions[] = 'department = ?';
        $params[] = $departmentName;
        $types .= 's';
    }

    if ($departmentCode !== '' && $departmentCode !== $departmentName) {
        $conditions[] = 'department = ?';
        $params[] = $departmentCode;
        $types .= 's';
    }

    if ($userId !== '') {
        $conditions[] = 'Sender_name = ?';
        $params[] = $userId;
        $types .= 's';
    }

    if (!$conditions) {
        return [];
    }

    $sql = "SELECT DISTINCT course_code, cname, chour, ayear, department
            FROM course
            WHERE " . implode(' OR ', $conditions) . "
            ORDER BY course_code ASC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function departmentStatusBanner(string $status, array $messages): string
{
    if ($status === '' || !isset($messages[$status])) {
        return '';
    }

    $type = in_array($status, ['success'], true) ? 'success' : (in_array($status, ['info'], true) ? 'info' : 'error');
    return '<div class="department-status ' . $type . '">' . departmentH($messages[$status]) . '</div>';
}

function departmentRenderPageStart(
    string $documentTitle,
    string $kicker,
    string $heading,
    string $copy = '',
    string $actionsHtml = ''
): void {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title><?php echo departmentH($documentTitle); ?></title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<style>
body.student-portal-page #container {
    max-width: none !important;
    width: min(1720px, calc(100vw - 18px)) !important;
    margin: 10px auto 22px !important;
    padding: 0 0 18px !important;
}
body.student-portal-page #header,
body.student-portal-page #menu,
body.student-portal-page #footer {
    width: calc(100% - 20px) !important;
    margin-left: 10px !important;
    margin-right: 10px !important;
}
body.student-portal-page #header {
    height: auto !important;
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
}
body.student-portal-page #menu {
    margin-top: 12px !important;
}
body.student-portal-page #menubar1 {
    width: 100% !important;
    margin: 0 !important;
}
body.student-portal-page .main-row {
    display: grid !important;
    grid-template-columns: minmax(300px, 340px) minmax(0, 1fr) minmax(380px, 460px) !important;
    gap: 28px !important;
    align-items: start !important;
    margin: 18px 10px 0 !important;
    padding: 0 18px 8px 0 !important;
}
body.student-portal-page #left,
body.student-portal-page #content,
body.student-portal-page #sidebar {
    min-width: 0 !important;
}
body.student-portal-page #sidebar {
    width: 100% !important;
    padding-right: 10px !important;
}
body.student-portal-page #left {
    display: block !important;
}
body.student-portal-page .department-left-stack {
    display: grid;
    gap: 24px;
}
body.student-portal-page .department-side-menu-panel {
    border: 1px solid #dbe6f2 !important;
    border-radius: 24px !important;
    box-shadow: 0 22px 44px rgba(14, 49, 86, 0.12) !important;
    overflow: hidden;
    background: linear-gradient(180deg, #ffffff 0%, #f6fbff 100%) !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel {
    height: auto !important;
    overflow: visible !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel > .student-side-nav > li {
    display: grid;
    gap: 12px;
}
body.student-portal-page #sidebar1.department-side-menu-panel ul ul {
    position: static !important;
    left: auto !important;
    width: 100% !important;
    margin: 12px 0 0 !important;
    visibility: visible !important;
    opacity: 1 !important;
    transform: none !important;
    z-index: auto !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel li:hover > ul {
    position: static !important;
    left: auto !important;
    width: 100% !important;
    margin: 12px 0 0 !important;
    transform: none !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel li + li {
    margin-top: 6px !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel li:hover > a {
    background: #eaf4ff !important;
    color: #17364e !important;
}
body.student-portal-page #sidebar1.department-side-menu-panel li:hover > div {
    color: inherit !important;
}
body.student-portal-page #contentindex5 {
    width: 100% !important;
    margin: 0 !important;
    min-height: 620px !important;
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
}
body.student-portal-page .department-page-shell {
    padding: 30px 32px;
    background: linear-gradient(180deg, #f7fbff 0%, #eef4fb 100%);
    border: 1px solid #dbe6f2;
    border-radius: 24px;
    box-shadow: 0 24px 50px rgba(18, 53, 94, 0.10);
}
body.student-portal-page .sidebar-panel {
    margin-bottom: 22px;
    overflow: hidden;
    border: 1px solid #d9e4ef;
    border-radius: 20px;
    background: linear-gradient(180deg, #ffffff 0%, #f6f9fd 100%);
    box-shadow: 0 18px 32px rgba(16, 46, 74, 0.08);
}
body.student-portal-page .sidebar-panel:last-child {
    margin-bottom: 0;
}
body.student-portal-page .sidebar-panel-title {
    padding: 16px 20px;
    background: linear-gradient(135deg, #12395f 0%, #245f96 100%);
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
body.student-portal-page .sidebar-panel-body {
    padding: 22px;
    color: #35516d;
}
body.student-portal-page .sidebar-profile-card {
    display: grid;
    gap: 16px;
    text-align: center;
}
body.student-portal-page .sidebar-profile-kicker {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    padding: 6px 12px;
    border-radius: 999px;
    background: #deebfb;
    color: #1e5788;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
body.student-portal-page .sidebar-profile-name {
    margin: 0;
    line-height: 1.7;
    font-size: 16px;
    color: #163b60;
}
body.student-portal-page .sidebar-profile-name strong {
    color: #0f2f4e;
}
body.student-portal-page .sidebar-profile-name span {
    color: #b01d1d;
    font-weight: 700;
}
body.student-portal-page .sidebar-profile-role {
    margin: -8px 0 0;
    color: #668097;
    font-size: 14px;
}
body.student-portal-page .profile-thumb {
    display: block;
    width: 220px;
    height: 190px;
    margin: 0 auto;
    object-fit: cover;
    border-radius: 18px;
    border: 1px solid #d6e3ef;
    background: #edf3f9;
}
body.student-portal-page .sidebar-action-list,
body.student-portal-page .sidebar-social-links {
    display: grid;
    gap: 12px;
    margin: 0;
    padding: 0;
    list-style: none;
}
body.student-portal-page .sidebar-action-list a,
body.student-portal-page .sidebar-social-links a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 15px;
    border-radius: 14px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 700;
    color: #18466f;
    background: #edf4fb;
    transition: background-color 0.18s ease, transform 0.18s ease;
}
body.student-portal-page .sidebar-action-list a:hover,
body.student-portal-page .sidebar-social-links a:hover {
    background: #dbeafb;
    transform: translateY(-1px);
}
body.student-portal-page .sidebar-social-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    flex-shrink: 0;
}
body.student-portal-page .department-calendar-panel #sidedate {
    width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
}
body.student-portal-page .department-calendar-panel .calendar-widget {
    gap: 10px;
}
body.student-portal-page .department-calendar-panel .calendar-table {
    margin-top: 4px;
}
body.student-portal-page .sidebar-social-badge.facebook {
    background: #1877f2;
}
body.student-portal-page .sidebar-social-badge.twitter {
    background: #1da1f2;
}
body.student-portal-page .sidebar-social-badge.youtube {
    background: #ff0000;
}
body.student-portal-page .sidebar-social-badge.google {
    background: #0a66c2;
}
body.student-portal-page .department-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 18px;
    margin-bottom: 26px;
}
body.student-portal-page .department-page-kicker {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 999px;
    background: #d9ebff;
    color: #134a78;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
body.student-portal-page .department-page-title {
    margin: 12px 0 0;
    color: #133a61;
    font-size: 31px;
    line-height: 1.15;
}
body.student-portal-page .department-page-copy {
    margin: 12px 0 0;
    max-width: 820px;
    color: #4c647d;
    font-size: 15px;
    line-height: 1.7;
}
body.student-portal-page .department-page-actions,
body.student-portal-page .department-inline-actions,
body.student-portal-page .department-page-toolbar {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}
body.student-portal-page .department-page-toolbar {
    justify-content: space-between;
    margin-bottom: 18px;
}
body.student-portal-page .department-link-btn,
body.student-portal-page .department-btn,
body.student-portal-page .department-btn-secondary,
body.student-portal-page .page-nav-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 0 18px;
    border-radius: 12px;
    border: 1px solid #cfddec;
    background: #edf4fb;
    color: #18466f;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    box-sizing: border-box;
    transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
}
body.student-portal-page .department-btn,
body.student-portal-page .page-nav-link.is-primary {
    border: none;
    background: linear-gradient(135deg, #215fb8 0%, #2f86de 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(33, 95, 184, 0.20);
}
body.student-portal-page .department-btn-secondary,
body.student-portal-page .page-nav-link.is-secondary {
    background: #eef2f7;
    color: #294663;
}
body.student-portal-page .department-link-btn:hover,
body.student-portal-page .department-btn:hover,
body.student-portal-page .department-btn-secondary:hover,
body.student-portal-page .page-nav-link:hover {
    transform: translateY(-1px);
}
body.student-portal-page .department-stat-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
}
body.student-portal-page .department-stat-chip {
    display: inline-flex;
    align-items: center;
    min-height: 38px;
    padding: 0 14px;
    border-radius: 999px;
    background: #e8f1fb;
    color: #18456d;
    font-size: 13px;
    font-weight: 700;
}
body.student-portal-page .department-section,
body.student-portal-page fieldset {
    margin: 0;
    padding: 20px 22px;
    border: 1px solid #d8e3ef;
    border-radius: 18px;
    background: #ffffff;
}
body.student-portal-page fieldset legend {
    padding: 0 10px;
    color: #173a5e;
    font-size: 16px;
    font-weight: 800;
}
body.student-portal-page .department-table-wrap {
    width: 100%;
    overflow-x: auto;
}
body.student-portal-page #resultTable {
    width: 100% !important;
    min-width: 680px;
    margin: 0 !important;
}
body.student-portal-page .department-empty {
    padding: 18px 20px;
    border: 1px dashed #b8cce2;
    border-radius: 16px;
    background: #f8fbff;
    color: #4e6680;
    font-weight: 600;
}
body.student-portal-page .department-status {
    margin-bottom: 18px;
    padding: 14px 16px;
    border-radius: 14px;
    font-weight: 700;
    line-height: 1.6;
}
body.student-portal-page .department-status.success {
    background: #e8f7ea;
    border: 1px solid #7fc58b;
    color: #1b5e20;
}
body.student-portal-page .department-status.error {
    background: #fdeaea;
    border: 1px solid #e39b9b;
    color: #8a1f1f;
}
body.student-portal-page .department-status.info {
    background: #eef6ff;
    border: 1px solid #a9c8ee;
    color: #1e4d87;
}
body.student-portal-page .department-form-grid {
    display: grid;
    gap: 16px;
}
body.student-portal-page .department-form-grid.two-col {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
body.student-portal-page .department-form-field {
    display: grid;
    gap: 8px;
}
body.student-portal-page .department-form-field.full {
    grid-column: 1 / -1;
}
body.student-portal-page .department-label {
    color: #173a5e;
    font-size: 15px;
    font-weight: 700;
}
body.student-portal-page .department-form-note {
    margin: 0;
    color: #58708a;
    line-height: 1.6;
}
body.student-portal-page .department-message-list {
    display: grid;
    gap: 16px;
}
body.student-portal-page .department-message-card {
    padding: 18px 20px;
    border: 1px solid #d9e4f0;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 10px 26px rgba(24, 60, 99, 0.08);
}
body.student-portal-page .department-message-meta {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 12px;
    color: #5b738d;
    font-size: 13px;
    font-weight: 700;
}
body.student-portal-page .department-message-card p {
    margin: 0;
    color: #18324f;
    line-height: 1.7;
}
body.student-portal-page .department-card-grid {
    display: grid;
    gap: 16px;
}
body.student-portal-page .department-card {
    padding: 18px 20px;
    border: 1px solid #d9e4f0;
    border-radius: 18px;
    background: #ffffff;
}
body.student-portal-page .department-card h3,
body.student-portal-page .department-card h4 {
    margin: 0 0 10px;
    color: #153b60;
}
body.student-portal-page .department-card p {
    margin: 0;
    color: #4a627b;
    line-height: 1.7;
}
body.student-portal-page .department-notice-card {
    padding: 22px 24px;
    border: 1px solid #d7e3ef;
    border-radius: 20px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    box-shadow: 0 14px 30px rgba(16, 51, 86, 0.08);
}
body.student-portal-page .department-notice-meta {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    color: #5d758e;
    font-size: 13px;
    font-weight: 700;
}
body.student-portal-page .department-notice-title {
    margin: 12px 0 8px;
    color: #143d66;
    font-size: 28px;
}
body.student-portal-page .department-notice-type {
    margin: 0 0 14px;
    color: #24639a;
    font-size: 16px;
    font-weight: 700;
}
body.student-portal-page .department-notice-body {
    color: #223a54;
    line-height: 1.8;
    white-space: pre-wrap;
}
body.student-portal-page .department-pagination {
    margin-top: 18px;
    text-align: center;
}
body.student-portal-page .department-pagination a {
    color: #175186;
    font-weight: 700;
    text-decoration: none;
}
body.student-portal-page .department-pagination a:hover {
    text-decoration: underline;
}
@media (max-width: 1180px) {
    body.student-portal-page .main-row {
        grid-template-columns: minmax(260px, 320px) minmax(0, 1fr) minmax(320px, 380px) !important;
    }
}
@media (max-width: 980px) {
    body.student-portal-page .main-row {
        grid-template-columns: minmax(250px, 300px) minmax(0, 1fr) !important;
        padding-right: 0 !important;
    }
    body.student-portal-page #sidebar {
        grid-column: 1 / -1;
        padding-right: 0 !important;
    }
    body.student-portal-page .profile-thumb {
        width: 190px;
        height: 170px;
    }
}
@media (max-width: 860px) {
    body.student-portal-page #container {
        width: calc(100vw - 10px) !important;
        margin: 5px auto 14px !important;
    }
    body.student-portal-page #header,
    body.student-portal-page #menu,
    body.student-portal-page #footer {
        width: calc(100% - 10px) !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }
    body.student-portal-page .main-row {
        grid-template-columns: 1fr;
        margin: 12px 5px 16px !important;
    }
    body.student-portal-page .profile-thumb {
        width: 180px;
        height: 160px;
    }
    body.student-portal-page .department-page-shell {
        padding: 22px 18px;
    }
    body.student-portal-page .department-page-header {
        flex-direction: column;
    }
    body.student-portal-page .department-form-grid.two-col {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body class="student-portal-page light-theme">
<div id="container">
    <div id="header"><?php require(__DIR__ . "/header.php"); ?></div>
    <div id="menu"><?php require(__DIR__ . "/menudepthead.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require(__DIR__ . "/sidemenudepthead.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="department-page-shell">
                    <div class="department-page-header">
                        <div>
                            <span class="department-page-kicker"><?php echo departmentH($kicker); ?></span>
                            <h1 class="department-page-title"><?php echo departmentH($heading); ?></h1>
                            <?php if ($copy !== '') { ?>
                            <p class="department-page-copy"><?php echo departmentH($copy); ?></p>
                            <?php } ?>
                        </div>
                        <?php if ($actionsHtml !== '') { ?>
                        <div class="department-page-actions"><?php echo $actionsHtml; ?></div>
                        <?php } ?>
                    </div>
    <?php
}

function departmentRenderPageEnd(): void
{
    ?>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require(__DIR__ . "/rightsidebar.php"); ?></div>
    </div>
    <div id="footer"><?php include(__DIR__ . "/../footer.php"); ?></div>
</div>
</body>
</html>
    <?php
}
?>
