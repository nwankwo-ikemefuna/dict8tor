<?php 
xform_label('Classes offering this course');
if ($page != 'view') {
	xform_check('Select All', '', 'checkbox', 'all_classes', '', false, false, false, ['class' => 'ba_check_all']);
} ?>

<div class="row">
	<?php 
	$classes_offering = ($page != 'add') ? (array) explode(',', $row->classes) : [];
	foreach ($this->session->_departments as $d_row) { 
		//skip rows with zero classes
		if (!$d_row->class_count) continue; 
		?>
		<div class="col-12 col-sm-6 col-md-3 p-b-20">
			<div class="card bg-light mb-3">
				<div class="card-header"><?php echo $d_row->name; ?> Department</div>
				<div class="card-body">
					<?php
					$dept_classes = $this->session->_dept_classes[$d_row->id] ?? [];
					foreach ($dept_classes as $c_row) { 
						$class_id = $c_row->id;
						$class_name = $c_row->name;
						$_id = 'class_'.$d_row->id.'_'.$class_id;
						$_checked = ($page != 'add' && in_array($class_id, $classes_offering));
						$extra = ['class' => 'ba_record'];
						if ($page == 'view') {
							$extra = ['disabled' => 'disabled'];
						}
						xform_check($class_name, "classes[]", 'checkbox', $_id, $class_id, $_checked, false, false, $extra);
					} ?>
				</div>
			</div>
		</div>
		<?php
	} ?>
</div>