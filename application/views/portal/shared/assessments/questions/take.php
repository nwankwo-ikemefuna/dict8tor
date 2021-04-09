<?php
$question_count = count($questions);
//array letters for the options. 
$letters = range('A', 'Z');

xform_open('api/assessment_submissions/submit', xform_attrs());
	xform_input('ass_id', 'hidden', $ass_id);
	xform_input('q_id', 'hidden', $row->id);
	xform_input('q_type', 'hidden', $row->type);
	xform_input('session', 'hidden', $row->session);
	xform_input('semester', 'hidden', $row->semester);
	$name = "response";
	?>
	<div class="ass_item m-t-30">
		<?php
	    //objective type
		if (in_array($row->type, [ASS_QT_SINGLE, ASS_QT_MULT])) {
			$input_type = $row->type == ASS_QT_SINGLE ? 'radio' : 'checkbox';
			$student_answers_arr = strlen($row->response) ? (array) explode(',', $row->response) : [];
			$options = json_decode($row->options, true);
			$j = 1;
	        foreach ($options as $key => $option) { 
	        	$checked = false;
	        	if (in_array($key, $student_answers_arr)) {
    				$checked = true;
				}
	        	$_id = "response_{$j}";
	        	xform_check('<b>'.$letters[$key].'.</b> '.$option, 'obj_'.$name, $input_type, $_id, $key, $checked, false, false, ['class' => 'response_check chk_rad_16', 'bold' => false]);
	        	$j++;
	        }
	        xform_input($name, 'hidden', $row->response, false, ['class' => 'response_obj']);
		} else {
			if ($row->type == ASS_QT_SHORT) {
				//free response short answer
				$input_type = 'text';
				xform_input($name, $input_type, $row->response);
			} else {
				//free response essay
				xform_input($name, 'textarea', strip_tags($row->response));
			}
		} ?>
	</div>
	<?php 
xform_close();