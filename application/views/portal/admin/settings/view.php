<div class="row">
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Email Address', $row->email);
		data_show_grid('Phone Number', $row->phone);
		data_show_grid('Address', $row->address);
		?>
	</div>
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Active Phase', $row->phase);
		data_show_grid('Default Language', ucfirst(DEFAULT_LANGUAGE));
		data_show_grid('Show Language Options', ['No', 'Yes'][$row->show_language_options]);
		?>
	</div>
</div>

<div class="row m-t-30">
	<?php 
	foreach ($image_columns as $key => $arr) { ?>
		<div class="<?php echo grid_col(12, 6, 4); ?>">
			<?php echo portal_image_widget('pix/logo/'.$row->$key, $arr['title']); ?>
		</div>
		<?php
	} ?>
</div>