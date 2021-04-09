<?php 
 if (!empty($questions)) { ?>
	<p>To sort, drag the question to a desired position. Please use a computer as this feature might not work as expected on a mobile device.</p>
	<div class="row">
		<div class="col-xs-12 col-md-8">
			<?php 
			xform_open('api/assessment_questions/sort', xform_attrs());
				xform_notice();
				xform_input('ass_id', 'hidden', $ass_id); ?>
				<div id="_sortable">
					<?php
					foreach ($questions as $row) {
						//if questions, use first 8 words as title
						$title = word_limiter(strip_tags($row->question), 8);
						xform_sortable($title, $row->order, $row->id);
					} ?>
				</div>
				<?php
			xform_close(); ?>
		</div>
	</div>
	<?php 
} ?>

<script type="text/javascript">
	$(document).ready(function() {
	    //sortable
		$("#_sortable").sortable({
			cursor: 'move'
		});
	});
</script>