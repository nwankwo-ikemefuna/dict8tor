<?php
$headers = ['Name' => ['class' => 'min-w-200'], 'Email', 'Mobile No.', 'Project Name', 'Project LGA', 'Project Budget'];
$columns = [
	dt_dumb_column('full_name'),
	'email', 
	'phone', 
	'grant_project_title',
	'grant_project_lga_name',
	'grant_project_budget_amount',
	//hidden
	dt_hidden_column('last_name'), 
	dt_hidden_column('first_name'),
	dt_hidden_column('other_name'),
];
$endpoint = 'api/hands_on_applications/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);