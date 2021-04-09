<p class="text-muted">Only registered candidates can access and take this test.</p>
<h5>Registered Candidates: <?php echo $total_candidates; ?></h5>

<div class="row">	
	<div class="col-12 col-lg-4 class_dept_wrapper">
		<?php
		xform_input('ass_id', 'hidden', $id);
		xform_group_list('Department', 'dept_id', 'select', '', false, 
		    ['options' => $this->session->_departments, 'text_col' => 'name', 'extra' => ['class' => 'select_dept_id']]
		); 
		xform_group_list('Class', 'class_id', 'select', '', false, ['options' => [], 'extra' => ['class' => 'select_class_id']]);
		xform_submit('Fetch Students', '', ['id' => 'fetch_class_candidates', 'class' => 'text-white m-t-15']);
		?>
	</div>
	<?php 
	if ($this->session->user_is_dev) { ?>
		<div class="col-12 col-lg-3 offset-lg-1">
			<?php
			xform_open('api/assessments/register_all_candidates', xform_attrs('register_all_candidates_form', 'redirect', '_ajax_dynamic', '', 'status_msg_reg_all', 1, 'Registering candidates... Please wait'));
				xform_input('id', 'hidden', $id);
				xform_notice('status_msg_reg_all'); 
				xform_submit('Register All Candidates', '', ['class' => 'text-white m-t-15']);
			xform_close();
			?>
		</div>
		<div class="col-12 col-lg-3 offset-lg-1">
			<?php
			//retake candidates
			xform_open('api/assessments/register_retake_candidates', xform_attrs('register_retake_candidates_form', 'none', '_void', '', 'status_msg_retake', 1, 'Registering retake candidates... Please wait')); ?>
				<div class="form-group">
					<h6>Register Retake Candidates</h6>
					<small>Only Excel files allowed (max. 5MB)</small>
					<input type="file" name="excel_file" class="form-control" accept=".xls,.xlsx" required />
				</div>
				<?php 
				xform_input('id', 'hidden', $id);
				xform_notice('status_msg_retake', '', false);
				xform_submit('Import & Register', '', ['class' => 'btn-lg']);
			xform_close(); 
			?>
		</div>
		<?php 
	} ?>
</div>

<hr />

<?php
xform_open('api/assessments/register_candidates', xform_attrs());
	xform_input('id', 'hidden', $id);
	xform_check('Register', 'type', 'radio', 'register', 'register', true, true, true);
	xform_check('Unregister', 'type', 'radio', 'unregister', 'unregister', false, true, true);
	xform_notice(); ?>

	<div class="row">	
		<div class="col-12 table-scroll">
			<table id="table" class="table table_row_bordered dt_table table-hover cell-text-middle" style="text-align: left">
				<thead>
					<tr>
						<th class="w-10-p">#</th>
						<th class="w-10-p"><?php xform_check_all(); ?></th>
						<th class="min-w-200">Student Name</th>
						<th>Registration ID</th>
						<th>Department</th>
						<th>Class</th>
						<th>Registered</th>
					</tr>
				</thead>
				<tbody id="class_candidates">
					<!-- Render class students via ajax -->
				</tbody>
			</table>
		</div>
	</div>
	<?php 
xform_close();