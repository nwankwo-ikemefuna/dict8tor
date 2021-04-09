<?php
xform_open('api/permissions/'.$page, xform_attrs());
	xform_notice();
	?>
	<div class="row">
		<div class="<?php echo grid_col(12, '', 5); ?>">
			<?php 
			if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
			xform_group_list('Role', 'name', 'text', adit_value($row, 'name'), true, ['class' => 'to_clear', 'placeholder' => 'e.g. Content Creator']);
			?>
		</div>
	</div>

	<h5>Select applicable permissions for this role.</h5>
	<div class="row">
		<?php 
		foreach ($modules as $module) {?>
			<div class="col-12 col-sm-6 col-md-3 p-b-20">
				<div class="card bg-light">
					<div class="card-header text-bold"><?php echo $module->title; ?></div>
					<input type="hidden" name="module_idx[]" value="<?php echo $module->id?>">
					<div class="card-body">
						<?php
						$role_rights = ($page == 'edit') ? (json_decode($row->rights, true)[$module->id] ?? []) : [];
						$m_rights = split_us($module->rights);
						foreach ($m_rights as $right) { 
							$name = "rights[{$module->id}][{$right}]";
							$_id = "rights_".$module->id."_".$right;
							$_checked = ($page == "edit" && in_array($right, $role_rights));
							xform_check(RIGHTS[$right], $name, 'checkbox', $_id, $right, $_checked);
						} ?>
					</div>
				</div>
			</div>
			<?php 
		} ?>
	</div>
	<?php
xform_close();