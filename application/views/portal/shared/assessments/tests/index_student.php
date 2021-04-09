<?php
$headers = ['Title' => ['class' => 'min-w-200'], 'Course' => ['class' => 'min-w-200'], 'Group' => ['class' => 'min-w-150'], 'Duration' => ['class' => 'min-w-150'], 'Questions', 'Status', 'Starts' => ['class' => 'min-w-200'], 'Closes' => ['class' => 'min-w-200']
];
$columns = [
	'title', 
	'course', 
	'group', 
	dt_dumb_column('duration_min'),
	dt_dumb_column('to_answer_val'),
	dt_dumb_column('submit_status_text'),
	'open_date_human', 
	'close_date_human'
];
$endpoint = 'api/assessments/get_student?session='.$session.'&semester='.$semester.'&trashed=0';
ajax_table('data_table', $endpoint, $headers, $columns, ['checker' => false, 'created' => false, 'updated' => false]);