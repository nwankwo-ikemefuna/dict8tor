<?php
xform_open('api/assessment_groups/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
			xform_input('session', 'hidden', $session);
			xform_input('semester', 'hidden', $semester);
			xform_group_list('Title', 'title', 'text', adit_value($row, 'title'), true, ['class' => 'to_clear', 'placeholder' => 'e.g. Mid-Semester Quiz, Examination, etc']);
			xform_group_list('Department', 'dept_id', 'select', adit_value($row, 'dept_id'), false, 
            	['options' => $this->session->_departments, 'text_col' => 'name', 'blank' => true]
            ); 
            ?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php 
			xform_group_list('Notes', 'notes', 'textarea', adit_value($row, 'notes', '', true), false, ['class' => 'to_clear']);
			?>
		</div>
	</div>
	<?php
xform_close();