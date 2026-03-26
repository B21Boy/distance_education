<?php
if (!function_exists('cdeofficer_safe_count')) {
	function cdeofficer_safe_count(mysqli $conn, string $sql): int
	{
		$result = mysqli_query($conn, $sql);
		if ($result instanceof mysqli_result) {
			$count = mysqli_num_rows($result);
			mysqli_free_result($result);
			return $count;
		}

		return 0;
	}
}

if (!isset($conn)) {
	require_once("../connection.php");
}
?>
<script src="js/validation.js" type="text/javascript"></script>
<?php
$uploaded_module_count = cdeofficer_safe_count($conn, "SELECT * FROM course WHERE status='no'");
?>
<div id="sidebar1" class="student-side-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
<div class="student-side-menu-title">Side Link</div>
<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
	<li style="margin:0;width:100%;list-style:none;">
		<a href="viewuploadmodule.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid <?php echo $uploaded_module_count >= 1 ? '#f2d0d0' : '#dce9f1'; ?>;border-radius:14px;background:<?php echo $uploaded_module_count >= 1 ? '#fff4f4' : '#f7fbfd'; ?>;color:<?php echo $uploaded_module_count >= 1 ? '#8d1c1c' : '#17364e'; ?>;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Uploded Module[<?php echo htmlspecialchars((string) $uploaded_module_count, ENT_QUOTES, 'UTF-8'); ?>]</a>
	</li>
	<li style="margin:0;width:100%;list-style:none;">
		<div style="padding:6px 4px 0;color:#114c78;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">View</div>
		<ul style="display:flex;flex-direction:column;gap:10px;margin:10px 0 0;padding:0;list-style:none;">
			<li style="margin:0;list-style:none;"><a href="viewacadamicschedul.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View acadamic schedule</a></li>
			<li style="margin:0;list-style:none;"><a href="postresult.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Entrance Exam Result</a></li>
		</ul>
	</li>
	<li style="margin:0;width:100%;list-style:none;">
		<a href="recordresult.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Post Entrance Exam Result</a>
	</li>
</ul>

</div>
<div id="sidedate">
	<div class="student-side-menu-title">Calendar</div>
	<?php
	require("../date.php");
	?>
</div>
