<div class="row mb-3">
	<div class="<?php echo grid_col(12, '', 5); ?>">
		<?php data_show_grid('Session', session_slash($session)); ?>
	</div>
	<div class="<?php echo grid_col(12, '', '5?2'); ?>">
		<?php data_show_grid('Semester', $semester); ?>
	</div>
</div>