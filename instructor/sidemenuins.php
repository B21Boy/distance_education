<?php

if (!isset($conn)) {
	include("../connection.php");
}
$idd = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$side_links = array(
	array('href' => 'uploadmodule.php', 'label' => 'View Assigned Course'),
	array('href' => 'postresult.php', 'label' => 'Record course result'),
	array('href' => 'viewgrade.php', 'label' => 'Post course result')
);
?>
<div id="sidebar1" class="student-side-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
<div class="student-side-menu-title">Side Menu</div>
<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
	<?php foreach ($side_links as $side_link) { ?>
	<li style="margin:0;width:100%;list-style:none;">
		<a
			href="<?php echo htmlspecialchars($side_link['href'], ENT_QUOTES, 'UTF-8'); ?>"
			style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;"
		>
			<?php echo htmlspecialchars($side_link['label'], ENT_QUOTES, 'UTF-8'); ?>
		</a>
	</li>
	<?php } ?>
	<?php
$coun = 0;
if ($idd !== '') {
	$query = mysqli_query($conn, "select DISTINCT uid from course_result where status='not' and uid='$idd'");
	if ($query instanceof mysqli_result) {
		$coun = mysqli_num_rows($query);
		mysqli_free_result($query);
	}
}
if($coun>='1')
{
?>									
<li style="margin:0;width:100%;list-style:none;"><a href="courseresultrequest.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #f2d0d0;border-radius:14px;background:#fff4f4;color:#8d1c1c;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">Rejected Student result[<?php echo htmlspecialchars((string) $coun, ENT_QUOTES, 'UTF-8'); ?>]</a></li>
		<?php
		}
		else
		{
			?>
<li style="margin:0;width:100%;list-style:none;"><a href="courseresultrequest.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Request</a></li>
			<?php
		}
		?>
	<li style="margin:0;width:100%;list-style:none;">
		<div style="padding:6px 4px 0;color:#114c78;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">View</div>
		<ul style="display:flex;flex-direction:column;gap:10px;margin:10px 0 0;padding:0;list-style:none;">
			<li style="margin:0;list-style:none;"><a href="viewassgin.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View uploded Asigment</a></li>
			<li style="margin:0;list-style:none;"><a href="preparemoduleschedule.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View Module Preparation schedule</a></li>
			<li style="margin:0;list-style:none;"><a href="viewcourse.php" style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;">View course result</a></li>
		</ul>
	</li>
</ul>
<div id="sidedate">
	<h2>Calendar</h2>
	<?php
	require("../date.php");
	?>
</div>
</div>
