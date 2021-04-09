<p class="text-muted">Only registered candidates can access and take this test.</p>
<h5 class="mb-3">Registered Candidates: <?php echo $total_candidates; ?></h5>

<?php
$headers = ['ID', 'Name' => ['class' => 'min-w-200'], 'Registration ID', 'Mobile No.', 'Department', 'Class'];
$columns = [
	'id', 
	dt_dumb_column('student_name'),
	'username', 
	'phone', 
	'department', 
	'class',
	//hidden
	dt_hidden_column('last_name'), 
	dt_hidden_column('first_name'),
	dt_hidden_column('other_name'),
];
$endpoint = 'api/assessments/get_registered_candidates?id='.$id;
ajax_table('data_table', $endpoint, $headers, $columns, ['checker' => false, 'actions' => false, 'created' => false, 'updated' => false]);