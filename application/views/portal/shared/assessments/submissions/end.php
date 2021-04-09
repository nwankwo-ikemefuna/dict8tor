This action will submit this student's test and he/she will not be able to continue the test. Click End to confirm.

<?php 
xform_open('api/assessment_submissions/end', xform_attrs('end_form'));
	xform_input('sub_id', 'hidden', $id);
	xform_input('status', 'hidden', $s_row->submit_status);
	xform_submit('End', '', ['class' => 'btn btn-primary']);
xform_close();