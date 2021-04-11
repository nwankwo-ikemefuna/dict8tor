
<?php
$languages = get_site_languages();

xform_open('api/language_strings/edit', xform_attrs());
	xform_notice();
	xform_text('These are language-dependent strings such as link, button, call-to-action and headline texts and other string literals used across the website.');
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="table_scroll">
				<table class="table">
					<thead>
						<tr>
							<?php
							foreach ($languages as $lang) { ?>
								<th style="width: <?php echo (100/count($languages)); ?>%;"><?php echo $lang['title']; ?></th>
								<?php
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($rows as $row) { 
                            xform_input('idx[]', 'hidden', $row->id);
                            xform_input("def_editables[{$row->id}]", 'hidden', $row->default_editable);
                            ?>
							<tr>
								<?php
								foreach ($languages as $lang) { ?>
									<th>
										<?php
										$col = "value_{$lang['key']}";
										if ($is_edit) {
                                            if ($row->default_editable) {
                                                $input_type = 'textarea';
                                                $input_attrs = ['rows' => 2];
                                            } else {
                                                $input_type = 'text';
                                                $input_attrs = [];
                                            }
                                            //don't show input for default language unless marked editable...
                                            if (($lang['key'] == DEFAULT_LANGUAGE && $row->default_editable) || ($lang['key'] != DEFAULT_LANGUAGE)) {
											    xform_input("{$col}[{$row->id}]", $input_type, strip_tags($row->$col), true, $input_attrs);
                                            } else {
                                                echo $row->$col;
                                            }
										} else {
											echo $row->$col;
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
	<?php
xform_close();
	