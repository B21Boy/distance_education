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
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!defined('CDEOFFICER_FACEBOX_ASSETS_LOADED')) {
	define('CDEOFFICER_FACEBOX_ASSETS_LOADED', true);
	?>
	<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="src/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[rel*=facebox]').facebox({
				loadingImage: 'src/loading.gif',
				closeImage: 'src/closelabel.png'
			});
		});
	</script>
	<?php
}

if (!defined('CDEOFFICER_MENU_DROPDOWN_ASSETS_LOADED')) {
	define('CDEOFFICER_MENU_DROPDOWN_ASSETS_LOADED', true);
	?>
	<style>
		#menubar1,
		#menubar1 ul,
		#menubar1 li {
			overflow: visible !important;
		}

		#menubar1 li.menu-dropdown {
			position: relative !important;
			padding-bottom: 4px !important;
		}

		#menubar1 .menu-dropdown-toggle {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			margin: 0 !important;
			padding: 10px 18px !important;
			border: 0;
			border-radius: 999px;
			background: rgba(255, 255, 255, 0.08);
			color: #f7fbff !important;
			font-family: Georgia, "Times New Roman", serif;
			font-size: 15px !important;
			font-weight: bold;
			line-height: 1.2 !important;
			cursor: pointer;
			transition: background-color 0.18s ease, transform 0.18s ease, color 0.18s ease;
		}

		#menubar1 .menu-dropdown-toggle::after {
			content: "▾";
			display: inline-block;
			margin-left: 8px;
			font-size: 11px;
		}

		#menubar1 li.menu-dropdown:hover > .menu-dropdown-toggle,
		#menubar1 li.menu-dropdown:focus-within > .menu-dropdown-toggle,
		#menubar1 li.menu-dropdown.is-open > .menu-dropdown-toggle,
		#menubar1 .menu-dropdown-toggle:hover,
		#menubar1 .menu-dropdown-toggle:focus,
		#menubar1 .menu-dropdown-toggle.active {
			background: #ffffff !important;
			color: #0f4f79 !important;
			transform: translateY(-1px);
		}

		#menubar1 li.menu-dropdown::after {
			content: "";
			position: absolute;
			top: 100%;
			left: 0;
			width: 100%;
			height: 10px;
		}

		#menubar1 .menu-dropdown-menu {
			position: absolute !important;
			top: calc(100% + 4px);
			left: 50%;
			display: grid !important;
			gap: 8px;
			min-width: 260px;
			margin: 0 !important;
			padding: 14px !important;
			list-style: none;
			background: rgba(255, 255, 255, 0.98);
			border: 1px solid #d8e5f2;
			border-radius: 18px;
			box-shadow: 0 20px 40px rgba(15, 51, 84, 0.18);
			transform: translate(-50%, 8px);
			opacity: 0;
			visibility: hidden;
			pointer-events: none;
			transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
			z-index: 999;
		}

		#menubar1 .menu-dropdown-menu::before {
			content: "";
			position: absolute;
			top: -7px;
			left: 50%;
			width: 14px;
			height: 14px;
			background: rgba(255, 255, 255, 0.98);
			border-top: 1px solid #d8e5f2;
			border-left: 1px solid #d8e5f2;
			transform: translateX(-50%) rotate(45deg);
		}

		#menubar1 li.menu-dropdown:hover > .menu-dropdown-menu,
		#menubar1 li.menu-dropdown:focus-within > .menu-dropdown-menu,
		#menubar1 li.menu-dropdown.is-open > .menu-dropdown-menu {
			transform: translate(-50%, 0);
			opacity: 1;
			visibility: visible;
			pointer-events: auto;
		}

		#menubar1 .menu-dropdown-menu li {
			float: none !important;
			width: 100%;
			padding: 0 !important;
		}

		#menubar1 .menu-dropdown-menu a {
			display: block !important;
			width: 100%;
			height: auto !important;
			margin: 0 !important;
			padding: 12px 14px !important;
			line-height: 1.3 !important;
			border-radius: 12px;
			background: #f4f8fd !important;
			color: #12395f !important;
			white-space: normal;
			text-decoration: none;
		}

		#menubar1 .menu-dropdown-menu a:hover,
		#menubar1 .menu-dropdown-menu a:focus,
		#menubar1 .menu-dropdown-menu a.active {
			background: #dbeafb !important;
			color: #0f4f79 !important;
			transform: none;
		}

		@media (max-width: 760px) {
			#menubar1 li.menu-dropdown {
				width: 100%;
			}

			#menubar1 .menu-dropdown-toggle {
				width: 100%;
			}

			#menubar1 .menu-dropdown-menu {
				position: static !important;
				left: auto;
				width: 100%;
				min-width: 0;
				margin-top: 8px !important;
				transform: none;
				opacity: 1;
				visibility: visible;
				pointer-events: auto;
			}

			#menubar1 li.menu-dropdown::after,
			#menubar1 .menu-dropdown-menu::before {
				display: none;
			}
		}
	</style>
	<?php
}

$count = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='tutorial'");
$couni = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='iexam'");
$counmea = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexamassign'");
$counma = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='massignment'");
$counme = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='mexam'");
$counpe = cdeofficer_safe_count($conn, "select * from payment_table where unread='yes' and status='no' and type='pexam'");

