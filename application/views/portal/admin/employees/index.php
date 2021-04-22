<?php
$headers = ['Name' => ['class' => 'min-w-200'], 'Sex', 'Email', 'Mobile No.', 'Super User', 'Roles' => ['class' => 'min-w-250']];
$columns = [
	dt_dumb_column('full_name'),
	dt_dumb_column('gender'),
	'email', 
	'phone', 
	dt_dumb_column('is_super_user_text'),
	dt_dumb_column('roles_name'), 
	//hidden
	dt_hidden_column('last_name'), 
	dt_hidden_column('first_name'),
	dt_hidden_column('other_name'),
];
$endpoint = 'api/employees/get?trashed='.$this->trashed;
//fetching employees by status?
$endpoint .= strlen(xget('status')) ? '&status='.xget('status'): '';
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);