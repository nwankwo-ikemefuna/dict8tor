<div class="row">
	<div class="<?php echo grid_col(12, '', 6); ?>">
		<div class="collapsible_section m-b-20">
			<div class="collapse" id="default_pass_section">
				<h5>Default Password Activation</h5>
				<p><em>NB: Students using this method must reset the default password to their own password after first login.</em></p>
				<?php 
				if ($type == 'student') { ?>
					<p>Only this student will be affected.</p>
					<?php 
				} else { ?>
					<p>Number of students to be affected: <?php echo $total_inactive_accounts; ?></p>
					<?php 
				}  
				xform_open('api/students/default_pass_activation', xform_attrs('default_pass_activate_form', 'none', '_void', '', 'status_msg', 1, 'Activating accounts... Please wait'));
					xform_input('type', 'hidden', $type);
					xform_input('id', 'hidden', $id);
					xform_group_grid('Default Password', 'password', 'password', '', true, ['id' => 'password'], ['class' => 'floating-label']);
        			xform_group_grid('Confirm Default Password', 'c_password', 'password', '', true, ['id' => 'c_password'], ['class' => 'floating-label']);
					xform_notice();
					xform_submit('Activate', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
		</div>
	</div>
</div>