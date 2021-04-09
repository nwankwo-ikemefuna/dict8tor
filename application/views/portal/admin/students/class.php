<?php
$headers = ['ID', 'Name' => ['class' => 'min-w-200'], 'Registration ID', 'Sex', 'Email', 'Mobile No.', 'Programme Status', 'Account Status', 'Sent Activation SMS'];
$columns = [
	'id', 
	dt_dumb_column('full_name'),
	'username', 
	dt_dumb_column('gender'),
	'email', 
	'phone', 
	dt_dumb_column('student_status'), 
	dt_dumb_column('account_status'), 
	dt_dumb_column('sent_activation_sms_text'),
	//hidden
	dt_hidden_column('last_name'), 
	dt_hidden_column('first_name'),
	dt_hidden_column('other_name'),
];
$endpoint = 'api/students/get?trashed='.$this->trashed;
$endpoint .= '&class_id='.$id;
//fetching students by status?
$endpoint .= strlen(xget('status')) ? '&status='.xget('status'): '';
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);