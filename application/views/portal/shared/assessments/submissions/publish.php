This action will publish this student's test result and the student will be able to check his/her result if feedback has been enabled.

<?php 
xform_open('api/assessment_submissions/publish', xform_attrs('publish_form'));
	xform_input('sub_id', 'hidden', $id);
	xform_input('status', 'hidden', $s_row->submit_status);
	xform_check('Enable score feedback', 'sub_score_feedback', 'checkbox', 'sub_score_feedback', 1, ($s_row->sub_score_feedback == 1), false, false, ['class' => 'chk_rad_16']);
	xform_check('Enable full feedback', 'sub_feedback', 'checkbox', 'sub_feedback', 1, ($s_row->sub_feedback == 1), false, false, ['class' => 'chk_rad_16']);
	xform_submit('Publish', '', ['class' => 'btn btn-primary']);
xform_close();