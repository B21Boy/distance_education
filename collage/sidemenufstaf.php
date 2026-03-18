<?php
if (!isset($conn)) {
	require_once("../connection.php");
}
?>
<div id="sidebar1">
<ul>
<?php
 $id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$cc = '';
if ($id !== '') {
	$s = mysqli_query($conn, "select*from user where UID='$id'");
	if ($s instanceof mysqli_result) {
		$rr = mysqli_fetch_assoc($s);
		if ($rr) {
			$cc = $rr['c_code'];
		}
		mysqli_free_result($s);
	}
}
?>
	<div id="sidedate">
	<li><a class="active" href="#.php"> Calendar</a></li>
	 <?php
	 require("../date.php");
	 ?>
	 </div>
</ul>
</div>
