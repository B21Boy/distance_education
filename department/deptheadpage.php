<?php
session_start();
include("../connection.php");
require_once("page_helpers.php");

departmentRequireLogin();

$departmentName = departmentCurrentDepartmentName($conn);
$userId = departmentCurrentUserId();
$unreadMessages = departmentFetchUnreadMessages($conn, $userId);

departmentRenderPageStart(
    "Department head page",
    "Department Head",
    "Department dashboard",
    "Use this page to manage instructors, review academic requests, monitor notifications, and keep department notices current."
);
?>
<div class="department-stat-row">
    <?php if ($departmentName !== '') { ?>
    <span class="department-stat-chip">Department: <?php echo departmentH($departmentName); ?></span>
    <?php } ?>
    <?php if ($userId !== '') { ?>
    <span class="department-stat-chip">Account: <?php echo departmentH($userId); ?></span>
    <?php } ?>
    <span class="department-stat-chip">Unread notifications: <?php echo count($unreadMessages); ?></span>
</div>

<div class="department-card-grid">
    <div class="department-card">
        <h3>Instructor assignment</h3>
        <p>Review the courses mapped to your department and assign each one to the right instructor from a single standard page.</p>
        <div class="department-inline-actions" style="margin-top:14px;">
            <a href="manageinst.php" class="department-btn">Open instructor assignment</a>
        </div>
    </div>
    <div class="department-card">
        <h3>Student result approval</h3>
        <p>Check pending course-result requests and grade-report approvals from the left menu without leaving the department workspace.</p>
        <div class="department-inline-actions" style="margin-top:14px;">
            <a href="allrequest.php" class="department-link-btn">Course result requests</a>
            <a href="allrequestgr.php" class="department-link-btn">Grade report requests</a>
        </div>
    </div>
    <div class="department-card">
        <h3>Communication and notices</h3>
        <p>Read new notifications, reply to messages, and post department updates from the same standardized layout.</p>
        <div class="department-inline-actions" style="margin-top:14px;">
            <a href="usernotification.php" class="department-link-btn">Notifications</a>
            <a href="updatepost.php" class="department-link-btn">Post notice</a>
        </div>
    </div>
</div>
<?php
departmentRenderPageEnd();
?>
