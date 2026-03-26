<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../theme.js"></script>
<meta charset="UTF-8">
<title>CDE Officer page</title>
<link rel="stylesheet" type="text/css" href="../setting.css">
<script type="text/javascript" src="../javascript/date_time.js"></script>
</head>
<body class="student-portal-page light-theme">
<?php
if (isset($_SESSION['sun']) && isset($_SESSION['spw']) && isset($_SESSION['sfn']) && isset($_SESSION['sln']) && isset($_SESSION['srole'])) {
    include('ps_pagination.php');
    $conn = mysql_connect('localhost', 'root', '');
    if (!$conn) {
        die("Failed to connect to database!");
    }
    $status = mysql_select_db('cde', $conn);
    if (!$status) {
        die("Failed to select database!");
    }

    $requestType = 'tutorial';
    $seenPage = 'messageddotutorial.php';
    $countQuery = mysql_query("select * from payment_table where unread='yes' and status='no' and type='" . $requestType . "'") or die(mysql_error());
    $pendingCount = mysql_num_rows($countQuery);
    $sql = "select * from payment_table where unread='yes' and status='no' and type='" . $requestType . "'";
    $pager = new PS_Pagination($conn, $sql, 10, 1);
    $rs = $pager->paginate();
?>
<div id="container">
    <div id="header"><?php require("header.php"); ?></div>
    <div id="menu"><?php require("menucdeo.php"); ?></div>
    <div class="main-row">
        <div id="left"><?php require("sidemenucdeo.php"); ?></div>
        <div id="content">
            <div id="contentindex5">
                <div class="admin-page-shell">
                    <div class="admin-page-header">
                        <div>
                            <span class="admin-page-kicker">CDE Officer</span>
                            <h1 class="admin-page-title">Unread Tutorial Requests</h1>
                            <p class="admin-page-copy">Review new tutorial payment requests, open each calculation form, and send approved records to finance.</p>
                        </div>
                    </div>
                    <div class="admin-page-panel">
                        <div class="admin-page-toolbar">
                            <div class="page-nav-links">
                                <a class="page-nav-link is-primary" href="unreaddotutorial.php">Unseen Requests [<?php echo $pendingCount; ?>]</a>
                                <a class="page-nav-link" href="<?php echo $seenPage; ?>">Seen Requests</a>
                                <a class="page-nav-link is-secondary" href="sendall.php?id=<?php echo $requestType; ?>">Send To Finance</a>
                            </div>
                            <span class="page-stat-chip"><?php echo $pendingCount; ?> pending tutorial requests</span>
                        </div>
                        <?php if ($pendingCount != '0') { ?>
                        <div class="admin-page-table-wrap">
                            <table class="admin-page-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sender UID</th>
                                        <th>Tutor Name</th>
                                        <th>Rank</th>
                                        <th>Course Tutored</th>
                                        <th>Cr Hr</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <th>Tutorial Hours</th>
                                        <th>Payment Per Hour</th>
                                        <th>Total Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysql_fetch_array($rs)) { ?>
                                    <tr>
                                        <td><?php echo $row["no"]; ?></td>
                                        <td><?php echo $row["c_code"]; ?></td>
                                        <td><?php echo $row["Instructors_Name"]; ?></td>
                                        <td><?php echo $row["Rank"]; ?></td>
                                        <td><?php echo $row["Course_Code"]; ?></td>
                                        <td><?php echo $row["CrHr"]; ?></td>
                                        <td><?php echo $row["Department"]; ?></td>
                                        <td><?php echo $row["Year"]; ?></td>
                                        <td><?php echo $row["Section"]; ?></td>
                                        <td><?php echo $row["No_of_hours_she_he_gave_tutorial"]; ?></td>
                                        <td><?php echo $row["Payment_per"]; ?></td>
                                        <td><?php echo $row["Total_Payment"]; ?></td>
                                        <td><a class="table-action-link" rel="facebox" href="calculateotutorial.php?id=<?php echo $row['no']; ?>">Fill and Calculate Pay Form</a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-page-pagination"><?php echo $pager->renderFullNav(); ?></div>
                        <?php } else { ?>
                        <div class="admin-page-empty">No new tutorial payment requests were found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar"><?php require("officer_sidebar.php"); ?></div>
    </div>
    <div id="footer"><?php include("../footer.php"); ?></div>
</div>
<?php
} else {
    header("location:../index.php");
    exit;
}
?>
</body>
</html>
