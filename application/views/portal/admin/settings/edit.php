<?php
xform_open('api/settings/edit', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			xform_group_list('Name', 'name', 'text', $row->name, true);
			xform_group_list('Short Name', 'short_name', 'text', $row->short_name, true);
			xform_group_list('Motto', 'tagline', 'text', $row->tagline);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php 
			xform_group_list('Address', 'address', 'textarea', $row->address, true, ['rows' => 3]);
			xform_group_list('Email Address', 'email', 'email', $row->email, true);
			xform_group_list('Phone', 'phone', 'number', $row->phone, true);
			?>
		</div>
	</div>
	<?php
xform_close();