<?php
xform_open_multipart('api/settings/edit', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php
			xform_group_list('Email Address', 'email', 'email', $row->email, true);
			xform_group_list('Phone', 'phone', 'number', $row->phone, true);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_list('Active Phase', 'phase', 'select', adit_value($row, 'phase'), true, 
            	['options' => [1, 2], 'blank' => false]
            ); 
			xform_group_list('Address', 'address', 'textarea', $row->address, true, ['rows' => 3]);
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
				<?php 
				echo portal_image_widget('uploads/pix/logo/'.$row->$key, $title);
				xform_input($key, 'file', '', false, ['help' => 'Allowed types: png|svg|jpg, Max 100KB. <br />Ideal dimension: 204x109']);
				?>
			</div>
			<?php
		} ?>
	</div>

	<?php
xform_close();