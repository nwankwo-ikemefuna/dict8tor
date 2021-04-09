<div class="row">
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Name', $this->session->school_name);
		data_show_grid('Short Name', $this->session->school_short_name);
		data_show_grid('Motto', $this->session->school_tagline);
		data_show_grid('Owner', $this->session->school_owner);	
		?>
	</div>
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php
		data_show_grid('Address', $this->session->school_address);
		data_show_grid('Phone Number', $this->session->school_phone);
		data_show_grid('Email Address', $this->session->school_email);
		data_show_grid('Date Installed', x_date($this->session->school_date_created));
		?>	
	</div>
</div>