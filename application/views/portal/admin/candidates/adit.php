<?php
xform_open('api/candidates/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
				xform_input('type', 'hidden', $row->type);
            }
			xform_group_list('First Name', 'first_name', 'text', adit_value($row, 'first_name'), true, ['class' => 'to_clear']);
			xform_group_list('Last Name', 'last_name', 'text', adit_value($row, 'last_name'), true, ['class' => 'to_clear']);
			xform_group_list('Other Name', 'other_name', 'text', adit_value($row, 'other_name'), false, ['class' => 'to_clear m-b-10']);
			xform_group_list('Short Display Name', 'display_name_short', 'text', adit_value($row, 'display_name_short'), false, ['class' => 'to_clear m-b-10']);
			xform_group_list('Full Display Name', 'display_name_full', 'text', adit_value($row, 'display_name_full'), false, ['class' => 'to_clear m-b-10']);
			xform_check('Male', 'sex', 'radio', 'sex_male', SEX_MALE, ($page == "edit" && $row->sex == SEX_MALE), true, true);
			xform_check('Female', 'sex', 'radio', 'sex_female', SEX_FEMALE, ($page == "edit" && $row->sex == SEX_FEMALE), true, true);
			xform_group_html_datepicker_list('Date Of Birth', 'dob', 'date', adit_value($row, 'dob', date('Y-m-d')), false, false);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_list('Office Sought', 'office', 'text', adit_value($row, 'office'), true, ['class' => 'to_clear']); 
			xform_group_list('Email', 'email', 'email', adit_value($row, 'email'), true, ['class' => 'to_clear']); 
			xform_group_list('Phone', 'phone', 'text', adit_value($row, 'phone'), true, ['class' => 'to_clear', 'help' => 'Include country code e.g. 2340701000001']);
			xform_group_list('Address', 'address', 'textarea', adit_value($row, 'address', '', true), true, ['rows' => 3]);
			xform_group_list('Facebook Handle', 'sm_facebook', 'text', adit_value($row, 'sm_facebook'), true, ['class' => 'to_clear']); 
			xform_group_list('Twitter Handle', 'sm_twitter', 'text', adit_value($row, 'sm_twitter'), true, ['class' => 'to_clear']); 
			xform_group_list('Instagram Handle', 'sm_instagram', 'text', adit_value($row, 'sm_instagram'), true, ['class' => 'to_clear']); 
			?>
		</div>
	</div>
	<?php
xform_close();