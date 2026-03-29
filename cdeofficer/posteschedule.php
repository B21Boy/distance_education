<?php
include '../connection.php';

function posteschedule_redirect(string $message): void
{
    echo '<script type="text/javascript">alert(' . json_encode($message) . ');window.location=\'preparemoduleschedule.php\';</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    posteschedule_redirect('Invalid request.');
}

$infor = isset($_POST['infor']) ? trim((string) $_POST['infor']) : '';
$pbay = isset($_POST['pb']) ? trim((string) $_POST['pb']) : '';

if ($infor === '' || $pbay === '') {
    posteschedule_redirect('Both schedule fields are required.');
}

$existingResult = mysqli_query($conn, "SELECT no FROM module_schedule ORDER BY no DESC LIMIT 1");
$existingRow = $existingResult instanceof mysqli_result ? mysqli_fetch_assoc($existingResult) : null;
if ($existingResult instanceof mysqli_result) {
    mysqli_free_result($existingResult);
}

if (is_array($existingRow) && isset($existingRow['no'])) {
    $scheduleId = (int) $existingRow['no'];
    $stmt = mysqli_prepare($conn, "UPDATE module_schedule SET information = ?, posted_by = ? WHERE no = ?");
    if (!$stmt) {
        posteschedule_redirect('Unable to prepare the schedule update.');
    }

    mysqli_stmt_bind_param($stmt, "ssi", $infor, $pbay, $scheduleId);
    $saved = mysqli_stmt_execute($stmt);
    $errorMessage = mysqli_error($conn);
    mysqli_stmt_close($stmt);

    if (!$saved) {
        posteschedule_redirect('Schedule was not updated. ' . $errorMessage);
    }

    posteschedule_redirect('Successfully Updated.');
}

$stmt = mysqli_prepare($conn, "INSERT INTO module_schedule (information, posted_by) VALUES (?, ?)");
if (!$stmt) {
    posteschedule_redirect('Unable to prepare the schedule insert.');
}

mysqli_stmt_bind_param($stmt, "ss", $infor, $pbay);
$saved = mysqli_stmt_execute($stmt);
$errorMessage = mysqli_error($conn);
mysqli_stmt_close($stmt);

if (!$saved) {
    posteschedule_redirect('Schedule was not posted. ' . $errorMessage);
}

posteschedule_redirect('Successfully Posted.');
?>

