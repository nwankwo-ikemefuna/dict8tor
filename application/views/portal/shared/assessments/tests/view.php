<?php 
if (user_group(STUDENT)) { ?>
	<div class="mb-3">
		<?php
		//ensure student hasn't submitted test or time hasn't expired
		if ($row->submit_status < ASS_SUB_SUBMITTED && !$is_exhausted) {
			ajax_page_button('assessment_questions/view/'.$q_id, $btn_text, 'btn-success btn-lg');
		} else {
			//is feedback allowed and has test been published
			if ($row->sub_score_feedback && $row->submit_status >= ASS_SUB_PUBLISHED) {
				ajax_page_button('assessment_submissions/student_results?session='.SESSION.'&semester='.SEMESTER, 'View Feedback', 'btn-success');
			} else { 
				show_alert('Test ended', 'info', 'text-center');
			}
		} ?>
	</div>
	<?php
} ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-info">
				<h3><?php echo $row->title; ?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<table class="table">
							<tbody>
								<?php 
								table_row_double_data('Group', $row->group);
								table_row_double_data('Course', $row->course);
								table_row_double_data('Start', $row->open_date_human);
								table_row_double_data('Close', $row->close_date_human);
								table_row_double_data('Duration', decode_duration($row->duration));
								if (user_group(SCHOOL_EMPLOYEES)) { 
									table_row_double_data('Pass Mark', $row->passmark.'%');
									table_row_double_data('Shuffle Questions', $row->shuffle_text);
									table_row_double_data('Score Feedback', $row->score_feedback_text);
									table_row_double_data('Full Feedback', $row->feedback_text);
									table_row_double_data('Total Questions', $row->question_count);
									table_row_double_data('Questions to answer', $row->to_answer_text);
									table_row_double_data('Submissions', $row->submission_count);
								} else {
									table_row_double_data('Questions', $row->to_answer_val);
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<h3 class="text-bold m-t-20">Instructions</h3>
				<?php echo $row->instructions; ?>
			</div>
		</div>

	</div>
</div>