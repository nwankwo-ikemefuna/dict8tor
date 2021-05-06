<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'Published'];
$columns = [
	'title',
	dt_dumb_column('published_text'),
];
$endpoint = 'api/videoz/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => true, 'updated' => false]);
?>