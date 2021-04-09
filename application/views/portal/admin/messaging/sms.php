<?php
xform_open('api/messaging/custom_sms', xform_attrs());
	xform_notice();
	xform_input('controlled', 'hidden', xget('controlled'));
	xform_input('sms_type', 'hidden', xget('sms_type'));
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 6); ?>">
			<?php data_show_grid('Rate Per Page', SMS_RATE); ?>
		</div>
		<div class="<?php echo grid_col(12, '', 6); ?>">
			<?php data_show_grid('Total Units Remaining', $row->sms_units); ?>
		</div>
	</div>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 6); ?>">
			<?php
			$attrs = ['rows' => 10, 'help' => 'Separate by comma, space or new line e.g. 2347010000001, 2347010000002, etc'];
			$extra = (xget('static') == 1) ? array_merge($attrs, ['readonly' => '']) : $attrs; 
			xform_group_list('Numbers', 'numbers', 'textarea', $numbers, true, $extra); ?>
		</div>
		<div class="<?php echo grid_col(12, '', 6); ?>">
			<?php 
			$attrs = ['rows' => 10, 'help' => '1 page is 160 characters long'];
			$extra = (xget('static') == 1) ? array_merge($attrs, ['readonly' => '']) : $attrs;
			xform_group_list('Message', 'message', 'textarea', '', true, $extra); ?>
		</div>
	</div>
	<?php
xform_close();