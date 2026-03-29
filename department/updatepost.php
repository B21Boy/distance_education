<?php
session_start();
require_once(__DIR__ . '/../connection.php');
require_once(__DIR__ . '/page_helpers.php');

departmentRequireLogin();

$status = trim((string) ($_GET['status'] ?? ''));
$messages = [
    'posted' => 'Notice posted successfully.',
    'empty' => 'Please complete all required notice fields.',
    'error' => 'The notice could not be posted right now.',
    'db-error' => 'The notice page could not load data from the database right now.'
];

$perPage = 5;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$total = 0;
$posts = [];
$hasDbError = false;

$countStmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM postss WHERE status = ' '");
if ($countStmt) {
    mysqli_stmt_execute($countStmt);
    mysqli_stmt_bind_result($countStmt, $totalRows);
    if (mysqli_stmt_fetch($countStmt)) {
        $total = (int) $totalRows;
    }
    mysqli_stmt_close($countStmt);
} else {
    $hasDbError = true;
}

$totalPages = max(1, (int) ceil($total / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;

$postStmt = mysqli_prepare(
    $conn,
    "SELECT Title, types, dates, Ex_date, info, posted_by
     FROM postss
     WHERE status = ' '
     ORDER BY dates DESC
     LIMIT ?, ?"
);
if ($postStmt) {
    mysqli_stmt_bind_param($postStmt, 'ii', $offset, $perPage);
    mysqli_stmt_execute($postStmt);
    $result = mysqli_stmt_get_result($postStmt);
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
        mysqli_free_result($result);
    }
    mysqli_stmt_close($postStmt);
} else {
    $hasDbError = true;
}

if ($hasDbError && $status === '') {
    $status = 'db-error';
}

$actions = '<a rel="facebox" href="posti.php" class="department-btn">Post updated information</a>';

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Department notices",
    "Read posted notices and publish new department updates from the standard content layout.",
    $actions
);
?>
<?php echo departmentStatusBanner($status, $messages); ?>
<div class="department-stat-row">
    <span class="department-stat-chip">Active notices: <?php echo $total; ?></span>
    <span class="department-stat-chip">Page: <?php echo $page; ?> / <?php echo $totalPages; ?></span>
</div>

<?php if ($hasDbError) { ?>
<div class="department-empty">The department notice list could not be loaded right now. Please try again in a moment.</div>
<?php } elseif (!$posts) { ?>
<div class="department-empty">There is no posted notice right now.</div>
<?php } else { ?>
<?php foreach ($posts as $post) { ?>
<article class="department-notice-card">
    <div class="department-notice-meta">
        <span>Date: <?php echo departmentH($post['dates']); ?></span>
        <?php if (!empty($post['Ex_date'])) { ?>
        <span>Expires: <?php echo departmentH($post['Ex_date']); ?></span>
        <?php } ?>
    </div>
    <h2 class="department-notice-title"><?php echo departmentH($post['Title']); ?></h2>
    <p class="department-notice-type"><?php echo departmentH($post['types']); ?></p>
    <div class="department-notice-body"><?php echo departmentH($post['info']); ?></div>
    <p class="department-notice-meta" style="margin-top:18px;"><span>Posted by: <?php echo departmentH($post['posted_by']); ?></span></p>
</article>
<?php } ?>

<?php if ($totalPages > 1) { ?>
<div class="department-page-toolbar" style="margin-top:18px;">
    <div class="department-inline-actions">
        <?php if ($page > 1) { ?>
        <a href="updatepost.php?page=<?php echo $page - 1; ?>" class="page-nav-link is-secondary">Previous</a>
        <?php } ?>
    </div>
    <div class="department-inline-actions">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
        <a href="updatepost.php?page=<?php echo $i; ?>" class="page-nav-link<?php echo $i === $page ? ' is-primary' : ''; ?>"><?php echo $i; ?></a>
        <?php } ?>
    </div>
    <div class="department-inline-actions">
        <?php if ($page < $totalPages) { ?>
        <a href="updatepost.php?page=<?php echo $page + 1; ?>" class="page-nav-link is-secondary">Next</a>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
