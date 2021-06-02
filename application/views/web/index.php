<div class="container">

	<div class="row">
		<div class="col-12 text-center">
			<h2><span class="site_name"><?php echo SITE_NAME; ?></span></h2>
			<p><?php echo SITE_DESCRIPTION; ?></p>
		</div>
	</div>
			
	<hr />

	<div class="row m-t-70">

		<div class="col-12 col-md-8">
			<div class="dict8_note_help">
				<p>Click on the green microphone icon <i class="fa fa-microphone" style="color: green;"></i> to dictate your notes. Start dictating when it turns red <i class="fa fa-microphone" style="color: red;"></i> and pulsating. Click on it again to pause/stop dictating.
				<a href="javascript:;" data-toggle="collapse" data-target="#dict8_help_more" class="text-info with_arrow_double_updown">More help <i class="fa fa-angle-double-down arrow_double_updown"></i></a></p>
				<div id="dict8_help_more" class="collapse">
					<ul>
						<li>Microphone permission is required to use <?php echo SITE_NAME; ?>. Select allow when prompted by your browser.</li>
						<li>Internet connectivity is required.</li>
						<li><?php echo SITE_NAME; ?> works on the following browsers: Chrome desktop (recommended for best experience), Chrome Adroid, Android Browser, Edge, Samsung Internet.</li>
						<li>To add punctuations (such as period, comma, colon, semicolon, question mark, quotes, apostrophe, etc), space or any special character, stop dictating and type the character.</li>
						<li>Copy your notes or export to PDF and download when done. You may also save for later.</li>
						<li>Your notes are saved in the box even if you refresh this page or close your browser, unless you deliberately clear them.</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-8 main_col">
			<?php
			$attrs = ['id' => 'dict8_form', 'class' => 'm-b-50'];
			xform_open('api/web/note_actions', $attrs); ?>
				<div class="speech2text_section speech2text_interim_wrapper">
					<textarea name="note" id="s2t_dict8_note" class="form-control" rows="17"></textarea>
					<?php echo speech2text('s2t_dict8_note', 'textarea', '', true); ?>
					<span class="final_output"></span>
					<span class="interim_output"></span>
				</div>
				<?php
			xform_notice('status_msg', '', false);
			?>
			<button type="button" class="btn btn-secondary btn-sm btn-confident clickable" id="copy_note" title="Copy notes to clickboard"><i class="fa fa-copy"></i> Copy</button>
			<button type="button" class="btn btn-info btn-sm note_action btn-confident clickable" data-action="export_pdf" title="Export notes to PDF and download"><i class="fa fa-file-pdf-o"></i> PDF</button>
			<button type="button" class="btn btn-success btn-sm btn-confident clickable" id="save_note" title="Save notes for later"><i class="fa fa-save"></i> Save</button>
			<button type="button" class="btn btn-danger btn-sm btn-confident clickable" id="clear_note" title="Clear notes field"><i class="fa fa-trash-o"></i> Clear</button>
			<?php
			xform_close();
			?>

			<hr />

			<div class="row m-t-50">
				<div class="col-12 text-center">
					<?php echo web_share_icons(base_url(''), SITE_DESCRIPTION, 'share-wrap', 'social-icons share', true); ?>
				</div>
			</div>

		</div>

		<div class="col-12 col-md-4 right_col">

			<div class="card m-b-20" id="saved_notes_section" style="display: none;">
				<div class="card-header">
					<h5 class="card-title">My Saved Notes</h5>
				</div>
				<div class="card-body">
					<div id="saved_notes"></div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-danger btn-sm btn-confident clickable" id="delete_all_saved_notes" title="Delete all saved notes"><i class="fa fa-trash-o"></i> Delete All</button>
				</div>
			</div>

			<?php
			$custom_ads_arr = [
				[
					'title' => 'Manage your school efficiently', 
					'content' => 'Quick School Manager (QSM) is a cloud based school management system that makes managing educational institutions easy and efficient.', 
					'button_text' => 'Learn more',
					'button_link' => 'https://qschoolmanager.com/',
				],
				[
					'title' => 'Earn money while browsing', 
					'content' => 'Get paid for using your data on the internet.', 
					'button_text' => 'Learn more',
					'button_link' => 'https://refer.gener8ads.com/r/Cn67x6',
				],
			];
			foreach ($custom_ads_arr as $ad) { ?>
				<div class="card m-b-20">
					<div class="card-body">
						<h5 class="card-title"><?php echo $ad['title']; ?></h5>
						<p class="card-text"><?php echo $ad['content']; ?></p>
						<a href="<?php echo $ad['button_link']; ?>" class="btn btn-info btn-sm btn-confident" target="_blank"><?php echo $ad['button_text']; ?></a>
					</div>
				</div>
				<?php
			}
			?>
		</div>

	</div>

</div>