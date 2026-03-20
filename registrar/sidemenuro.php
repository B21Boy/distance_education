<?php
$registrar_side_links = array(
	array('href' => 'generateid.php', 'label' => 'Generate ID card'),
	array('href' => 'acadamic_calender.php', 'label' => 'Prepare acadmic schdule'),
	array('href' => 'viewstudent.php', 'label' => 'View imported student data'),
	array('href' => 'updatestud.php', 'label' => 'Update student data')
);
?>
<div id="sidebar1" class="student-side-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
<div class="student-side-menu-title">Side Link</div>
<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
	<?php foreach ($registrar_side_links as $registrar_side_link) { ?>
	<li style="margin:0;width:100%;list-style:none;">
		<a
			href="<?php echo htmlspecialchars($registrar_side_link['href'], ENT_QUOTES, 'UTF-8'); ?>"
			style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;"
		>
			<?php echo htmlspecialchars($registrar_side_link['label'], ENT_QUOTES, 'UTF-8'); ?>
		</a>
	</li>
	<?php } ?>
</ul>
<div id="sidedate">
	<h2>Calendar</h2>
	<?php
	require("../date.php");
	?>
</div>
</div>
