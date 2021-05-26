<div class="row">
	<div class="col-12 col-md-8">
		<?php
		$attrs = [
			'id' => 'dict8_form',
			'class' => 'ajax_form',
			'data-type' => 'none',
			'data-redirect' => '_void',
			'data-clear' => 1,
			'data-msg' => ''
		];
		xform_open('api/web/dictate', $attrs); ?>
		<textarea class="summernote" name="content" placeholder="Say your stuff here" required></textarea>
		<?php
		xform_notice('status_msg', '', false);
		?>
		<button type="submit" class="btn btn-success btn-primary dict8_btn" data-type="save"><i class="fa fa-save"></i> Save Content</button>
		<button type="button" class="btn btn-success btn-default" data-type="copy"><i class="fa fa-copy"></i> Copy Content</button>
		<button type="button" class="btn btn-success btn-default" data-type="export"><i class="fa fa-copy"></i> Export to PDF</button>
		<?php
		xform_close();
		?>
	</div>
	<div class="col-12 col-md-4">
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
			<div class="card">
				<div class="card-body">
					<h5 class="card-title"><?php echo $ad['title']; ?></h5>
					<p class="card-text"><?php echo $ad['content']; ?></p>
					<a href="<?php echo $ad['button_link']; ?>" class="btn btn-primary"><?php echo $ad['button_text']; ?></a>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>