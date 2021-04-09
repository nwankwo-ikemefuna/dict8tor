<?php 
$question_count = count($questions);

if (user_group(STUDENT)) { ?>
	<span id="test_rem_time"></span>
	<?php 
} ?>

<div class="row">
	<div class="col-12 col-lg-8">
		<button class="btn btn-info btn-sm collapse_fam" data-toggle="collapse" data-target="#details"><i class="fa fa-info"></i> Assessment Details</button>
		<button class="btn btn-info btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_instructions">Instructions</button>
		<?php
		if (user_group(STUDENT)) { ?>
			<button class="btn btn-info btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_rough">Rough Sheet</button>
			<button class="btn btn-info btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_help">Help</button>
			<?php 
		} ?>
		<div class="collapsible_section">
			<div class="collapse" id="details">
				<table class="table">
					<tbody>
						<?php 
						table_row_double_data('Assessment', $row->assessment);
						table_row_double_data('Group', $row->group);
						table_row_double_data('Course', $row->course);
						if (!user_group(STUDENT)) {
							table_row_double_data('Duration', decode_duration($row->duration));
							table_row_double_data('Questions', $question_count);
							table_row_double_data('Difficulty Level', $row->diff_level_text);
						} else {
							table_row_double_data('Questions Attempted', $row->total_attempted.' out of '.$question_count);
							//if extra time > 0, append to duration
							$duration_extra = $row->extra_time ? ' (extra time: '.decode_duration($row->extra_time).')' : '';
							table_row_double_data('Duration', decode_duration($row->duration).$duration_extra);
							table_row_double_data('Start Time', x_date_time($row->start_time));
							table_row_double_data('End Time', x_date_time($row->end_time));
						} ?>
					</tbody>
				</table>
			</div>
			<div class="collapse show text-muted" id="assessment_instructions">
				<h4 class="title_text">Test Instructions</h4>
				<?php echo $row->instructions; ?>
			</div>
			<?php
			if (user_group(STUDENT)) {  ?>
				<div class="collapse text-muted" id="assessment_rough">
					<h4 class="title_text">Do your rough work here.</h4>
					<textarea rows="7" id="rough_work" style="width: 100%"></textarea>
				</div>
				<div class="collapse text-muted" id="assessment_help">
					<h4 class="title_text">Help</h4>
					<ul style="padding-inline-start: 19px;">
						<li>Your response to each question will be saved when you navigate to a new question using the Previous/Next or question buttons.</li>
						<li>You can update your answer whenever you return to this question within the alloted test time.</li>
						<li>When you are done attempting all questions, click the Submit Test button below to submit and complete your test.</li>
						<li>
							Question navigation button colours: 
							<i class="fa fa-square text-secondary m-l-10"></i> Unattempted
							<i class="fa fa-square text-success m-l-10"></i> Attempted
							<i class="fa fa-square text-danger m-l-10"></i> Current
						</li>
					</ul>
				</div>
				<?php 
			} ?>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<?php
		if (user_group(STUDENT)) { 
			if ($row->submit_status < ASS_SUB_SUBMITTED) { ?>
				<button class="btn btn-success btn-sm collapse_fam" data-toggle="collapse" data-target="#assessment_submit_test">Submit Test</button>
				<div class="collapse text-muted" id="assessment_submit_test">
					<?php
					$unattempted = $question_count - $row->total_attempted;
					$msg = $unattempted ? "<h4 class='title_text text-danger'>You still have {$unattempted} unattempted ".inflect($unattempted, 'question')."!</h4>" : '';
					$msg .= "It appears you still have some time left, it will be a good idea to cross check your responses once again. When you are ready, click <b>Submit & End Test</b>.";
					echo $msg;
					//js food
					xform_input('current_time', 'hidden', date('Y-m-d H:i:s'));
					xform_input('end_time', 'hidden', $row->end_time);
					xform_input('is_exhausted', 'hidden', $is_exhausted);
					xform_input('has_submitted', 'hidden', 0);
					
					xform_notice();
					xform_submit('Submit & End Test', '', ['class' => 'btn btn-primary submit_response', 'data-s_type' => 'submit'], [], false); ?>
				</div>
				<?php
			} 
		} ?>
	</div>
</div>

<div class="row mt-3 mb-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header bg-info">
				<h3>Question <?php echo $q_order; ?></h3>
			</div>
			<div class="card-footer">
				<span class="badge badge-info"><?php echo $row->type_text; ?></span>
				<span class="badge badge-info"><?php echo $row->mark.' '.inflect($row->mark, 'mark'); ?></span>
			</div>
			<div class="card-body">
				<div class="assessment_question">
					<h5 class="text-bold"><?php echo $row->question; ?></h5>
				</div>
				<?php
				if (user_group(SCHOOL_EMPLOYEES)) {
					require 'answer.php';
				} else { ?>
					<div class="m-t-20">
						<?php
						if (user_group(STUDENT)) { 
							if ($row->submit_status < ASS_SUB_SUBMITTED) { 
								require 'take.php'; 
							} 
						} ?>
					</div>
					<?php
				} ?>
			</div>
		</div>
	</div>
</div>

<?php
//navigation
//if student, prevent auto navigate, associate button with form to save the current question response
$std_attrs = [
	'data-s_type' => 'save',
	'data-msg_box' => 'nav_msg_box',
];
//question number buttons
if (user_group(STUDENT)) { ?>
	<div class="text-center m-t-10">
		<?php
		foreach ($questions as $q_row) {
			$q_row_id = $q_row['id'];
			$q_row_order = assessment_question_order($row->ass_id, $q_row_id, $q_row['order'], $row->shuffle);
			//button background color
			$bg = $q_row_id == $row->id ? 'danger' : ($q_row['attempted'] ? 'success' : 'secondary');
			//if currently viewed question, disable click
			$attrs = $q_row_id == $row->id ? array_merge($std_attrs, ['disabled' => '']) : $std_attrs;
			ajax_page_button('assessment_questions/view/'.$q_row_id, $q_row_order, 'btn-'.$bg.' q_nav_btn submit_response m-r-10', '', '', set_extra_attrs($attrs), '', '', 1, '', '', false, false);
		} ?>
	</div>
	<?php 
} ?>

<div class="m-t-10" style="padding-bottom: 30px;">
	<?php
	//prev/next buttons
	if (user_group(STUDENT)) { 
		$auto_navigate = false;
		$nav_order = $q_order;
		$extra_attrs = array_merge($std_attrs, ['class' => 'submit_response']);
		xform_notice('nav_msg_box');
	} else {
		$auto_navigate = true;
		$nav_order = $row->order;
		$extra_attrs = [];
	}
	ajax_prev_next_nav('assessment_questions/view', $questions, $row->id, $nav_order, $auto_navigate, $extra_attrs);
	?>
</div>


<style type="text/css">
	.q_nav_btn {
		padding: 3px 10px;
	}
	.collapse_fam {
		margin-bottom: 5px;
	}
	#test_rem_time {
		position: absolute;
		top: -48px;
		right: 0;
	}
	.assessment_question img, 
	.form-check img{
		width:auto!important;
		height:auto!important;
	}
</style>

<script type="text/javascript">
	//serve question
	$(document).ready(function(){
		serve_question();
	});
</script>