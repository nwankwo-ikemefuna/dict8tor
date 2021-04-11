<?php
$languages = get_site_languages();
$is_view = ($page == 'view');
$is_view_edit = (in_array($page, ['view', 'edit']));

xform_open('api/timelines/'.$page, xform_attrs());
	xform_notice();
	if ($page == 'edit') { 
		xform_input('id', 'hidden', $row->id);
		xform_input('candidate_type', 'hidden', $row->candidate_type);
	} else {
		xform_input('candidate_type', 'hidden', xget('type'));
	}
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php
			if ($is_view) {
				data_show_grid('Order', $row->order); 
			} else {
				xform_group_grid('Order', 'order', 'number', adit_value($row, 'order', $next_order ?? ''), true); 
			} ?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			if ($is_view) {
				data_show_grid('Published', ['No', 'Yes'][$row->published]);
			} else { ?>
				<div class="m-t-10">
					<?php xform_check('Published', 'published', 'checkbox', 'published', 1, ($row && $row->published == 1)); ?>
				</div>
				<?php
			} ?>
		</div>
	</div>
	<div class="row">
		<div class="<?php echo grid_col(12); ?>">
			<?php 
			foreach ($language_columns as $key => $arr) { ?>
				<fieldset class="scheduler-border">
					<legend class="scheduler-border"><?php echo $arr['title']; ?></legend>
					<div class="row">
						<?php
						foreach ($languages as $lang) { 
							$input_field = "{$key}_{$lang['key']}";
							$input_attrs = ['class' => 'to_clear'];
							if ($arr['input'] == 'textarea') {
								$input_attrs['rows'] = $arr['rows'];
							}
							?>
							<div class="<?php echo grid_col(12, '', floor(12/count($languages))); ?>">
								<?php 
								if ($is_view) {
									if ($key == 'content') {
										data_show_list($lang['title'], $row->$input_field, '', 'bordered_data');
									} else {
										data_show_grid($lang['title'], $row->$input_field);
									}
								} else {
									xform_group_list($lang['title'], $input_field, $arr['input'], adit_value($row, $input_field, '', true), true, $input_attrs); 
								} ?>
							</div>
							<?php
						} ?>
					</div>
				</fieldset>
				<?php 
			} ?>
		</div>
	</div>
	<div class="row">
		<div class="<?php echo grid_col(12, 6, 4); ?>">
			<?php
			if ($is_view_edit) {
				echo portal_image_widget('uploads/pix/timelines/'.$row->photo, 'Photo');
			}
			if (!$is_view) {
				xform_input('photo', 'file', '', ($page != 'edit'), ['help' => "Allowed types: png|jpg, Max 300KB. <br />Ideal dimension: 448x350"]);
			}
			?>
		</div>
	</div>
	<?php
xform_close();