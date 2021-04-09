<div class="row">
	<div class="<?php echo grid_col(12, 5); ?>">
		<?php 
		data_show_grid('Role', $row->name);
		data_show_grid('User Count', $row->employee_count);
		?>
	</div>
</div>
<h5>Applicable Permissions</h5>
<div class="row">
	<?php 
	foreach ($modules as $module) {
		$role_rights = json_decode($row->rights, true)[$module->id] ?? [];
		if (empty($role_rights)) continue;
		?>
		<div class="col-12 col-sm-6 col-md-3 p-b-20">
			<div class="card bg-light">
				<div class="card-header text-bold"><?php echo $module->title; ?></div>
				<div class="card-body">
					<?php
					$m_rights = split_us($module->rights);
					foreach ($m_rights as $right) { 
						$_checked = in_array($right, $role_rights);
						xform_check(RIGHTS[$right], '', 'checkbox', '', '', $_checked, '', '', ['disabled' => '']);
					} ?>
				</div>
			</div>
		</div>
		<?php 
	} ?>
</div>