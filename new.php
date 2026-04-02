<?php
session_start();
ob_start();
require_once("connection.php");

function noticeH(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function noticePageUrl(int $page): string
{
    $params = $_GET;
    $params['page'] = $page;

    return htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query($params), ENT_QUOTES, 'UTF-8');
}

$today = date('Y-m-d');
$perPage = 1;
$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$totalRecords = 0;
$totalPages = 0;
$notices = array();
$loadError = '';

$countStmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM postss WHERE Ex_date >= ?");
if ($countStmt) {
    mysqli_stmt_bind_param($countStmt, 's', $today);
    mysqli_stmt_execute($countStmt);
    mysqli_stmt_bind_result($countStmt, $totalRecords);
    mysqli_stmt_fetch($countStmt);
    mysqli_stmt_close($countStmt);
} else {
    $loadError = 'The notice board could not connect to the database.';
}

if ($totalRecords > 0) {
    $totalPages = (int) ceil($totalRecords / $perPage);
    $currentPage = min($currentPage, $totalPages);
    $offset = ($currentPage - 1) * $perPage;

    $noticeStmt = mysqli_prepare(
        $conn,
        "SELECT Title, types, dates, info, posted_by
         FROM postss
         WHERE Ex_date >= ?
         ORDER BY dates DESC
         LIMIT ?, ?"
    );

    if ($noticeStmt) {
        mysqli_stmt_bind_param($noticeStmt, 'sii', $today, $offset, $perPage);
        mysqli_stmt_execute($noticeStmt);
        mysqli_stmt_bind_result($noticeStmt, $title, $type, $datePosted, $info, $postedBy);

        while (mysqli_stmt_fetch($noticeStmt)) {
            $notices[] = array(
                'title' => (string) $title,
                'type' => (string) $type,
                'date' => (string) $datePosted,
                'info' => (string) $info,
                'posted_by' => (string) $postedBy,
            );
        }

        mysqli_stmt_close($noticeStmt);
    } else {
        $loadError = 'The notice board query could not be prepared.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="theme.js"></script>
<meta charset="UTF-8">
<title>News</title>
<link rel="stylesheet" href="setting.css">
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; min-width: 0; }
.main-row > #sidebar { flex: 0 0 260px !important; }
.notice-shell {
    display: grid;
    gap: 20px;
}
.notice-hero,
.notice-card,
.notice-empty,
.notice-status {
    border-radius: 22px;
    box-shadow: 0 18px 38px rgba(11, 36, 61, 0.10);
}
.notice-hero {
    padding: 26px 28px;
    background:
        radial-gradient(circle at top right, rgba(255, 255, 255, 0.24), transparent 32%),
        linear-gradient(135deg, #0f4d79 0%, #1f7a9f 100%);
    color: #f6fbff;
}
.notice-kicker {
    display: inline-flex;
    margin-bottom: 12px;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.notice-hero h1 {
    margin: 0 0 10px;
    font-size: 34px;
    line-height: 1.1;
}
.notice-hero p {
    margin: 0;
    max-width: 620px;
    color: rgba(246, 251, 255, 0.88);
    line-height: 1.7;
}
.notice-status,
.notice-empty {
    padding: 18px 20px;
    background: #ffffff;
    color: #274560;
}
.notice-status {
    border: 1px solid #f0b9b9;
    background: #fff4f4;
    color: #7f1d1d;
}
.notice-card {
    padding: 28px;
    background: linear-gradient(180deg, #ffffff 0%, #f4f9fc 100%);
    border: 1px solid rgba(151, 184, 207, 0.35);
}
.notice-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
    color: #496680;
    font-size: 14px;
    font-weight: 600;
}
.notice-badge {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 999px;
    background: #e7f4fb;
    color: #0f5f86;
}
.notice-title {
    margin: 0 0 14px;
    color: #113553;
    font-size: 30px;
    line-height: 1.15;
}
.notice-body {
    color: #20384b;
    font-size: 16px;
    line-height: 1.85;
    white-space: pre-wrap;
    word-break: break-word;
}
.notice-footer {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(133, 166, 191, 0.28);
    color: #35516a;
    font-weight: 700;
}
.notice-pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}
.notice-pagination a,
.notice-pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    min-height: 42px;
    padding: 0 16px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 700;
}
.notice-pagination a {
    background: #ffffff;
    color: #0f4d79;
    box-shadow: 0 10px 24px rgba(11, 36, 61, 0.12);
}
.notice-pagination span {
    background: #0f4d79;
    color: #ffffff;
}
@media (max-width: 1100px) {
    .main-row {
        flex-direction: column !important;
    }
    .main-row > #left,
    .main-row > #content,
    .main-row > #sidebar {
        flex: 1 1 auto !important;
        width: 100% !important;
    }
}
@media (max-width: 700px) {
    .notice-hero,
    .notice-card,
    .notice-empty,
    .notice-status {
        padding: 22px 18px;
    }
    .notice-hero h1,
    .notice-title {
        font-size: 26px;
    }
}
</style>
<script src="javascript/date_time.js"></script>
</head>
<body class="student-portal-page">

