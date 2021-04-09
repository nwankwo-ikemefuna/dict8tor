<div class="row m-b-30">
	<div class="<?php echo grid_col(12, '', '4?4'); ?>">
		<div class="text-center">
			<img src="<?php echo base_url($row->avatar); ?>" alt="<?php echo $row->full_name; ?>'s Passport" width=150 height=150 style="border-radius: 5px; border: solid 2px #ccc"/>
			<p class="text-bold"><?php echo $row->username; ?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('ID', $row->id);
		data_show_grid('First Name', $row->first_name);
		data_show_grid('Last Name', $row->last_name);
		data_show_grid('Other Name', $row->other_name);
		data_show_grid('Sex', $row->gender);
		data_show_grid('Department', $row->department);
		data_show_grid('Class', $row->class);
		data_show_grid('Country', $row->country_name);
		data_show_grid('State', $row->state_name);
		data_show_grid('Email', $row->email);
		data_show_grid('Phone', $row->phone);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<?php 
		data_show_grid('Date of Birth', x_date($row->dob));
		data_show_grid('Age', $row->age);
		data_show_grid('UTME Number', $row->utme_no);
		data_show_grid('UTME Score', $row->utme_score);
		data_show_grid('Programme Status', STD_STATUSES[$row->status]);
		data_show_grid('Account Status', ACC_STATUSES_STYLED[$row->active]);
		data_show_grid('Sent Activation SMS', $row->sent_activation_sms_text);
		data_show_grid('Using Default Password', $row->using_def_pass);
		data_show_grid('Password Reset Code', $row->password_reset_code);
		data_show_grid('Last Password Reset', x_date($row->last_password_reset));
		?>
	</div>
</div>