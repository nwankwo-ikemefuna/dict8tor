<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('Name', $row->name);
		data_show_grid('Department', $row->department);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<?php 
		data_show_grid('Order', $row->order);
		data_show_grid('Total Active Students', $row->active_students);
		?>
	</div>
</div>