$total=$count+$couni+$counmea+$counma+$counme+$counpe;
?>
<?php
$user_id = isset($_SESSION['suid']) ? mysqli_real_escape_string($conn, (string) $_SESSION['suid']) : '';
$message_count = 0;
if ($user_id !== '') {
	$sql="SELECT * FROM message WHERE M_reciever='$user_id' and status='no' ORDER BY date_sended DESC";
	$result = mysqli_query($conn, $sql);
	if ($result instanceof mysqli_result) {
		$message_count = mysqli_num_rows($result);
		mysqli_free_result($result);
	}
}

$current_page = basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
$menu_items = array(
	// array(
	// 	'href' => 'cdeofficerpage.php?view=worked_fee',
	// 	'label' => 'Calculate Employee Worked Fee[' . $total . ']',
	// 	'class' => $total >= 1 ? 'has-alert' : ''
	// ),
	array('href' => 'preparemoduleschedule.php', 'label' => 'Post module Preparation schedule'),
	array(
		'label' => 'Add Programs',
		'type' => 'dropdown',
		'children' => array(
			array('href' => 'managecollage.php', 'label' => 'Add College'),
			array('href' => 'managedept.php', 'label' => 'Add Department')
		)
	),
	array(
		'label' => 'Post Announcement',
		'type' => 'dropdown',
		'children' => array(
			array('href' => 'updateposti.php', 'label' => 'Post Updated Information'),
			array('href' => 'updatepost.php', 'label' => 'Post Registration Date'),
			array('href' => 'updateposta.php', 'label' => 'Post Application Date')
		)
	),
	array(
		'href' => 'usernotification.php',
		'label' => 'Notification[' . $message_count . ']',
		'class' => $message_count >= 1 ? 'has-alert' : ''
	),
	array(
		'href' => 'verfication.php',
		'label' => 'Document Verfication[' . $message_count . ']',
		'class' => $message_count >= 1 ? 'has-alert' : ''
	),
	array('href' => '../logout.php', 'label' => 'Log out')
);
?>
<nav id="menubar1" aria-label="CDE officer navigation">
	<ul>
		<?php foreach ($menu_items as $item) {
			if (isset($item['type']) && $item['type'] === 'dropdown') {
				$child_active = false;
				foreach ($item['children'] as $child) {
					if ($current_page === basename($child['href'])) {
						$child_active = true;
						break;
					}
				}
				?>
				<li class="menu-dropdown">
					<button type="button" class="menu-dropdown-toggle<?php echo $child_active ? ' active' : ''; ?>" aria-expanded="<?php echo $child_active ? 'true' : 'false'; ?>">
						<?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
					</button>
					<ul class="menu-dropdown-menu">
						<?php foreach ($item['children'] as $child) {
							$child_class = $current_page === basename($child['href']) ? 'active' : '';
							?>
							<li>
								<a href="<?php echo htmlspecialchars($child['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $child_class !== '' ? ' class="' . $child_class . '"' : ''; ?>>
									<?php echo htmlspecialchars($child['label'], ENT_QUOTES, 'UTF-8'); ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>
				<?php
				continue;
			}

			$item_class = isset($item['class']) ? trim($item['class']) : '';
			if ($current_page === basename($item['href'])) {
				$item_class = trim($item_class . ' active');
			}
			?>
			<li>
				<a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $item_class !== '' ? ' class="' . htmlspecialchars($item_class, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
					<?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</nav>
<script>
(function () {
	var dropdowns = document.querySelectorAll('#menubar1 .menu-dropdown');
	if (!dropdowns.length) {
		return;
	}

	function setOpenState(dropdown, isOpen) {
		dropdown.classList.toggle('is-open', isOpen);
		var toggle = dropdown.querySelector('.menu-dropdown-toggle');
		if (toggle) {
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		}
	}

	dropdowns.forEach(function (dropdown) {
		var toggle = dropdown.querySelector('.menu-dropdown-toggle');
		var menu = dropdown.querySelector('.menu-dropdown-menu');
		if (!toggle) {
			return;
		}

		toggle.addEventListener('mouseenter', function () {
			setOpenState(dropdown, true);
		});

		toggle.addEventListener('focus', function () {
			setOpenState(dropdown, true);
		});

		if (menu) {
			menu.addEventListener('mouseenter', function () {
				setOpenState(dropdown, true);
			});
		}

		dropdown.addEventListener('mouseenter', function () {
			setOpenState(dropdown, true);
		});

		dropdown.addEventListener('mouseleave', function () {
			setOpenState(dropdown, false);
		});

		toggle.addEventListener('click', function () {
			var willOpen = !dropdown.classList.contains('is-open');
			dropdowns.forEach(function (item) {
				if (item !== dropdown) {
					setOpenState(item, false);
				}
			});
			setOpenState(dropdown, willOpen);
		});

		dropdown.addEventListener('focusout', function (event) {
			if (!dropdown.contains(event.relatedTarget)) {
				setOpenState(dropdown, false);
			}
		});
	});

	document.addEventListener('click', function (event) {
		dropdowns.forEach(function (dropdown) {
			if (!dropdown.contains(event.target)) {
				setOpenState(dropdown, false);
			}
		});
	});
})();
</script>
