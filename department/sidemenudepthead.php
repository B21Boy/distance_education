<?php
if (!isset($conn)) {
	require_once("../connection.php");
}

$dept = isset($_SESSION['sdc']) ? mysqli_real_escape_string($conn, (string) $_SESSION['sdc']) : '';
$dcode = '';
$uid = isset($_SESSION['suid']) ? $_SESSION['suid'] : '';

if ($dept !== '') {
	$result1 = mysqli_query($conn, "SELECT * FROM department where Dcode='$dept'");
	if ($result1 instanceof mysqli_result) {
		$row = mysqli_fetch_assoc($result1);
		if ($row) {
			$dcode = $row['DName'];
		}
		mysqli_free_result($result1);
	}
}
?>
<?php
$query = "select distinct uid,section,C_Code,year from course_result where status='posted' and reject=' ' and send_to='$dept'";
$count = 0;
$result = mysqli_query($conn, $query);
if ($result instanceof mysqli_result) {
	$count = mysqli_num_rows($result);
	mysqli_free_result($result);
}

$query2 = "select distinct department,section,year from grade where status='approve' and checking='pending' and department='$dcode'";
$count2 = 0;
$result2 = mysqli_query($conn, $query2);
if ($result2 instanceof mysqli_result) {
	$count2 = mysqli_num_rows($result2);
	mysqli_free_result($result2);
}
$t=$count+$count2;
?>
<div class="department-left-stack">
<div id="sidebar1" class="student-side-panel department-side-menu-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
<div class="student-side-menu-title">Side Menu</div>
<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
	<li style="margin:0;width:100%;list-style:none;">
		<div style="padding:6px 4px 0;color:#114c78;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">View Employee worked time</div>
		<ul style="display:flex;flex-direction:column;gap:10px;margin:10px 0 0;padding:0;list-style:none;">
			<li style="margin:0;list-style:none;"><a href="messageddotutorial.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Offering Tutorial Program</a></li>
			<li style="margin:0;list-style:none;"><a href="messageddmexam.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Marking Exams</a></li>
			<li style="margin:0;list-style:none;"><a href="messageddmassignment.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Marking Assignments</a></li>
			<li style="margin:0;list-style:none;"><a href="messageddifexam.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Invigilating Final Exams</a></li>
			<li style="margin:0;list-style:none;"><a href="messageddpexam.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Preparing Exams</a></li>
			<li style="margin:0;list-style:none;"><a href="messageddmexamassign.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Marking Exams and Assignments</a></li>
		</ul>
	</li>
	<li style="margin:0;width:100%;list-style:none;">
		<div style="padding:6px 4px 0;color:#8d1c1c;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Approve student results[<?php echo htmlspecialchars((string) $t, ENT_QUOTES, 'UTF-8'); ?>]</div>
		<ul style="display:flex;flex-direction:column;gap:10px;margin:10px 0 0;padding:0;list-style:none;">
			<li style="margin:0;list-style:none;"><a href="allrequest.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Course Result[<?php echo htmlspecialchars((string) $count, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
			<li style="margin:0;list-style:none;"><a href="allrequestgr.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Grade Report[<?php echo htmlspecialchars((string) $count2, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
		</ul>
	</li>
	<li style="margin:0;width:100%;list-style:none;">
		<div style="padding:6px 4px 0;color:#114c78;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">View</div>
		<ul style="display:flex;flex-direction:column;gap:10px;margin:10px 0 0;padding:0;list-style:none;">
			<li style="margin:0;list-style:none;"><a href="generateclass.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Student</a></li>
			<li style="margin:0;list-style:none;"><a href="viewacadamicschedul.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View academic schedule</a></li>
			<li style="margin:0;list-style:none;"><a href="viewcourseresult.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Course Result</a></li>
			<li style="margin:0;list-style:none;"><a href="#.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Grade Report</a></li>
		</ul>
	</li>
	<li style="margin:0;width:100%;list-style:none;">
		<a href="updatepost.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Post notice</a>
	</li>
</ul>
</div>
<div class="sidebar-panel department-calendar-panel">
	<div class="sidebar-panel-title">Calendar</div>
	<div class="sidebar-panel-body">
		<div id="sidedate">
			<?php
			require("../date.php");
			?>
		</div>
	</div>
</div>
</div>
