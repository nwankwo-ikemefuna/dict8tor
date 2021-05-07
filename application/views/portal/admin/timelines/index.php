<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'Group', 'Order', 'Published'];
$columns = [
	'title',
	'group_title_default',
	'order',
	dt_dumb_column('published_text'),
];
$endpoint = 'api/timelines/get?trashed='.$this->trashed;
$endpoint .= '&type='.xget('type');
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => false, 'updated' => false]);
?>