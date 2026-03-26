<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");
require_once("ps_pagination.php");

departmentRequireLogin();

$sql = "SELECT * FROM postss WHERE status = ' ' ORDER BY dates DESC";
$pager = new PS_Pagination($conn, $sql, 1, 5);
$rs = $pager->paginate();
$posts = [];
if ($rs instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($rs)) {
        $posts[] = $row;
    }
    mysqli_free_result($rs);
}
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM postss WHERE status = ' '");
$total = 0;
if ($countResult instanceof mysqli_result) {
    $countRow = mysqli_fetch_assoc($countResult);
    $total = (int) ($countRow['total'] ?? 0);
    mysqli_free_result($countResult);
}

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Department notices",
    "Read posted notices and publish new department updates from the standard content layout.",
    '<a rel="facebox" href="posti.php" class="department-btn">Post updated information</a>'
);
?>
<div class="department-stat-row">
    <span class="department-stat-chip">Active notices: <?php echo $total; ?></span>
</div>

<?php if (!$posts) { ?>
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
<div class="department-pagination"><?php echo $pager->renderFullNav(); ?></div>
<?php } ?>
<?php
departmentRenderPageEnd();
?>
