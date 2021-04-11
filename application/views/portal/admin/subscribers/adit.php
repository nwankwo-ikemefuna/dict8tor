<?php
xform_open('api/subscribers/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
				xform_input('id', 'hidden', $row->id);
            }
			xform_group_list('Email', 'email', 'email', adit_value($row, 'email'), true, ['class' => 'to_clear']); 
			xform_group_list('Phone', 'phone', 'text', adit_value($row, 'phone'), true, ['class' => 'to_clear', 'help' => 'Include country code e.g. 2340701000001']); 
			?>
		</div>
	</div>
	<?php
xform_close();