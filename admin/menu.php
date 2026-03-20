<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if (!isset($conn)) {
	require_once("../connection.php");
}

$query = mysqli_query($conn, "SELECT * FROM student WHERE unread='no' ORDER BY Department ASC") or die(mysqli_error($conn));
$student_request_count = mysqli_num_rows($query);

$query1 = mysqli_query($conn, "SELECT * FROM entrance_exam WHERE status='unsatisfactory' AND (account=' ' OR account='seen')") or die(mysqli_error($conn));
$blocked_request_count = mysqli_num_rows($query1);

$count_item = mysqli_query($conn, "SELECT * FROM feed_back") or die(mysqli_error($conn));
$feedback_count = mysqli_num_rows($count_item);

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$request_label = 'Request For Account';
if ($student_request_count >= 1) {
	$request_label = 'New Request For Account Creation[' . $student_request_count . ']';
} elseif ($blocked_request_count >= 1) {
	$request_label = 'Request For Block Account[' . $blocked_request_count . ']';
}
$request_class = trim((($student_request_count >= 1 || $blocked_request_count >= 1) ? 'has-alert ' : '') . ($current_page === 'studentlist.php' ? 'active' : ''));
$feedback_class = trim(($feedback_count >= 1 ? 'has-alert ' : '') . ($current_page === 'viewfeedback.php' ? 'active' : ''));
?>
<style>
#menubar1 .admin-dropdown {
    position: relative;
}
#menubar1 .admin-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    min-width: 220px;
    padding: 10px 0;
    margin: 0;
    list-style: none;
    background: #13466e;
    border-radius: 14px;
    box-shadow: 0 12px 24px rgba(12, 33, 76, 0.24);
    z-index: 20;
}
#menubar1 .admin-dropdown:hover .admin-dropdown-menu {
    display: block;
}
#menubar1 .admin-dropdown-menu li {
    margin: 0;
    width: 100%;
}
#menubar1 .admin-dropdown-menu a {
    display: block;
    padding: 10px 16px;
    border-radius: 0;
    background: transparent !important;
    color: #f7fbff !important;
    font-size: 14px !important;
    font-weight: 600;
    text-decoration: none;
    white-space: normal;
}
#menubar1 .admin-dropdown-menu a:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    transform: none !important;
}
</style>
<nav id="menubar1" aria-label="Admin navigation">
    <ul>
        <li class="admin-dropdown">
            <a href="#">Manage Account</a>
            <ul class="admin-dropdown-menu">
                <li><a href="adduser.php">Register User</a></li>
                <li><a href="addaccount.php">Create Account</a></li>
                <li><a href="addaccountb.php">Block Account</a></li>
            </ul>
        </li>
        <li><a href="studentlist.php"<?php echo $request_class !== '' ? ' class="' . htmlspecialchars($request_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>><?php echo htmlspecialchars($request_label, ENT_QUOTES, 'UTF-8'); ?></a></li>
        <li><a href="viewfeedback.php"<?php echo $feedback_class !== '' ? ' class="' . htmlspecialchars($feedback_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>View feedback[<?php echo htmlspecialchars((string) $feedback_count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
        <li><a href="../logout.php">Log out</a></li>
    </ul>
</nav>
