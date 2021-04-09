<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('Title', $row->title);
		data_show_grid('Department', $row->department);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<?php 
		data_show_grid('Total Assessments', $row->assessment_count);
		?>
	</div>
</div>