
<?php
$languages = get_site_languages();

xform_open_multipart('api/info/edit', xform_attrs());
	xform_notice();
	if ($is_edit) { 
		xform_input('phase', 'hidden', $row->phase);
	}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="table_scroll">
				<table class="table">
					<thead>
						<tr>
							<th colspan="<?php echo count($languages)+1; ?>">Language-dependent Site Information</th>
						</tr>
						<tr>
							<th style="width: 20%;">Information</th>
							<?php
							foreach ($languages as $lang) { ?>
								<th style="width: <?php echo (80/count($languages)); ?>%;"><?php echo $lang['title']; ?></th>
								<?php
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($language_columns as $key => $arr) { ?>
							<tr>
								<td><?php echo $arr['title']; ?></td>
								<?php
								foreach ($languages as $lang) { ?>
									<th>
										<?php
										$input_field = $key.'_'.$lang['key'];
										if ($is_edit) {
											$input_attrs = ($arr['input'] == 'textarea') ? ['rows' => $arr['rows']] : [];
											xform_input($input_field, $arr['input'], strip_tags($row->$input_field), true, $input_attrs);
										} else {
											echo $row->$input_field;
										}
										?>
									</th>
									<?php
								}
								?>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row m-t-30">
		<?php
		foreach ($image_columns as $key => $arr) { ?>
			<div class="<?php echo grid_col(12, 6, 4); ?>">
				<?php 
				echo portal_image_widget('pix/info/'.$row->$key, $arr['title']); 
				if ($is_edit) {
					xform_input($key, 'file', '', false, ['help' => file_upload_info($arr['ext'], $arr['dimension'], $arr['max'], $arr['unit'], true)]);
				}
				?>
			</div>
			<?php
		} ?>
		<div class="<?php echo grid_col(12, 6, 4); ?>">
			<?php 
			echo portal_video_widget($row->intro_video, 'Intro Video'); 
			if ($is_edit) {
				xform_input('intro_video', 'url', $row->intro_video, true);
			}
			?>
		</div>
	</div>
	<?php
xform_close();
	