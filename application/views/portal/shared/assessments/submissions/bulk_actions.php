<div class="row mb-3">
	<div class="<?php echo grid_col(12, '', 5); ?>">
		<?php data_show_grid('Session', session_slash($session)); ?>
	</div>
	<div class="<?php echo grid_col(12, '', '5?2'); ?>">
		<?php data_show_grid('Semester', $semester); ?>
	</div>
</div>

<div class="row">
	<div class="<?php echo grid_col(12); ?>">
		<button class="btn btn-danger btn-sm collapse_fam tv_button" data-toggle="collapse" data-target="#btn_end_all"><i class="fa fa-ban"></i> End All</button>
		<button class="btn btn-success btn-sm collapse_fam tv_button" data-toggle="collapse" data-target="#btn_reopen_all"><i class="fa fa-folder-open"></i> Re-open All</button>
		<button class="btn btn-success btn-sm collapse_fam tv_button" data-toggle="collapse" data-target="#btn_mark_all"><i class="fa fa-check-square"></i> Mark All</button>
		<button class="btn btn-success btn-sm collapse_fam tv_button" data-toggle="collapse" data-target="#btn_publish_all"><i class="fa fa-check-square"></i> Publish All</button>

		<div class="collapsible_section m-b-20">
			<?php xform_notice(); ?>
			<div class="collapse" id="btn_end_all">
				<h5>End All</h5>
				<?php 
				xform_open('api/assessment_submissions/end_all', xform_attrs('end_all_form'));
					xform_input('ass_id', 'hidden', $ass_id);
					xform_submit('Proceed', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
			<div class="collapse" id="btn_reopen_all">
				<h5>Re-open All</h5>
				<?php 
				xform_open('api/assessment_submissions/reopen_all', xform_attrs('reopen_all_all_form'));
					xform_input('ass_id', 'hidden', $ass_id);
					xform_group_list('Extra Time (in minutes)', 'extra_time', 'number', 0, false, ['min' => 0, 'help' => 'Leave blank or put 0 if not giving extra time.']);
					xform_submit('Proceed', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
			<div class="collapse" id="btn_mark_all">
				<h5>Mark All</h5>
				<?php 
				xform_open('api/assessment_submissions/mark_all', xform_attrs('mark_all_form'));
					xform_input('ass_id', 'hidden', $ass_id);
					xform_submit('Proceed', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
			<div class="collapse" id="btn_publish_all">
				<h5>Publish All</h5>
				<?php 
				xform_open('api/assessment_submissions/publish_all', xform_attrs('publish_all_form'));
					xform_input('ass_id', 'hidden', $ass_id);
					xform_check('Enable score feedback', 'sub_score_feedback', 'checkbox', 'score_feedback', 1, ($ass_feedback == 1), false, false, ['class' => 'chk_rad_16']);
					xform_check('Enable full feedback', 'sub_feedback', 'checkbox', 'feedback', 1, ($ass_feedback == 1), false, false, ['class' => 'chk_rad_16']);
					echo 'Note that only marked tests will be published.';
					xform_submit('Proceed', '', ['class' => 'btn btn-primary'], [], false);
				xform_close();
				?>
			</div>
		</div>
	</div>
	<div class="<?php echo grid_col(12); ?>">
		<h5>Showing <?php echo $filter_type; ?> submissions 
			<?php 
			if ($filter_type != 'all') { ?>
				: <b><?php echo $filtered_by; ?></b>
				<?php 
			} ?>
		</h5>
		<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#m_filter_subs">Filter Submissions</button>
		<?php
		if ($filter_type != 'all') { 
			ajax_page_button('assessment_submissions?ass_id='.$ass_id.'&trashed='.$this->trashed, 'Show All', 'btn-primary btn-sm');
		}
		
		modal_header('m_filter_subs', 'Filter Submissions', 'class_dept_wrapper'); 
			xform_input('ass_id', 'hidden', $ass_id);
			xform_input('trashed', 'hidden', $this->trashed);
			xform_group_list('Department', 'dept_id', 'select', '', false, 
				['options' => $this->session->_departments, 'text_col' => 'name', 'extra' => ['class' => 'select_dept_id']]
			); 
			xform_group_list('Class', 'class_id', 'select', '', false, ['options' => [], 'extra' => ['class' => 'select_class_id']]);
			xform_submit('Apply Filter', '', ['id' => 'filter_submissions', 'class' => 'text-white m-t-15']);
		modal_footer(false); 
		?>
	</div>
</div>