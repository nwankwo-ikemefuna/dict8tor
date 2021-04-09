<div class="row">
	<div class="col-xs-12 col-md-6">
		<table class="table">
			<tbody>
				<tr>
					<td colspan="2"><h4 class="title_text"><?php echo $marking ? 'Mark Test' : 'Test Submission'; ?>: <?php echo $s_row->student_name; ?></h4></td>
				</tr>
				<?php 
				table_row_double_data('Assessment', $s_row->assessment);
				table_row_double_data('Course', $s_row->course);
				//if extra time > 0, append to duration
				$duration_extra = $s_row->extra_time ? ' (extra time: '.decode_duration($s_row->extra_time).')' : '';
				table_row_double_data('Status', $s_row->submit_status_text);
				table_row_double_data('Duration', decode_duration($s_row->duration).$duration_extra);
				table_row_double_data('Start Time', x_date_time($s_row->start_time));
				table_row_double_data('End Time', x_date_time($s_row->end_time));
				table_row_double_data('Questions Attempted', $s_row->total_attempted.' out of '.$s_row->to_answer_val);
				//if test hasn't been marked, we can't know if essay was correct or not, so...
				$exclude_essay = ($s_row->submit_status < ASS_SUB_MARKED) ? ' (excluding essays)' : '';
				table_row_double_data('Correct Attempts', $s_row->correct_attempts.' out of '.$s_row->total_attempted . $exclude_essay);
				table_row_double_data('Mark Obtained', $s_row->total_mark); 
				table_row_double_data('Percentage Score', $s_row->submit_status >= ASS_SUB_MARKED ? $s_row->percentage_score.'%' : ' - ');
				table_row_double_data('Pass Mark (in percentage)', $s_row->submit_status >= ASS_SUB_MARKED ? $s_row->passmark.'%' : ' - ');
				table_row_double_data('Passed', assessment_pass_status($s_row->submit_status, $s_row->percentage_score, $s_row->passmark));
				table_row_double_data('Score Feedback', ['Disabled', 'Enabled'][$s_row->sub_score_feedback]);
				table_row_double_data('Full Feedback', ['Disabled', 'Enabled'][$s_row->sub_feedback]);
				?>
			</tbody>
		</table>
	</div>
	<div class="col-xs-12 col-md-6">
		<button class="btn btn-info btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_instructions">Instructions</button>
		<?php
		//extra time
		if (user_group(SCHOOL_EMPLOYEES) && $s_row->submit_status >= ASS_SUB_STARTED) {
			if ($s_row->submit_status < ASS_SUB_SUBMITTED) { ?>
				<button class="btn btn-warning btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_end_test">End Test</button>
				<?php 
			} ?>
			<button class="btn btn-success btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_reopen_test">Re-open Test / Extra Time</button>
			<?php
			//allow to publish if test is marked
			if ($s_row->submit_status >= ASS_SUB_MARKED) { ?>
				<button class="btn btn-success btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_publish_test"><?php echo ($s_row->submit_status == ASS_SUB_PUBLISHED) ? 'Unpublish' : 'Publish'; ?> Result</button>
				<?php 
			}  
			if ($s_row->submit_status >= ASS_SUB_SUBMITTED && $s_row->submit_status < ASS_SUB_PUBLISHED) { ?>
				<button class="btn btn-danger btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_delete_test">Delete Submission</button>
				<?php 
			}  
		} ?>
		<div class="collapsible_section m-b-20">
			<div class="collapse text-muted" id="assessment_instructions">
				<h4 class="title_text">Test Instructions</h4>
				<?php echo $s_row->instructions; ?>
			</div>
			<?php
			if (user_group(SCHOOL_EMPLOYEES) && $s_row->submit_status >= ASS_SUB_STARTED) { 
				if ($s_row->submit_status < ASS_SUB_SUBMITTED) { ?>
					<div class="collapse" id="assessment_end_test">
						<h4 class="title_text">End Test</h4>
						<?php require 'end.php'; ?>
					</div>
					<?php 
				} ?>
				<div class="collapse" id="assessment_reopen_test">
					<h4 class="title_text">Re-open Test</h4>
					<?php require 'reopen.php'; ?>
				</div>
				<?php
				if ($s_row->submit_status >= ASS_SUB_MARKED) { ?>
					<div class="collapse" id="assessment_publish_test">
						<h4 class="title_text"><?php echo ($s_row->submit_status == ASS_SUB_PUBLISHED) ? 'Unpublish' : 'Publish'; ?>Result </h4>
						<?php require 'publish.php'; ?>
					</div>
					<?php 
				}
				if ($s_row->submit_status >= ASS_SUB_SUBMITTED && $s_row->submit_status < ASS_SUB_PUBLISHED) { ?>
					<div class="collapse" id="assessment_delete_test">
						<h4 class="title_text">Delete Submission</h4>
						<?php require 'delete.php'; ?>
					</div>
					<?php 
				}
				xform_notice();
			} ?>
		</div>
	</div>
