<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'Category' => ['class' => 'min-w-200'], 'Featured Post', 'Published'];
$columns = [
	'title',
	'category_title_default',
	dt_dumb_column('featured_text'),
	dt_dumb_column('published_text'),
];
$endpoint = 'api/posts/get?trashed='.$this->trashed;
ajax_table('data_table', $endpoint, $headers, $columns, ['created' => true, 'updated' => false]);
?>