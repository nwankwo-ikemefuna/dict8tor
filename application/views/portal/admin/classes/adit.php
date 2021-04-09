<?php
xform_open('api/classes/'.$page, xform_attrs());
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
			xform_group_list('Department', 'dept_id', 'select', adit_value($row, 'dept_id', xget('dept_id')), false, 
            	['options' => $this->session->_departments, 'text_col' => 'name', 'blank' => true]
            ); ?>
		</div>
	</div>
	<?php
xform_close();