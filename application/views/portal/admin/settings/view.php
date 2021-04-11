<div class="row">
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Address', $row->address);
		data_show_grid('Phone Number', $row->phone);
		data_show_grid('Email Address', $row->email);
		?>
	</div>
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Active Phase', $row->phase);
		data_show_grid('Default Language', ucfirst(DEFAULT_LANGUAGE));
		?>
	</div>
</div>

<div class="row m-t-30">
	<?php 
	$images_arr = [
		'logo' => 'Site Logo', 
		'logo_portal' => 'Portal Logo'
	];
	foreach ($images_arr as $key => $title) { ?>
		<div class="<?php echo grid_col(12, 4); ?>">
			<?php echo portal_image_widget('uploads/pix/logo/'.$row->$key, $title); ?>
		</div>
		<?php
	} ?>
</div>