<?php
$student_side_links = array(
	array('href' => 'assignmentsubmit.php', 'label' => 'Submit Assignment'),
	array('href' => 'viewgradeallv.php', 'label' => 'View Grade Report'),
	array('href' => 'viewcourseresult.php', 'label' => 'View Course Result'),
	array('href' => 'viewentranceresult.php', 'label' => 'View Entrance Exam Result'),
	array('href' => 'feedback.php', 'label' => 'Send Feedback'),
	array('href' => 'new.php', 'label' => 'See News')
);
?>
<div id="sidebar1" class="student-side-panel" style="width:100%;max-width:100%;box-sizing:border-box;">
	<div class="student-side-menu-title">Student Menu</div>
	<ul class="student-side-nav" style="display:flex;flex-direction:column;gap:10px;margin:0;padding:18px;width:100%;min-width:0;height:auto;background:transparent;border:0;box-sizing:border-box;list-style:none;">
		<?php foreach ($student_side_links as $student_side_link) { ?>
			<li style="margin:0;width:100%;list-style:none;">
				<a
					href="<?php echo htmlspecialchars($student_side_link['href'], ENT_QUOTES, 'UTF-8'); ?>"
					style="display:block;width:100%;padding:10px 22px;line-height:1.2;height:auto;min-height:0;box-sizing:border-box;border:1px solid #dce9f1;border-radius:14px;background:#f7fbfd;color:#17364e;text-decoration:none;font-size:15px;font-weight:bold;white-space:normal;word-break:break-word;"
				>
					<?php echo htmlspecialchars($student_side_link['label'], ENT_QUOTES, 'UTF-8'); ?>
				</a>
			</li>
		<?php } ?>
	</ul>
	
</div>
<div id="sidedate">
		<div class="student-side-menu-title">Calendar</div>
		<?php require("../date.php"); ?>
	</div>
