<div class="row">
	<div class="<?php echo grid_col(12, '', 5); ?>">
		<?php data_show_grid('Session', session_slash($session)); ?>
	</div>
	<div class="<?php echo grid_col(12, '', '5?2'); ?>">
		<?php data_show_grid('Semester', $semester); ?>
	</div>
</div>

<div class="row">
	<div class="<?php echo grid_col(12, '', 5); ?>">
		<button class="btn btn-success btn-sm collapse_fam" data-toggle="collapse" data-target="#btn_diff_level"><i class="fa fa-qrcode"></i> Difficulty Levels</button>

		<div class="collapsible_section m-b-20">
			<div class="collapse" id="btn_diff_level">
				<h5>Difficulty Levels</h5>
				<?php 
				xform_open('api/assessments/diff_levels', xform_attrs('diff_levels_form'));
					xform_input('id', 'hidden', $id);

					if (!$shuffle) { ?>
						<p>To use this feature, question shuffling must be enabled.</p>
						<?php 
						xform_check('Enable Shuffling', 'shuffle', 'checkbox', 'shuffle', 1, ($shuffle == 1), false, false, ['class' => 'chk_rad_16']);
					} ?>
					
					<table class="table">
						<thead>
							<tr>
								<th>Level</th>
								<th>No. of Questions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$all_diff_levels = assessment_difficulty_levels();
							$ass_diff_levels = (array) json_decode($diff_levels, true);
							foreach ($all_diff_levels as $key => $level) { ?>
								<tr>
									<td><?php echo $level; ?></td>
									<td>
										<input type="hidden" class="form-control" name="keys[]" value="<?php echo $key; ?>">
										<input type="number" class="form-control" name="diff_levels[<?php echo $key; ?>]" value="<?php echo $ass_diff_levels[$key] ?? ''; ?>" min="0" max="<?php echo $total_questions; ?>" style="max-width: 200px;">
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
					<?php
					xform_notice();
					xform_submit('Submit', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
		</div>
	</div>
</div>