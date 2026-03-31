<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . "/../connection.php");

if (!isset($_POST['submit1'])) {
    header("location:recordresult.php");
    exit;
}

$studentIds = isset($_POST['id']) && is_array($_POST['id']) ? $_POST['id'] : array();
$results = isset($_POST['a1']) && is_array($_POST['a1']) ? $_POST['a1'] : array();
$statuses = isset($_POST['st']) && is_array($_POST['st']) ? $_POST['st'] : array();

if (empty($studentIds) || empty($results) || empty($statuses) || count($studentIds) !== count($results) || count($studentIds) !== count($statuses)) {
    echo '<script type="text/javascript">alert("The submitted entrance exam data is incomplete. Please try again.");window.location=\'recordresult.php\';</script>';
    exit;
}

$currentYear = date('Y');
$allowedStatuses = array('satisfactory', 'unsatisfactory');

$selectStmt = mysqli_prepare($conn, "SELECT 1 FROM entrance_exam WHERE S_ID = ? AND year = ? LIMIT 1");
$insertStmt = mysqli_prepare($conn, "INSERT INTO entrance_exam (S_ID, result, year, status, account) VALUES (?, ?, ?, ?, ' ')");
$updateStmt = mysqli_prepare($conn, "UPDATE entrance_exam SET result = ?, status = ?, account = ' ' WHERE S_ID = ? AND year = ?");

if (!$selectStmt || !$insertStmt || !$updateStmt) {
    if ($selectStmt) {
        mysqli_stmt_close($selectStmt);
    }
    if ($insertStmt) {
        mysqli_stmt_close($insertStmt);
    }
    if ($updateStmt) {
        mysqli_stmt_close($updateStmt);
    }

    echo '<script type="text/javascript">alert("The entrance exam result page could not prepare the database request.");window.location=\'recordresult.php\';</script>';
    exit;
}

mysqli_begin_transaction($conn);

try {
    $savedRows = 0;

    for ($i = 0, $rowCount = count($studentIds); $i < $rowCount; $i++) {
        $studentId = trim((string) $studentIds[$i]);
        $resultValue = trim((string) $results[$i]);
        $statusValue = trim((string) $statuses[$i]);

        if ($studentId === '' || $resultValue === '' || !in_array($statusValue, $allowedStatuses, true)) {
            continue;
        }

        mysqli_stmt_bind_param($selectStmt, 'ss', $studentId, $currentYear);
        if (!mysqli_stmt_execute($selectStmt)) {
            throw new RuntimeException(mysqli_error($conn));
        }

        mysqli_stmt_store_result($selectStmt);
        $rowExists = mysqli_stmt_num_rows($selectStmt) > 0;

        if ($rowExists) {
            mysqli_stmt_bind_param($updateStmt, 'ssss', $resultValue, $statusValue, $studentId, $currentYear);
            if (!mysqli_stmt_execute($updateStmt)) {
                throw new RuntimeException(mysqli_error($conn));
            }
        } else {
            mysqli_stmt_bind_param($insertStmt, 'ssss', $studentId, $resultValue, $currentYear, $statusValue);
            if (!mysqli_stmt_execute($insertStmt)) {
                throw new RuntimeException(mysqli_error($conn));
            }
        }

        $savedRows++;
    }

    if ($savedRows === 0) {
        throw new RuntimeException('No valid result rows were submitted.');
    }

    mysqli_commit($conn);
    mysqli_stmt_close($selectStmt);
    mysqli_stmt_close($insertStmt);
    mysqli_stmt_close($updateStmt);

    echo '<script type="text/javascript">alert("Successfully posted.");window.location=\'recordresult.php\';</script>';
    exit;
} catch (Throwable $exception) {
    mysqli_rollback($conn);
    mysqli_stmt_close($selectStmt);
    mysqli_stmt_close($insertStmt);
    mysqli_stmt_close($updateStmt);

    echo '<script type="text/javascript">alert("The result could not be saved. Please try again.");window.location=\'recordresult.php\';</script>';
    exit;
}
?>