<div id="container">
    <div id="header">
         <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menu.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php include("left.php"); ?>
        </div>

        <div id="content">
            <div class="notice-shell">
                <section class="notice-hero">
                    <span class="notice-kicker">Notice Board</span>
                    <h1>Latest campus notices</h1>
                    <p>Active announcements are loaded from the shared `cde.postss` table through the main site database connection, so the homepage notice board stays in sync with the rest of the system.</p>
                </section>

                <?php if ($loadError !== '') { ?>
                <div class="notice-status"><?php echo noticeH($loadError); ?></div>
                <?php } elseif (!empty($notices)) { ?>
                    <?php foreach ($notices as $notice) { ?>
                    <article class="notice-card">
                        <div class="notice-meta">
                            <span class="notice-badge"><?php echo noticeH($notice['type']); ?></span>
                            <span>Posted on <?php echo noticeH($notice['date']); ?></span>
                        </div>
                        <h2 class="notice-title"><?php echo noticeH($notice['title']); ?></h2>
                        <div class="notice-body"><?php echo nl2br(noticeH($notice['info'])); ?></div>
                        <div class="notice-footer">Posted by <?php echo noticeH($notice['posted_by']); ?></div>
                    </article>
                    <?php } ?>

                    <?php if ($totalPages > 1) { ?>
                    <nav class="notice-pagination" aria-label="Notice pages">
                        <?php if ($currentPage > 1) { ?>
                        <a href="<?php echo noticePageUrl(1); ?>">First</a>
                        <a href="<?php echo noticePageUrl($currentPage - 1); ?>">Prev</a>
                        <?php } ?>

                        <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
                            <?php if ($page === $currentPage) { ?>
                            <span><?php echo $page; ?></span>
                            <?php } else { ?>
                            <a href="<?php echo noticePageUrl($page); ?>"><?php echo $page; ?></a>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($currentPage < $totalPages) { ?>
                        <a href="<?php echo noticePageUrl($currentPage + 1); ?>">Next</a>
                        <a href="<?php echo noticePageUrl($totalPages); ?>">Last</a>
                        <?php } ?>
                    </nav>
                    <?php } ?>
                <?php } else { ?>
                <div class="notice-empty">There are no active notices available right now.</div>
                <?php } ?>
            </div>
        </div>

        <div id="sidebar">
            <?php require("leftlogin.php"); ?>
            <div class="sidebar-panel social-panel">
                <div class="sidebar-panel-title">Social link</div>
                <div class="sidebar-panel-body">
                    <a href="https://www.facebook.com/"><span><ion-icon name="logo-facebook"></ion-icon></span>Facebook</a>
                    <a href="https://www.twitter.com/"><span><ion-icon name="logo-twitter"></ion-icon></span>Twitter</a>
                    <a href="https://www.youtube.com/"><span><ion-icon name="logo-youtube"></ion-icon></span>YouTube</a>
                    <a href="https://plus.google.com/"><span><ion-icon name="logo-google"></ion-icon></span>Google++</a>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include("footer.php"); ?>
    </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
