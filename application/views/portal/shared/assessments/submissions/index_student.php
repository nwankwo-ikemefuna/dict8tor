<p class="mb-3">Your <b><?php echo $semester; ?> semester, <?php echo session_slash($session); ?> session</b> results will appear here when they have been published.</p>

<?php
$headers = ['Course' => ['class' => 'min-w-200'], 'Assessment' => ['class' => 'min-w-200'], 'Total Questions', 'Total Attempted', 'Correct Attempts', 'Score Obtained', 'Percentage Score', 'Date Published' => ['class' => 'min-w-200']
];
$columns = [
	'course',
	'assessment',
	dt_dumb_column('to_answer_val'),
	dt_dumb_column('total_attempted'),
	dt_dumb_column('correct_attempts'),
	dt_dumb_column('total_mark'),
	dt_dumb_column('percentage_score'),
	'publish_time_human', 
];
$endpoint = 'api/assessment_submissions/get_student_results?session='.$session.'&semester='.$semester.'&trashed=0';
ajax_table('data_table', $endpoint, $headers, $columns, ['checker' => false, 'actions' => false, 'created' => false, 'updated' => false]);
