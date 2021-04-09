<?php
xform_open('api/courses/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>" id="courses">
			<?php 
			if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
			xform_group_list('Name', 'name', 'text', adit_value($row, 'name'), true, ['class' => 'to_clear']);
			xform_group_list('Code', 'code', 'text', adit_value($row, 'code'), true, ['class' => 'to_clear', 'max' => 10]);
            xform_group_list('Order', 'order', 'number', adit_value($row, 'order', $next_order ?? ''), true);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php 
			xform_group_list('Department', 'dept_id', 'select', adit_value($row, 'dept_id'), false, 
            	['options' => $this->session->_departments, 'text_col' => 'name', 'blank' => true]
            ); 
            xform_group_list('Lecturer (s)', 'lecturers[]', 'select', '', false, 
				['options' => $lecturers ?? [], 'text_col' => 'full_name', 'blank' => true, 'selected' => json_encode(split_us(adit_value($row, 'lecturers'))), 'help' => 'Select department first', 'extra' => ['class' => 'select_mult', 'multiple' => '']]
			); ?>
		</div>
	</div>

	<?php 
	//classes offering
	require 'classes_offering.php';
xform_close();