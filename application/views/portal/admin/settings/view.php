<div class="row">
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Name', $row->name);
		data_show_grid('Short Name', $row->short_name);
		data_show_grid('Motto', $row->tagline);
		?>
	</div>
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php
		data_show_grid('Address', $row->address);
		data_show_grid('Phone Number', $row->phone);
		data_show_grid('Email Address', $row->email);
		?>	
	</div>
</div>