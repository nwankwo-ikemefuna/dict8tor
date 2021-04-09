<?php
xform_open('api/employees/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
				xform_input('id', 'hidden', $row->id);
            }
			xform_group_list('First Name', 'first_name', 'text', adit_value($row, 'first_name'), true, ['class' => 'to_clear']);
			xform_group_list('Last Name', 'last_name', 'text', adit_value($row, 'last_name'), true, ['class' => 'to_clear']);
			xform_group_list('Other Name', 'other_name', 'text', adit_value($row, 'other_name'), false, ['class' => 'to_clear m-b-10']);
			xform_check('Male', 'sex', 'radio', 'sex_male', SEX_MALE, ($page == "edit" && $row->sex == SEX_MALE), true, true);
			xform_check('Female', 'sex', 'radio', 'sex_female', SEX_FEMALE, ($page == "edit" && $row->sex == SEX_FEMALE), true, true);
			xform_group_list('Usergroup', 'usergroup', 'select', adit_value($row, 'usergroup'), true, 
				['options' => [ADMIN => 'Admin'], 'blank' => true]
			); 
			xform_group_list('Roles', 'permissions[]', 'select', '', false, 
				['options' => $roles, 'text_col' => 'name', 'blank' => true, 'selected' => json_encode(split_us(adit_value($row, 'permissions'))), 'extra' => ['class' => 'select_mult', 'multiple' => '']]
			);
			xform_group_html_datepicker_list('Date Of Birth', 'dob', 'date', adit_value($row, 'dob', date('Y-m-d')), false, false);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_list('Email', 'email', 'email', adit_value($row, 'email'), true, ['class' => 'to_clear']); 
			xform_group_list('Phone', 'phone', 'text', adit_value($row, 'phone'), true, ['class' => 'to_clear', 'help' => 'Include country code e.g. 2340701000001']); 
			if ($page == 'add') { 
				xform_group_list('Default Password', 'password', 'password', '', true, ['class' => 'to_clear']); 
				xform_group_list('Confirm Default Password', 'c_password', 'password', '', true, ['class' => 'to_clear']); 
            }
			xform_check('Active', 'active', 'checkbox', 'active', 1, ($page == 'edit' && $row->active == 1), false, false, ['gclass' => 'mt-2']);
			xform_group_list('Passport', 'photo', 'file', '', false, ['help' => 'Allowed types: jpg, jpeg, png, Max 100KB. <br />Ideal dimension: 150x150', 'current_file' => adit_value($row, 'avatar')]);
			?>
		</div>
	</div>
	<?php
xform_close();