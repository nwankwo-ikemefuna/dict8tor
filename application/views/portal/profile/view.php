<div class="row m-b-30">
	<div class="<?php echo grid_col(12, '', '4?4'); ?>">
		<div class="text-center">
			<img src="<?php echo base_url($this->session->user_avatar); ?>" alt="My Passport" width=150 height=150 style="border-radius: 5px; border: solid 2px #ccc"/>
		</div>
	</div>
</div>
<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('First Name', $this->session->user_first_name);
		data_show_grid('Last Name', $this->session->user_last_name);
		data_show_grid('Other Name', $this->session->user_other_name);
		data_show_grid('Sex ', $this->session->user_gender);
		data_show_grid('Country', $this->session->user_country_name);
		data_show_grid('State', $this->session->user_state_name);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<?php
		data_show_grid('Email', $this->session->user_email);
		data_show_grid('Phone', $this->session->user_phone);
		data_show_grid('Date of Birth', x_date($this->session->user_dob)); 
		data_show_grid('Phone', $this->session->user_phone);
		?>
	</div>
</div>