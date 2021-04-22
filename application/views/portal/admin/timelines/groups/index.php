<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'Order', 'Published'];
$columns = [
	'title',
	'order',
	dt_dumb_column('published_text'),
];
$endpoint = 'api/timeline_groups/get?trashed='.$this->trashed;
$endpoint .= '&type='.xget('type');
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);
?>