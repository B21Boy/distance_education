<?php
session_start();
include(__DIR__ . '/../connection.php');

function redirect_feedback(string $type, string $message): void
{
    header('Location: viewfeedback.php?type=' . urlencode($type) . '&message=' . urlencode($message));
    exit;
}

if (!isset($_SESSION['sun']) || !isset($_SESSION['spw']) || !isset($_SESSION['sfn']) || !isset($_SESSION['sln']) || !isset($_SESSION['srole'])) {
    header('Location: ../index.php');
    exit;
}

if (!($conn instanceof mysqli)) {
    redirect_feedback('error', 'Database connection is not available.');
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    redirect_feedback('error', 'Invalid feedback record.');
}

$stmt = mysqli_prepare($conn, 'DELETE FROM feed_back WHERE fbid = ?');
if (!($stmt instanceof mysqli_stmt)) {
    redirect_feedback('error', 'Could not prepare the delete request.');
}
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$deleted = mysqli_stmt_affected_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if (!$deleted) {
    redirect_feedback('error', 'Feedback record was not deleted.');
}

redirect_feedback('success', 'Feedback deleted successfully.');
?>
