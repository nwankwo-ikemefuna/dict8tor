<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'icon', 'Order', 'Published'];
$columns = [
	'title',
	'icon',
	'order',
	dt_dumb_column('published_text'),
];
$endpoint = 'api/priorities/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);
?>