</div>

<?php
if (user_group(SCHOOL_EMPLOYEES) && $s_row->submit_status >= ASS_SUB_SUBMITTED && $marking && $sub_entries) {
	xform_open('api/assessment_submissions/mark', xform_attrs());
		xform_input('sub_id', 'hidden', $id);
		xform_input('status', 'hidden', $s_row->submit_status);
		xform_submit('Mark', '', ['class' => 'btn btn-primary btn-lg']);
		xform_notice();
} 
//trying to mark when test has not been submitted?
if (user_group(SCHOOL_EMPLOYEES) && $s_row->submit_status < ASS_SUB_SUBMITTED && $marking) { 
	show_alert('Test has not been submitted!', 'danger', 'text-center');
} ?>

<div class="row">
	<div class="col-12">

		<?php 
		//array letters for the options. 
		$letters = range('A', 'Z');
		$entry_count = count($sub_entries);
		if ($entry_count) {

			$i = 1;
			foreach ($sub_entries as $row) { 

				xform_input('idx[]', 'hidden', $row->id);
				xform_input("types[{$row->id}]", 'hidden', $row->type);

				//correction
				$correction = "";
				//objective type?
				$is_obj = (in_array($row->type, [ASS_QT_SINGLE, ASS_QT_MULT]));
				
				if ($s_row->submit_status >= ASS_SUB_MARKED) {
					//marked, get as marked
					$is_correct = ($row->correct == 1);
					$mark = $row->mark; 
					//(in)correct icon
					$c_color = $is_correct ? 'success' : 'danger';
					$c_fa = $is_correct ? 'check' : 'times';
					$c_icon = '<i class="fa fa-'.$c_fa.' text-'.$c_color.'"></i>';
				} else {
					//yet to be marked, get from question
					$is_correct = (strtolower($row->response) === strtolower($row->answer));
					$mark = $is_correct ? $row->q_mark : 0; 
					//(in)correct icon
					$c_color = $is_correct ? 'success' : 'danger';
					$c_fa = $is_correct ? 'check' : 'times';
					//just show ? icon if essay type
					$c_icon = ($row->type == ASS_QT_ESSAY) ? '<i class="fa fa-question"></i>' : '<i class="fa fa-'.$c_fa.' text-'.$c_color.'"></i>';
				} 

				//if objective or is correct short answer, the teacher can't do nothing
				$is_correct_short = ($row->type == ASS_QT_SHORT) && $is_correct;
				$is_decided = ($is_obj || $is_correct_short);
				?>

				<div class="card mb-3">
					<div class="card-header bg-info" style="padding: 1px 20px;">
						<h4 class="title_text text-bold"><span class="clickable" data-toggle="collapse" data-target="#question_<?php echo $row->id; ?>">Question <?php echo $row->order; ?></span></h4>
					</div>
					<div class="card-footer" style="border-bottom: 1px solid #f2f2f2;">
						<span class="badge badge-dark"><?php echo $row->type_text; ?></span>
						<span class="badge badge-dark"><?php echo $row->q_mark; ?> marks</span>

						<?php 
						if ($s_row->submit_status >= ASS_SUB_SUBMITTED) { ?>
							<div class="float-md-right">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="custom_prepend_text">
											<?php 
											if ($marking) { 
												$correct_attrs = [];
												$correct_extras = $is_decided ? array_merge($correct_attrs, ['disabled' => 'disabled']) : $correct_attrs;
												?>
												<input 
													type="checkbox" 
													name="correct[<?php echo $row->id; ?>]" 
													id="correct_<?php echo $row->id; ?>" 
													value="1" 
													<?php echo $is_correct ? 'checked' : ''; ?>
													<?php echo $is_decided ? 'disabled' : ''; ?>
												/>
												<?php
												//hidden input for disabled checkbox post back
												if ($is_decided) {
													xform_input("correct[{$row->id}]", 'hidden', ($is_correct ? 1 : 0));
												}
											} else { 
												//show (in)correct icon ?>
												<span><?php echo $c_icon; ?></span>
												<?php
											} ?>
										</div>
									</div>
									<?php 
									$mark_attrs = [
										'class' => 'assessment_mark_input',
										'min' => 0,
										'max' => $row->q_mark //question mark
									];
									$mark_extras = (!$marking || $is_decided) ? array_merge($mark_attrs, ['readonly' => 'readonly']) : $mark_attrs;
									xform_input(
										"marks[{$row->id}]", 
										'number', 
										$mark,
										false,
										$mark_extras
									); ?>
								</div>
							</div>
							<?php 
						} ?>

					</div>
					<div class="card-body collapse" id="question_<?php echo $row->id; ?>">

						<div class="assessment_question">
							<h5 class="text-bold"><?php echo $row->question; ?></h5>
						</div>

						<?php
						xform_input('q_id', 'hidden', $row->q_id);
						xform_input('q_type', 'hidden', $row->type);
					    //objective type
						if ($is_obj) {
							$input_type = $row->type == ASS_QT_SINGLE ? 'radio' : 'checkbox';
							$options = json_decode($row->options, true);
							$correct_answers_arr = strlen($row->answer) ? (array) explode(',', $row->answer) : [];
							$student_answers_arr = strlen($row->response) ? (array) explode(',', $row->response) : [];
							$j = 1;
					        foreach ($options as $key => $option) { 
					        	$checked = false;
					        	if (in_array($key, $student_answers_arr)) {
				    				$checked = true;
								}
					        	$_id = "response_{$i}_{$j}";
					        	xform_check('<b>'.$letters[$key].'.</b> '.$option, '', $input_type, $_id, '', $checked, false, false, ['class' => 'chk_rad_16 no_cursor', 'bold' => false, 'disabled' => true]);
					        	$j++;
					        }
					        //map the correct answer keys to their corresponding letters
				            $correction_arr = array_map(function($ans_key) use ($letters) { 
				            	return '<b>'.$letters[$ans_key].'</b>'; 
				            }, $correct_answers_arr); 
				            $opt_inflect = inflect(count($correct_answers_arr), 'Option');
				            $correction = $opt_inflect.' '.join_us($correction_arr, ', ');
						} else {
							if ($row->type == ASS_QT_SHORT) {
								//free response short answer
								xform_input('', 'text', $row->response, false, ['disabled' => '']);
							} else {
								//free response essay
								xform_input('', 'textarea', strip_tags($row->response), false, ['disabled' => '']);
							}
							$correction = $row->answer;
						} 

						//correction
						if ($row->type != ASS_QT_ESSAY) { ?>
							<h5 class="text-bold">
								Answer
								<?php echo $c_icon; ?>
							</h5>
							<?php if (!$is_correct) { ?>
								<div class="m-t-10-n">Correct: <?php echo $correction; ?></div>
								<?php
							} 
						} ?>

					</div>
				</div>
				<?php
				$i++;
			} 

		} else {
			if ($s_row->submit_status >= ASS_SUB_SUBMITTED) {
				show_alert('Test is submitted but no response was found!', 'danger', 'text-center');
			}
		} ?>
	</div>
</div>
<?php
if (user_group(SCHOOL_EMPLOYEES) && $s_row->submit_status >= ASS_SUB_SUBMITTED && $marking && $sub_entries) {
	xform_close();
}
?>

<style type="text/css">
	.no_cursor {
		cursor: default;
	}
	.assessment_mark_input, .custom_prepend_text {
		padding: 3px; 
		border: 2px solid #ddd;
		max-width: 65px !important;
		text-align: center;
	}
	.custom_prepend_text {
		border-right: 0;
	}
</style>