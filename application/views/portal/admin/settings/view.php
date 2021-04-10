<div class="row">
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Address', $setting->address);
		data_show_grid('Phone Number', $setting->phone);
		data_show_grid('Email Address', $setting->email);
		?>
	</div>
	<div class="<?php echo grid_col(12, 6); ?>">
		<?php 
		data_show_grid('Phase', $setting->phase);
		data_show_grid('Default Language', ucfirst(DEFAULT_LANGUAGE));
		?>
	</div>
</div>

<?php
$languages = get_site_languages();
?>

<div class="row">
	<div class="col-md-12">
		<h4>Language-dependent Site Information</h4>
		<div class="table_scroll">
			<table class="table">
				<thead>
					<tr>
						<th>Information</th>
						<?php
						foreach ($languages as $lang) { ?>
							<th><?php echo $lang['title']; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					$lang_info_arr = json_decode($row->lang_info, true) ?? [];
					$lang_keys_arr = array_keys($lang_info_arr);
					foreach ($lang_keys_arr as $key) { ?>
						<tr>
							<td><?php echo humanize($key); ?></td>
							<?php
							foreach ($languages as $lang) { ?>
								<th><?php echo $lang_info_arr[$key][$lang['key']]; ?></th>
								<?php
							}
							?>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>