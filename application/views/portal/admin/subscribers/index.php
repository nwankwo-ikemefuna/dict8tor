<?php
$headers = ['Email', 'Mobile No.'];
$columns = [
	'email', 
	'phone', 
];
$endpoint = 'api/subscribers/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => true, 'updated' => false]);