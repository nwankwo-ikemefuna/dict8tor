<?php
xform_open('api/students/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', '6?3'); ?>">
			<?php
			xform_group_grid('Passport', 'photo', 'file', '', false, ['help' => 'Allowed types: jpg, jpeg, png, Max 100KB. <br />Ideal dimension: 150x150', 'current_file' => adit_value($row, 'avatar')]);
			xform_group_grid('Registration ID', 'username', 'text', adit_value($row, 'username'), true, ['class' => 'to_clear']);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', 5); ?> class_dept_wrapper state_country_wrapper">
			<?php 
			if ($page == 'edit') { 
				xform_input('id', 'hidden', $row->id);
            }
			xform_group_list('First Name', 'first_name', 'text', adit_value($row, 'first_name'), true, ['class' => 'to_clear']);
			xform_group_list('Last Name', 'last_name', 'text', adit_value($row, 'last_name'), true, ['class' => 'to_clear']);
			xform_group_list('Other Name', 'other_name', 'text', adit_value($row, 'other_name'), false, ['class' => 'to_clear m-b-10']);
			xform_check('Male', 'sex', 'radio', 'sex_male', SEX_MALE, ($page == "edit" && $row->sex == SEX_MALE), true, true);
			xform_check('Female', 'sex', 'radio', 'sex_female', SEX_FEMALE, ($page == "edit" && $row->sex == SEX_FEMALE), true, true);
			xform_group_list('Country', 'country', 'select', adit_value($row, 'country'), false, 
				['options' => $this->session->_countries, 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_country_id']]
			); 
			xform_group_list('State', 'state', 'select', adit_value($row, 'state'), false, 
				['options' => $states ?? [], 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_state_id']]
			);
			xform_group_list('Department', 'dept_id', 'select', adit_value($row, 'dept_id'), true, 
				['options' => $this->session->_departments, 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_dept_id']]
			); 
			xform_group_list('Class', 'class_id', 'select', adit_value($row, 'class_id'), true, 
				['options' => $classes ?? [], 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_class_id']]
			); ?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_html_datepicker_list('Date Of Birth', 'dob', 'date', adit_value($row, 'dob', date('Y-m-d')), false, false);
			xform_group_list('Email', 'email', 'email', adit_value($row, 'email'), false, ['class' => 'to_clear']); 
			xform_group_list('Phone', 'phone', 'text', adit_value($row, 'phone'), true, ['class' => 'to_clear', 'help' => 'Include country code e.g. 2340701000001']); 
			xform_group_list('UTME Number', 'utme_no', 'text', adit_value($row, 'utme_no'), false, ['class' => 'to_clear']); 
			xform_group_list('UTME Score', 'utme_score', 'number', adit_value($row, 'utme_score'), false, ['class' => 'to_clear']); 
			xform_group_list('Programme Status', 'status', 'select', adit_value($row, 'status', xget('status')), true, 
				['options' => STD_STATUSES, 'blank' => false]
			);
			if ($page == 'edit') {
				xform_check('Active Account', 'active', 'checkbox', 'active', 1, ($row->active == 1), false, false, ['gclass' => 'mt-2']); 
			}
			if ($page == 'edit') {
				xform_text('If the box below is checked and student has not received account activation SMS, uncheck the box and resend the SMS');
				xform_check('Sent Activation SMS', 'sent_activation_sms', 'checkbox', 'sent_activation_sms', 1, ($row->sent_activation_sms == 1), false, false, ['class' => 'to_clear']); 
			} ?>
		</div>
	</div>
	<?php
xform_close();