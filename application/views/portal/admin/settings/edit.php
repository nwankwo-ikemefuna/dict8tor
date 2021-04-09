<?php
xform_open('api/settings/edit', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			xform_group_list('Name', 'name', 'text', $this->session->school_name, true);
			xform_group_list('Short Name', 'short_name', 'text', $this->session->school_short_name, true);
			xform_group_list('Motto', 'tagline', 'text', $this->session->school_tagline);
			?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php 
			xform_group_list('Address', 'address', 'textarea', $this->session->school_address, true, ['rows' => 3]);
			xform_group_list('Email Address', 'email', 'email', $this->session->school_email, true);
			xform_group_list('Phone', 'phone', 'number', $this->session->school_phone, true);
			?>
		</div>
	</div>
	<?php
xform_close();