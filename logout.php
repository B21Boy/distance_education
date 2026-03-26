<?php
session_start();

$time = time();
$actual = date('d M Y @ H:i:s', $time);
include(__DIR__ . '/connection.php');

if ($conn instanceof mysqli) {
    $stmt = mysqli_prepare($conn, 'UPDATE logfile SET end = ? WHERE end = ?');
    if ($stmt instanceof mysqli_stmt) {
        $emptyEnd = '';
        mysqli_stmt_bind_param($stmt, 'ss', $actual, $emptyEnd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$_SESSION = array();
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/distance_education/logout.php');
$segments = array_values(array_filter(explode('/', $scriptName), static function ($segment) {
    return $segment !== '';
}));
$projectSegment = $segments[0] ?? '';
$homePath = ($projectSegment !== '' ? '/' . $projectSegment : '') . '/index.php';
$redirect = trim((string) ($_GET['redirect'] ?? 'home'));
$targetPath = $homePath;

if ($redirect === 'home') {
    $targetPath = $homePath;
}

header('Location: ' . $targetPath);
exit;
?>
