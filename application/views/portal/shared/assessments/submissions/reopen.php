This action will re-open this student's test (if already submitted) and he/she will be able to resume the test. You may also specify extra time which will be added to the student's remaining time. Click Re-open to confirm.

<?php 
xform_open('api/assessment_submissions/reopen', xform_attrs('reopen_form'));
	xform_input('sub_id', 'hidden', $id);
	xform_input('status', 'hidden', $s_row->submit_status);
	xform_group_list('Extra Time (in minutes)', 'extra_time', 'number', adit_value($s_row, 'extra_time', 0), false, ['min' => 0, 'help' => 'Leave blank or put 0 if not giving extra time.']);
	xform_submit('Re-open', '', ['class' => 'btn btn-primary']);
xform_close();