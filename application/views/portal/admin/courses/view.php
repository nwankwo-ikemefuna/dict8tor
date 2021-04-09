<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('Name', $row->name);
		data_show_grid('Code', $row->code);
		data_show_grid('Department', $row->department);
		data_show_grid('Order', $row->order);
		data_show_grid('Total Classes Offering', $row->total_classes);
		?>
	</div>
	<div class="<?php echo grid_col(12, '5?2'); ?>">
		<div class="h-100 bg-white">
            <h4 class="box-title mt-0">Lecturers</h4>
            <ul class="list-new-registrations list-group" data-role="newregistrationslist">
            	<?php
            	if (!$lecturers) {
            		echo '<em>Course has not been allocated to any lecturer</em>';
            	} else {
					foreach ($lecturers as $l_row) { ?>
		                <li class="list-group-item border-0 d-flex align-items-center justify-content-between pt-0" data-role="newregistrationslist">
		                    <a class="d-flex justify-content-between align-items-center">
		                        <div class="img-wrapper float-left"><img src="<?php echo $l_row->avatar; ?>" class="rounded-circle" alt="User Image"></div>
		                        <h5><?php echo $l_row->full_name; ?></h5>
		                    </a>
		                    <?php ajax_page_button('employees/view/'.$l_row->id, '', '', 'View profile', 'user'); ?>
		                </li>
		                <?php 
					} 
				} ?>
            </ul>
        </div>
	</div>
</div>
<?php 
//classes offering
$page = 'view';
require 'classes_offering.php';