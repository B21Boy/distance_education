<?php
session_start();
require_once("../connection.php");
require_once(__DIR__ . "/page_helpers.php");

studentRequireLogin();

$today = date('Y-m-d');
$notices = array();

$stmt = mysqli_prepare($conn, "SELECT Title, types, info, posted_by, dates, Ex_date FROM postss WHERE Ex_date >= ? ORDER BY dates DESC");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $today);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notices[] = $row;
        }
        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);
}

studentRenderPageStart(
    "News board",
    "News Board",
    "Latest Active Notices",
    "Only notices whose expiry date is still active are shown here. The content is loaded from the central posts table and ordered by the latest post date."
);
?>
<div class="student-stat-row">
    <span class="student-stat-chip"><?php echo count($notices); ?> active notice<?php echo count($notices) === 1 ? '' : 's'; ?></span>
</div>

<?php if (empty($notices)) { ?>
    <div class="student-empty-state">There are no active notices available right now.</div>
<?php } else { ?>
    <div class="student-notice-list">
        <?php foreach ($notices as $notice) { ?>
            <article class="student-notice-card">
                <div class="student-notice-meta">
                    <span>Posted: <?php echo studentH(studentFormatDate($notice['dates'] ?? '', 'M j, Y')); ?></span>
                    <span>Expires: <?php echo studentH(studentFormatDate($notice['Ex_date'] ?? '', 'M j, Y')); ?></span>
                </div>
                <h2 class="student-notice-title"><?php echo studentH($notice['Title'] ?? ''); ?></h2>
                <p class="student-notice-type"><?php echo studentH($notice['types'] ?? ''); ?></p>
                <div class="student-notice-body"><?php echo nl2br(studentH($notice['info'] ?? '')); ?></div>
                <div class="student-message-actions">
                    <span class="student-stat-chip">Posted by: <?php echo studentH($notice['posted_by'] ?? ''); ?></span>
                </div>
            </article>
        <?php } ?>
    </div>
<?php } ?>
<?php
studentRenderPageEnd();
?>
