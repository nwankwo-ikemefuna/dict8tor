<?php
xform_open('api/settings/active_session', xform_attrs('', 'redirect', 'portal'));
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			xform_group_list('Current Session', 'session', 'select', $this->session->school_session, false, 
				['options' => school_sessions(), 'blank' => true]
			);
			xform_group_list('Current Semester', 'semester', 'select', $this->session->school_semester, false, 
				['options' => ['1st', '2nd'], 'blank' => true]
			); ?>
		</div>
	</div>
	<?php
xform_close();