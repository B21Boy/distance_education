<?php
session_start();
include("../connection.php");

function fetchDistinctAssignedCourseValues(mysqli $conn, string $column, string $userId): array
{
    $allowedColumns = [
        "department",
        "Student_class_year",
        "semister",
        "section",
        "corse_code",
    ];

    if (!in_array($column, $allowedColumns, true) || $userId === "") {
        return [];
    }

    $sql = "SELECT DISTINCT `$column` AS value FROM assign_instructor WHERE uid = ? ORDER BY `$column`";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, "s", $userId);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [];
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result instanceof mysqli_result) {
        mysqli_stmt_close($stmt);
        return [];
    }

    $values = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row["value"])) {
            $values[] = $row["value"];
        }
    }

    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

    return $values;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>Instructor page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
<link rel="stylesheet" href="febe/style.css" type="text/css" media="screen" charset="utf-8">
<style>
.main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 20px !important;
    align-items: flex-start !important;
}
.main-row > #left { flex: 0 0 300px !important; }
.main-row > #content { flex: 1 1 auto !important; }
.main-row > #sidebar { flex: 0 0 260px !important; }
</style>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION["sun"]) && isset($_SESSION["spw"]) && isset($_SESSION["sfn"]) && isset($_SESSION["sln"]) && isset($_SESSION["srole"])) {
    $userId = isset($_SESSION["suid"]) ? (string) $_SESSION["suid"] : "";
    $firstName = htmlspecialchars($_SESSION["sfn"], ENT_QUOTES, "UTF-8");
    $lastName = htmlspecialchars($_SESSION["sln"], ENT_QUOTES, "UTF-8");
    $photoValue = isset($_SESSION["sphoto"]) ? trim($_SESSION["sphoto"]) : "";
    $photoPath = htmlspecialchars($photoValue, ENT_QUOTES, "UTF-8");

    $departments = fetchDistinctAssignedCourseValues($conn, "department", $userId);
    $classYears = fetchDistinctAssignedCourseValues($conn, "Student_class_year", $userId);
    $semisters = fetchDistinctAssignedCourseValues($conn, "semister", $userId);
    $sections = fetchDistinctAssignedCourseValues($conn, "section", $userId);
    $courseCodes = fetchDistinctAssignedCourseValues($conn, "corse_code", $userId);
?>
<div id="container">
    <div id="header">
        <?php require("header.php"); ?>
    </div>

    <div id="menu">
        <?php require("menuins.php"); ?>
    </div>

    <div class="main-row">
        <div id="left">
            <?php require("sidemenuins.php"); ?>
        </div>

        <div id="content">
            <div id="contentindex5">
                <fieldset style="margin-left: 0;">
                    <legend>Post Student Course Result</legend>
                    <form action="viewcourseresult1.php" method="post">
                        <table>
                            <tr>
                                <td>Select Department:</td>
                                <td>
                                    <select name="dpt" class="login-form2" style="height:30px; width:180px;" required>
                                        <option value="">--select department--</option>
                                        <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo htmlspecialchars($department, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($department, ENT_QUOTES, "UTF-8"); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td rowspan="3">
                                    <input type="submit" value="Search" name="search" style="font-size:25px; background-color:#003366; color:white">
                                </td>
                            </tr>
                            <tr>
                                <td>Student Class Year:</td>
                                <td>
                                    <select name="scy" class="login-form2" style="height:30px; width:180px;" required>
                                        <option value="">--select Class Year--</option>
                                        <?php foreach ($classYears as $classYear) { ?>
                                        <option value="<?php echo htmlspecialchars($classYear, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($classYear, ENT_QUOTES, "UTF-8"); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Semister:</td>
                                <td>
                                    <select name="sem" class="login-form2" style="height:30px; width:180px;" required>
                                        <option value="">--select Semister--</option>
                                        <?php foreach ($semisters as $semister) { ?>
                                        <option value="<?php echo htmlspecialchars($semister, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($semister, ENT_QUOTES, "UTF-8"); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Section:</td>
                                <td>
                                    <select name="sec" class="login-form2" style="height:30px; width:180px;" required>
                                        <option value="">--select Section--</option>
                                        <?php foreach ($sections as $section) { ?>
                                        <option value="<?php echo htmlspecialchars($section, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($section, ENT_QUOTES, "UTF-8"); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Course Code:</td>
                                <td>
                                    <select name="cc" class="login-form2" style="height:30px; width:180px;" required>
                                        <option value="">Select course code</option>
                                        <?php foreach ($courseCodes as $courseCode) { ?>
                                        <option value="<?php echo htmlspecialchars($courseCode, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($courseCode, ENT_QUOTES, "UTF-8"); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </div>
        </div>

        <div id="sidebar">
            <div id="siderightindexphoto">
                <div id="siderightindexphoto1">
                    User Profile
                </div>

                <p>
                    <b><font color="blue">Welcome:</font><font color="#f9160b">(<?php echo $firstName . "&nbsp;&nbsp;&nbsp;" . $lastName; ?>)</font></b>
                </p>
                <?php if ($photoPath !== "") { ?>
                <p><b><img src="<?php echo $photoPath; ?>" width="180" height="160" alt="Instructor profile photo"></b></p>
                <?php } ?>

                <div id="sidebarr">
                    <ul>
                        <li><a href="#.html">Change Photo</a></li>
                        <li><a href="changepass.php">Change password</a></li>
                    </ul>
                </div>
            </div>

            <div id="siderightindexadational">
                <div id="siderightindexadational1">
                    Another link
                </div>
                <div id="siderightindexadational12">
                    <table>
                        <tr><td><div id="facebook"></div></td><td><p><a href="https://www.facebook.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Facebook</a></p></td></tr>
                        <tr><td><div id="twitter"></div></td><td><p><a href="https://www.twitter.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Twitter</a></p></td></tr>
                        <tr><td><div id="you"></div></td><td><p><a href="https://www.youtube.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Youtube</a></p></td></tr>
                        <tr><td><div id="googleplus"></div></td><td><p><a href="https://plus.google.com/" style="text-decoration: none;">&nbsp;&nbsp;&nbsp;Google++</a></p></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include("../footer.php"); ?>
    </div>
</div>
<?php
} else {
    header("location:../index.php");
    exit;
}
?>
</body>
</html>
