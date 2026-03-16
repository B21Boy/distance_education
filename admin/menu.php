<style>
/* Modern responsive navigation: uses flexbox and CSS-only dropdowns */
/* Basic reset for nav */
.primary-nav {
	display: flex;
	align-items: center;
	gap: 1rem;
	background: #336699;
	padding: 0.5rem 1rem;
	flex-wrap: wrap;
}
.primary-nav .brand { color: #fff; font-weight: 700; margin-right: 1rem; }
.primary-nav ul { list-style: none; margin: 0; padding: 0; display: flex; gap: 0.5rem; align-items:center; justify-content: center; }
.primary-nav li { position: relative; }
.primary-nav a { color: #fff; text-decoration: none; padding: 0.6rem 0.9rem; display: block; border-radius:4px; transition: background .15s ease, color .15s ease; }
/* Visible hover/focus effect */
.primary-nav a:hover, .primary-nav a:focus { background: rgba(255,255,255,0.08); color:#fff; }

/* Dropdown (CSS only) */
.primary-nav li .dropdown { position: absolute; left: 0; top: 100%; min-width: 160px; background: #fff; color:#000; border-radius:4px; box-shadow:0 6px 12px rgba(0,0,0,.12); display:none; z-index:50; }
.primary-nav li:hover > .dropdown, .primary-nav li:focus-within > .dropdown { display:block; }
.primary-nav .dropdown a { color:#000; padding:0.5rem 1rem; display:block; }
.primary-nav .dropdown a:hover { background:#f2f2f2; }
.primary-nav .badge { background: #d0eb3d; color: #000; font-weight:700; padding: 0.15rem .5rem; border-radius: 12px; margin-left: .4rem; font-size: .9rem; }

/* Responsive collapse: simple wrap behaviour for small screens */
@media (max-width: 700px) {
	.primary-nav { gap: .5rem; }
	.primary-nav ul { flex-wrap: wrap; }
}
</style>

<nav class="primary-nav" aria-label="Admin navigation">
	<div class="brand">Admin</div>
	<ul>
		<li>
			<a href="#" aria-haspopup="true" aria-expanded="false">Manage Account ▾</a>
			<div class="dropdown" role="menu">
				<a href="adduser.php">Register User</a>
				<a href="addaccount.php">Create Account</a>
				<a href="addaccountb.php">Block Account</a>
			</div>
		</li>

		<?php
		// dynamic counters
		$query = mysqli_query($conn, "SELECT * FROM student WHERE unread='no' ORDER BY Department ASC") or die(mysqli_error($conn));
		$coun = mysqli_num_rows($query);

		$query1 = mysqli_query($conn, "SELECT * FROM entrance_exam WHERE status='unsatisfactory' AND (account=' ' OR account='seen')") or die(mysqli_error($conn));
		$coun1 = mysqli_num_rows($query1);

		if ($coun >= 1) {
				echo '<li><a href="studentlist.php">New Request For Account Creation <span class="badge">' . $coun . '</span></a></li>';
		} elseif ($coun1 >= 1) {
				echo '<li><a href="studentlist.php">Request For Block Account <span class="badge">' . $coun1 . '</span></a></li>';
		} else {
				echo '<li><a href="studentlist.php">Request For Account</a></li>';
		}
		?>

		<li>
			<a href="viewfeedback.php">View feedback (
				<?php
					$count_item = mysqli_query($conn, "SELECT * FROM feed_back") or die(mysqli_error($conn));
					$count = mysqli_num_rows($count_item);
					echo "<span class='badge'>" . ($count) . "</span>";
				?>)
			</a>
		</li>

		<li><a href="../logout.php">Log out</a></li>
	</ul>
</nav>