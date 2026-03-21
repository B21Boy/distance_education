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
#menubar1 .admin-dropdown > a {
    display: inline-flex !important;
    align-items: center;
    gap: 8px;
}
#menubar1 .admin-dropdown > a::after {
    content: "";
    width: 8px;
    height: 8px;
    border-right: 2px solid currentColor;
    border-bottom: 2px solid currentColor;
    transform: rotate(45deg) translateY(-1px);
    transition: transform 0.22s ease;
}
#menubar1 .admin-dropdown:hover > a::after,
#menubar1 .admin-dropdown:focus-within > a::after {
    transform: rotate(-135deg) translateY(-1px);
}
#menubar1 .admin-dropdown-menu {
    position: absolute;
    top: calc(100% + 12px);
    left: 0;
    min-width: 250px;
    padding: 12px;
    margin: 0;
    list-style: none;
    border: 1px solid rgba(154, 204, 238, 0.45);
    border-radius: 18px;
    background: linear-gradient(180deg, #1f5f93 0%, #103a63 100%);
    box-shadow: 0 22px 40px rgba(12, 33, 76, 0.28);
    z-index: 30;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(12px);
    transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
}
#menubar1 .admin-dropdown-menu::before {
    content: "";
    position: absolute;
    top: -8px;
    left: 24px;
    width: 16px;
    height: 16px;
    background: #1b5685;
    border-top: 1px solid rgba(154, 204, 238, 0.45);
    border-left: 1px solid rgba(154, 204, 238, 0.45);
    transform: rotate(45deg);
}
#menubar1 .admin-dropdown:hover .admin-dropdown-menu,
#menubar1 .admin-dropdown:focus-within .admin-dropdown-menu {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
}
#menubar1 .admin-dropdown-menu li + li {
    margin-top: 8px;
}
#menubar1 .admin-dropdown-menu li {
    margin: 0;
    width: 100%;
}
#menubar1 .admin-dropdown-menu a {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08) !important;
    color: #f7fbff !important;
    font-size: 14px !important;
    font-weight: 600;
    line-height: 1.35;
    text-decoration: none;
    white-space: normal;
    transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
}
#menubar1 .admin-dropdown-menu a:hover,
#menubar1 .admin-dropdown-menu a:focus {
    background: #ffffff !important;
    color: #0f406a !important;
    transform: translateX(4px);
}
</style>
<nav id="menubar1" aria-label="Admin navigation">
    <ul>
        <li class="admin-dropdown">
            <a href="#" aria-haspopup="true" aria-expanded="false">Manage Account</a>
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
