<style>
/* Scoped sidebar CSS to ensure the sidemenu fits its grid column */
#sidebar1 { width: 100%; max-width: 100%; box-sizing: border-box; overflow: auto; padding: 6px; }
#sidebar1 ul { list-style: none; margin: 0 0 20px 0; padding: 0; }
#sidebar1 li { margin: 6px 0; }
#sidebar1 img, #sidebar1 table, #sidebar1 .calendarShell, #sidebar1 .sidedate-widget { max-width: 100%; width: auto !important; height: auto; box-sizing: border-box; }
#sidebar1 .sidedate-widget table { width: 100%; }
#sidebar1 .sidedate-widget { margin-top: 6px; }
#sidebar1 .sidedate a { display: block; font-weight: bold; color: #336699; margin-bottom: 4px; }
</style>

<div id="sidebar1">
	<div class="sidebar-panel-title">side menu</div>
	<ul>
	
		<li><a href="logfile.php">View Log File</a></li>
		<li><a href="viewstudentaccount.php">Print Student Account</a></li>
		<li><a href="viewbuser.php">View Blocked user</a></li>
		<li><a href="backupdb.php">Take Backup</a></li>
		<li><a href="restoredb.php">Restore Backup</a></li>
	</ul>
	
</div>
<div class="sidebar-panel">
		<div class="sidebar-panel-title">Calendar</div>
		<div class="sidebar-panel-body">
			<?php require("../date.php"); ?>
		</div>
	</div>
