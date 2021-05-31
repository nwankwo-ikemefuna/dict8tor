<div class="container">

	<div class="row">
		<div class="col-12 text-center">
			<h2><?php echo SITE_NAME; ?></h2>
			<p><?php echo SITE_DESCRIPTION; ?></p>
		</div>
	</div>
			
	<hr />

	<div class="row m-t-70">
		<div class="col-12">
			<div class="dict8_note_help">
				<p>Click on the green microphone icon <i class="fa fa-microphone" style="color: green;"></i> to dictate your notes.
				<a href="javascript:;" data-toggle="collapse" data-target="#dict8_help_more" class="text-info">More help</a>.</p>
				<div id="dict8_help_more" class="collapse">
					<ul>
						<li>Microphone permission is required to use <?php echo SITE_NAME; ?>. Select allow when prompted by your browser...</li>
						<li>Internet connectivity is required.</li>
						<li><?php echo SITE_NAME; ?> works on the following browsers: Chrome (desktop and Android mobile), Edge, and Safari (desktop and iOS  mobile).</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-8 main_col">
			<?php
			$attrs = ['id' => 'dict8_form'];
			xform_open('api/web/note_actions', $attrs); ?>
				<div class="speech2text_section">
					<textarea name="note" id="s2t_dict8_note" class="form-control" rows="17"></textarea>
					<?php echo speech2text('s2t_dict8_note', 'textarea'); ?>
				</div>
				<?php
			xform_notice('status_msg', '', false);
			?>
			<button type="button" class="btn btn-secondary btn-sm" id="copy_note"><i class="fa fa-copy"></i> Copy Note</button>
			<button type="button" class="btn btn-info btn-sm note_action" data-action="export_pdf" ><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
			<!-- <button type="button" class="btn btn-secondary btn-sm note_action" data-action="save"><i class="fa fa-save"></i> Save Note</button> -->
			<?php
			xform_close();
			?>
		</div>
		<div class="col-12 col-md-4 right_col">
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
				<div class="card custom_ad">
					<div class="card-body">
						<h5 class="card-title"><?php echo $ad['title']; ?></h5>
						<p class="card-text"><?php echo $ad['content']; ?></p>
						<a href="<?php echo $ad['button_link']; ?>" class="btn btn-secondary btn-sm" target="_blank"><?php echo $ad['button_text']; ?></a>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>

	<hr />

	<div class="row">
		<div class="col-12 text-center">
			<?php echo web_share_icons(base_url(''), SITE_DESCRIPTION, 'share-wrap', 'social-icons share', true); ?>
		</div>
	</div>

</div>