<h3 class="text-bold">Step 1: Import Data</h3>
<div class="row">
	<div class="col-md-9 table-scroll">

		<h3>Import Instructions</h3>
		<ul class="adjust-list-left">
			<li>Prepare student data in Excel spreadsheet. 
				<a class="underline-link" href="<?php echo base_url('assets/portal/documents/import_templates/EroodyteStudentTemplate.xlsx'); ?>">Download Template</a>
			</li>
			<li>Ensure only one worksheet exists in workbook.</li>
			<li>Type the titles on ROW 1 of worksheet.</li>
			<li>Enter the data, starting from ROW 2.</li>
			<li>Ensure consecutive rows have data to avoid importing empty rows.</li>
			<li>Organize the student data in the format below, making sure to follow stipulated rules.</li>
		</ul>

		<div class="">
			<h3>Format of Excel Worksheet</h3>
			<table class="table table_row_bordered dt_table table-hover cell-text-middle" style="text-align: left">
				<thead>
					<tr>
						<th class="w-5"> Column </th>
						<th class="w-25"> Data </th>
						<th class="w-20"> Rule(s) </th>
						<th class="w-35"> Additional Information </th>
						<th class="w-15"> Example </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>A</td>
						<td>Admission/Registration ID</td>
						<td>Required</td>
						<td></td>
						<td>PHC/2017/0001</td>
					</tr>
					<tr>
						<td>B</td>
						<td>Last Name</td>
						<td>Required</td>
						<td></td>
						<td>Benson</td>
					</tr>
					<tr>
						<td>C</td>
						<td>First Name</td>
						<td>Required</td>
						<td></td>
						<td>David</td>
					</tr>
					<tr>
						<td>D</td>
						<td>Other Name</td>
						<td>Optional</td>
						<td></td>
						<td>Adekunle</td>
					</tr>
					<tr>
						<td>E</td>
						<td>Sex</td>
						<td>Required</td>
						<td>Male/M or Female/F</td>
						<td>Female</td>
					</tr>
					<tr>
						<td>F</td>
						<td>Date of Birth (DOB)</td>
						<td>Optional</td>
						<td>Format: DD/MM/YYYY</td>
						<td>26/08/1997</td>
					</tr>
					<tr>
						<td>G</td>
						<td>Phone No.</td>
						<td>Required</td>
						<td>Include country code</td>
						<td>2347000000001</td>
					</tr>
					<tr>
						<td>H</td>
						<td>Email</td>
						<td>Optional</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>I</td>
						<td>Class ID</td>
						<td>Optional</td>
						<td>Current Class ID of student. See <?php ajax_page_link('classes', 'classes', 'underline-link'); ?> for a list of your school's classes and their corresponding class IDs.</td>
						<td>39</td>
					</tr>
					<tr>
						<td>J</td>
						<td>Nationality</td>
						<td>Optional</td>
						<td></td>
						<td>Nigerian</td>
					</tr>
					<tr>
						<td>K</td>
						<td>State of Origin</td>
						<td>Optional</td>
						<td></td>
						<td>Lagos</td>
					</tr>
					<tr>
						<td>L</td>
						<td>Additional Information</td>
						<td>Optional</td>
						<td>Any extra information not captured in the fields above</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!--/.col-->

	<div class="col-md-3">
		<?php
		xform_open_multipart('api/student_import/add', xform_attrs()); ?>
			<div class="form-group">
				<h3>Import Records</h3>
				<small>Only Excel files allowed (max. 5MB)</small>
				<input type="file" name="excel_file" class="form-control" accept=".xls,.xlsx" required />
			</div>
			<?php 
			xform_notice();
			xform_submit('Import', '', ['class' => 'btn-lg']);
		xform_close(); ?>
		<div class="f-s-17 m-t-30 text-bold">Note</div>
		In step 2, you can review imported student data before submitting to students list.
	</div>

</div><!--/.row-->