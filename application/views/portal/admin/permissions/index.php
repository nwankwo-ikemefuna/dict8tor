<?php
$headers = ['Name' , 'User Count'];
$columns = [
	'name', 
	dt_dumb_column('employee_count')
];
$endpoint = 'api/permissions/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);