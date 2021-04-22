<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'slug', 'Order'];
$columns = [
	'title',
	'slug',
	'order',
];
$endpoint = 'api/post_categories/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);
?>