<?php
xform_open_multipart('api/settings/edit', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php
			xform_group_list('Email Address', 'email', 'email', $row->email, true);
			xform_group_list('Phone Number', 'phone', 'number', $row->phone, true);
			xform_group_list('Address', 'address', 'textarea', $row->address, true, ['rows' => 3]);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_list('Active Phase', 'phase', 'select', adit_value($row, 'phase'), true, 
            	['options' => [1, 2], 'blank' => false]
            ); 
			xform_check('Show Language Options', 'show_language_options', 'checkbox', 'show_language_options', 1, ($row->show_language_options == 1), false, false, ['gclass' => 'mt-2']);
			?>
		</div>
	</div>

	<div class="row m-t-30">
		<?php
		foreach ($image_columns as $key => $arr) { ?>
			<div class="<?php echo grid_col(12, 6, 4); ?>">
				<?php 
				echo portal_image_widget('uploads/pix/logo/'.$row->$key, $arr['title']);
				xform_input($key, 'file', '', false, ['help' => file_upload_info($arr['ext'], $arr['dimension'], $arr['max'], $arr['unit'], true)]);
				?>
			</div>
			<?php
		} ?>
	</div>

	<?php
xform_close();