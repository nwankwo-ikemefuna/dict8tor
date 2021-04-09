<?php
xform_open('api/user/reset_pass', xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			xform_group_list('Current Password', 'curr_password', 'password', '', true);
			xform_group_list('New Password', 'password', 'password', '', true);
			xform_group_list('Confirm New Password', 'c_password', 'password', '', true);
			?>
		</div>
	</div>
	<?php
xform_close();