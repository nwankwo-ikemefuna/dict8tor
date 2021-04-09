<style>
	#ass_question tr td img{
		width:auto;
		height:auto;
	}
</style>
<?php
if ($row->type != ASS_QT_ESSAY) { ?>
	<hr />
	<h3 class="text-bold">Answer</h3>
	<?php
}
//objective ?
if (in_array($row->type, [ASS_QT_SINGLE, ASS_QT_MULT])) { ?>
	<table class="table" id="ass_question">
		<thead>
			<tr>
				<th>Options</th>
				<th>Answer</th>
			</tr>
		</thead>
		<tbody>

			<?php
			$options_obj = json_decode($row->options);
		    foreach ($options_obj as $key => $option) {
		    	if ($row->type == ASS_QT_SINGLE) { //single answer
                    $answer = $row->answer == $key ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                } else { //multiple answers
                    $answers_arr = (array) explode(",", $row->answer);
                    $answer = in_array($key, $answers_arr) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                } ?>
                <tr>
                    <td><?php echo $option; ?></td>
                    <td><?php echo $answer; ?></td>
			    </tr>
		    <?php } ?>
			
		</tbody>
	</table>
	<?php
} else { 
	//free response type
	echo $row->answer; 
} ?>