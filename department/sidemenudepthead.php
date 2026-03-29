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
<div class="department-left-stack">
<div id="sidebar1" class="student-side-panel department-side-menu-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
<div class="student-side-menu-title">Side Menu</div>
<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
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
