<div class="row m-b-30">
	<div class="<?php echo grid_col(12, '', '4?4'); ?>">
		<div class="text-center">
			<img src="<?php echo base_url($row->avatar); ?>" alt="<?php echo $row->full_name; ?>'s Photo" width=150 height=150 style="border-radius: 5px; border: solid 2px #ccc"/>
		</div>
	</div>
</div>
<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('First Name', $row->first_name);
		data_show_grid('Last Name', $row->last_name);
		data_show_grid('Other Name', $row->other_name);
		data_show_grid('Short Display Name', $row->display_name_short);
		data_show_grid('Full Display Name', $row->display_name_full);
		data_show_grid('Sex', $row->gender);
		data_show_grid('Date of Birth', x_date($row->dob));
		data_show_grid('Age', $row->age);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<?php 
		data_show_grid('Office Sought', $row->office);
		data_show_grid('Email', $row->email);
		data_show_grid('Phone', $row->phone);
		data_show_grid('Address', $row->address);
		data_show_grid('Facebook Handle', $row->sm_facebook);
		data_show_grid('Twitter Handle', $row->sm_twitter);
		data_show_grid('Instagram Handle', $row->sm_instagram);
		?>
	</div>
</div>