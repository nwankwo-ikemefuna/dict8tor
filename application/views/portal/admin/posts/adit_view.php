<?php
$languages = get_site_languages();
$is_view = ($page == 'view');
$is_view_edit = (in_array($page, ['view', 'edit']));

xform_open('api/posts/'.$page, xform_attrs());
	xform_notice();
	if ($page == 'edit') { 
		xform_input('id', 'hidden', $row->id);
	} ?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php
			if ($is_view) {
				data_show_grid('Category', $row->category_title); 
				data_show_grid('Slug', $row->slug); 
				data_show_grid('Featured Post', ['No', 'Yes'][$row->featured]);
				data_show_grid('Published', ['No', 'Yes'][$row->published]);
				data_show_grid('Date Published', x_date_time($row->date_created));
			} else {
				xform_group_list('Category', 'category_id', 'select', adit_value($row, 'category_id'), true, 
					['options' => $blog_categories, 'text_col' => 'title', 'blank' => true]
				); ?>
				<div class="m-t-10">
					<?php
					xform_check('Featured Post', 'featured', 'checkbox', 'featured', 1, ($row && $row->featured == 1));
					xform_check('Published', 'published', 'checkbox', 'published', 1, ($row && $row->published == 1));
					?>
				</div>
				<?php
			} ?>
		</div>
		<div class="<?php echo grid_col(12, '', '5?2'); ?>">
			<?php
			if (!$is_view) {
				xform_group_list('Featured Item Type', 'featured_item_type', 'select', adit_value($row, 'featured_item_type'), true, 
					['options' => ['image' => 'Image', 'video' => 'Video'], 'id' => 'featured_item_type']
				); 
			} 
			if ($is_view_edit) {
				if ($row->featured_item_type == 'video') {
					echo portal_video_widget($row->featured_item, 'Featured Video', 'featured_item_widget');
				} else {
					echo portal_image_widget('uploads/pix/blog/'.$row->featured_item, 'Featured Image', 'featured_item_widget');
				}
			}
			if (!$is_view) { ?>
				<div id="featured_item_section_image" class="featured_item_section">
					<?php xform_group_list('Featured Image', 'featured_item_image', 'file', '', false, ['help' => "Allowed types: png|jpg, Max 1MB. Ideal dimension: 750x450"]); ?>
				</div>
				<div id="featured_item_section_video"  class="featured_item_section" style="display: none;">
					<?php
					$video_value = ($row->featured_item_type == 'video') ? adit_value($row, 'featured_item') : '';
					echo xform_group_list('Featured Video URL', 'featured_item_video', 'url', $video_value, false); 
					?>
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
	<?php
xform_close();