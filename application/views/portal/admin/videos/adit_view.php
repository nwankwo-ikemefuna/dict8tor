<?php
$languages = get_site_languages();
$is_view = ($page == 'view');
$is_edit = ($page == 'edit');
$is_view_edit = (in_array($page, ['view', 'edit']));

xform_open('api/videoz/'.$page, xform_attrs());
	xform_notice();
	if ($page == 'edit') { 
		xform_input('id', 'hidden', $row->id);
	} ?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
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
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			if ($is_view) {
				data_show_grid('Date Published', x_date_time($row->date_created));
			} ?>
		</div>
	</div>
	<div class="row">
		<div class="<?php echo grid_col(12); ?>">
			<?php 
			foreach ($language_columns as $key => $arr) { ?>
				<fieldset class="scheduler-border">
					<legend class="scheduler-border"><?php echo ($key == 'content') ? 'Video' : $arr['title']; ?></legend>
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
								if ($is_view_edit) {
									$video_iframe = '<iframe width="100%" height="300px" src="'.youtube_embed_url($row->{'content_'.$lang['key']}).'?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0&amp;" allowfullscreen="true"></iframe>';
								}
								if ($is_view) {
									if ($key == 'content') { 
										data_show_list($lang['title'], $video_iframe);
									} else {
										data_show_grid($lang['title'], $row->$input_field);
									}
								} else {
									xform_group_list($lang['title'], $input_field, $arr['input'], adit_value($row, $input_field, '', true), true, $input_attrs); 
									if ($is_edit && $key == 'content') {
										echo $video_iframe;
									}
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
	<?php
xform_close();