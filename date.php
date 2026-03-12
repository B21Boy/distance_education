<?php
$calendar_now = new DateTimeImmutable();
$calendar_first_day = $calendar_now->modify('first day of this month')->setTime(0, 0);
$calendar_days_in_month = (int) $calendar_first_day->format('t');
$calendar_start_weekday = (int) $calendar_first_day->format('w');
$calendar_month_label = $calendar_first_day->format('F Y');
$calendar_today = $calendar_now->format('Y-m-d');
$calendar_clock_id = 'date_time_' . uniqid();
$calendar_weekdays = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
$calendar_weeks = array();
$calendar_day = 1;

while ($calendar_day <= $calendar_days_in_month) {
	$week = array();
	for ($weekday = 0; $weekday < 7; $weekday++) {
		$is_before_start = count($calendar_weeks) === 0 && $weekday < $calendar_start_weekday;
		if ($is_before_start || $calendar_day > $calendar_days_in_month) {
			$week[] = null;
			continue;
		}

		$current_date = $calendar_first_day->setDate(
			(int) $calendar_first_day->format('Y'),
			(int) $calendar_first_day->format('m'),
			$calendar_day
		);

		$week[] = array(
			'day' => $calendar_day,
			'is_today' => $current_date->format('Y-m-d') === $calendar_today
		);
		$calendar_day++;
	}
	$calendar_weeks[] = $week;
}
?>
<div class="calendar-widget">
	<p class="calendar-clock">
		<span id="<?php echo htmlspecialchars($calendar_clock_id, ENT_QUOTES, 'UTF-8'); ?>"></span>
	</p>
	<script type="text/javascript">
		if (typeof date_time === 'function') {
			date_time('<?php echo htmlspecialchars($calendar_clock_id, ENT_QUOTES, 'UTF-8'); ?>');
		}
	</script>

	<table class="calendar-table" aria-label="Calendar">
		<caption><?php echo htmlspecialchars($calendar_month_label, ENT_QUOTES, 'UTF-8'); ?></caption>
		<thead>
			<tr>
				<?php foreach ($calendar_weekdays as $weekday_label) { ?>
					<th scope="col"><?php echo htmlspecialchars($weekday_label, ENT_QUOTES, 'UTF-8'); ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($calendar_weeks as $week) { ?>
				<tr>
					<?php foreach ($week as $day_cell) { ?>
						<?php if ($day_cell === null) { ?>
							<td class="is-empty">&nbsp;</td>
						<?php } else { ?>
							<td class="<?php echo $day_cell['is_today'] ? 'is-today' : ''; ?>">
								<?php echo htmlspecialchars((string) $day_cell['day'], ENT_QUOTES, 'UTF-8'); ?>
							</td>
						<?php } ?>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
