<?php
xform_open('api/departments/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
			xform_group_list('Name', 'name', 'text', adit_value($row, 'name'), true, ['class' => 'to_clear']);
            xform_group_list('Order', 'order', 'number', adit_value($row, 'order', $next_order ?? ''), true);
			xform_group_list('HOD', 'hod_id', 'select', adit_value($row, 'hod_id'), false, 
            	['options' => $users, 'text_col' => 'full_name', 'blank' => true, 'help' => 'Only Admins can be made HOD of a department']
            ); 
			?>
		</div>
	</div>
	<?php
xform_close();