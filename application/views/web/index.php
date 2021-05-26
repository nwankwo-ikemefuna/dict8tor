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
			<p class="dict8_note_help">Click on the green microphone icon <i class="fa fa-microphone" style="color: green;"></i> to dictate your notes.</p>
		</div>
		<div class="col-12 col-md-8 main_col">
			<?php
			$attrs = [
				'id' => 'dict8_form',
				'class' => 'ajax_form',
				'data-type' => 'none',
				'data-redirect' => '_void',
				'data-clear' => 1,
				'data-msg' => ''
			];
			xform_open('api/web/save_note', $attrs); ?>
			<div class="speech2text_section s2t_summernote">
				<textarea class="summernote_simple" name="note" id="dict8_note" placeholder="Say your stuff here" required></textarea>
				<?php echo speech2text('dict8_note', 'textarea'); ?>
			</div>
			<?php
			xform_notice('status_msg', '', false);
			?>
			<button type="button" class="btn btn-secondary btn-sm save_note_btn" data-type="copy"><i class="fa fa-copy"></i> Copy Note</button>
			<button type="button" class="btn btn-info btn-sm save_note_btn" data-type="export"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
			<!-- <button type="submit" class="btn btn-secondary btn-sm save_note_btn" data-type="save"><i class="fa fa-save"></i> Save Note</button> -->
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