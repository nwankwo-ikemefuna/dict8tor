This action will delete this student's submission so the student may start the test all over. Supply your password and click Delete to confirm.

<?php 
xform_open('api/assessment_submissions/delete', xform_attrs('delete_form'));
    xform_input('ass_id', 'hidden', $ass_id);
	xform_input('sub_id', 'hidden', $id);
	xform_input('status', 'hidden', $s_row->submit_status);
	xform_group_list('Your Password', 'password', 'password', '', true);
	xform_submit('Delete', '', ['class' => 'btn btn-primary']);
xform_close();