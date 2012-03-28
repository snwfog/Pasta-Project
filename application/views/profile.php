<div id="content">
	<p>Hello Charles,</p>
	<p>Credit <?=$total_credit?></p>
	<table id="user_schedule_table">
		<tr>
			<td>Schedule</td>
			<td>Year</td>
			<td>Session</td>
			<td>Option</td>
		</tr>
		<?php foreach($schedules as $index => $detail_schedule_info): ?>
		<tr>
			<td><?=($index+1)?></td>
			<td><?=$detail_schedule_info['year']?></td>
			<td><?=$detail_schedule_info['season']?></td>
			<td>
				<?=anchor(site_url("login"), "View")?> <!-- display the link to the schedule, replace with
				anchor(site_url("schedule/method/$detail_schedule_info['id
				']), "View"); in the final version. -->
				<?=anchor(site_url("completedcourse"), "Drop");?>
				<!-- PLACEHOLDER -->
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>