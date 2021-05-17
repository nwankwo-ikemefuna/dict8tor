<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'slug', 'Order', 'Total Posts'];
$columns = [
	'title',
	'slug',
	'order',
	dt_dumb_column('post_count'),
];
$endpoint = 'api/post_categories/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);
?>