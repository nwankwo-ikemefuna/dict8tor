<?php
xform_open('api/user/edit', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', '6?3'); ?> text-center">
			<img src="<?php echo base_url($this->session->user_avatar); ?>" alt="My Passport" width=150 height=150 style="border-radius: 5px; border: solid 2px #ccc"/>
			<p class="text-bold"><?php echo $this->session->user_username; ?></p>
		</div>
		<div class="<?php echo grid_col(12, '', 5); ?> state_country_wrapper">
			<?php 
			xform_group_list('Country', 'country', 'select', $this->session->user_country, false, 
				['options' => $this->session->_countries, 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_country_id']]
			); 
			xform_group_list('State', 'state', 'select', $this->session->user_state, false, 
				['options' => $states ?? [], 'text_col' => 'name', 'blank' => true, 'extra' => ['class' => 'select_state_id']]
			);
			xform_group_list('Email', 'email', 'email', $this->session->user_email); 
			xform_group_list('Phone', 'phone', 'text', $this->session->user_phone, true, ['help' => 'Include country code e.g. 2340701000001']);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			xform_group_html_datepicker_list('Date Of Birth', 'dob', 'date', $this->session->user_dob, false, false);
			if ($this->session->user_usergroup == STUDENT) {
				xform_group_list('UTME Number', 'utme_no', 'text', $this->session->user_utme_no); 
				xform_group_list('UTME Score', 'utme_score', 'number', $this->session->user_utme_score); 
			}
			?>
		</div>
	</div>
	<?php
xform_close();