<div class="media-holder full-src style-2" data-bg="<?php echo base_url('uploads/pix/info/'.$this->site_info->poster_photo); ?>">
	<div class="media-inner">
		<h1><span class="media-inner-title"><?php echo $this->site_info->campaign_line; ?></span></h1>
		<div class="join-us style-3">
			<p><?php echo lang_string('subscribe_to_be_updated'); ?></p>
			<?php
			$attrs = [
				'id' => 'subscribe_form', 
				'class' => 'ajax_form join-form', 
				'data-type' => 'none', 
				'data-redirect' => '_void', 
				'data-clear' => 1,
				'data-msg' => lang_string('subscription_thank_you')
			];
			xform_open('api/web/subscribe', $attrs); ?>
				<button type="submit" class="btn btn-style-4 btn-big f-right"><?php echo lang_string('subscribe'); ?></button>
				<div class="input-holder">
					<input type="email" name="email" placeholder="<?php echo lang_string('email_address'); ?>" required>
					<input type="text" name="phone" placeholder="<?php echo lang_string('phone'); ?>" required>
				</div>
				<?php
				xform_notice('status_msg', '', false);
			xform_close(); ?>
		</div>
	</div>
	<?php
	if ($this->candidate_info->sm_facebook || $this->candidate_info->sm_twitter || $this->candidate_info->sm_instagram) { ?>
		<ul class="social-icons style-2 v-type">
			<?php
			if ($this->candidate_info->sm_facebook) { ?>
				<li><a href="<?php echo $this->candidate_info->sm_facebook; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
				<?php 
			}
			if ($this->candidate_info->sm_twitter) { ?>
				<li><a href="<?php echo $this->candidate_info->sm_twitter; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
				<?php 
			}
			if ($this->candidate_info->sm_instagram) { ?>
				<li><a href="<?php echo $this->candidate_info->sm_instagram; ?>" target="_blank"><i class="icon-instagram-5"></i></a></li>
				<?php 
			} ?>
		</ul>
		<?php 
	} ?>
</div>

<?php
if ($this->is_campaign_phase && $priorities) { ?>
	<div class="page-section-bg2">
		<div class="container extra-size">
			<div class="row">
				<div class="col-sm-4">
					<h6 class="section-sub-title"><?php echo lang_string('main_issues'); ?></h6>
					<h2 class="section-title"><?php echo $this->candidate_info->display_name_short; ?>'s <?php echo lang_string('priorities'); ?></h2>
					<p><?php echo lang_string('#priority_intro'); ?></p>
					<a href="<?php echo base_url('issues'); ?>" class="info-btn hide"><?php echo lang_string('read_more'); ?></a>
				</div>
				<div class="col-sm-8">
					<div class="icons-box">
						<div class="row flex-row">
							<?php 
							foreach ($priorities as $row) { ?>
								<div class="col-md-3 col-xs-6">
									<div class="icons-wrap">
										<div class="icons-item">
											<a href="javascript:;" class="item-box">
												<i class="icon-<?php echo $row->icon; ?>"></i>
												<h5 class="icons-box-title"><span><?php echo $row->title; ?></span></h5>
											</a>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>

<div class="page-section type2">
	<div class="container extra-size">
		<div class="row type-2">
			<div class="col-md-6 col-sm-12">
				<div class="intro_video_section">
					<a href="<?php echo youtube_embed_url($this->site_info->intro_video); ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0" data-fancybox="video" title="Click to play video">
						<img src="<?php echo base_url('uploads/pix/info/'.$this->site_info->intro_video_placeholder); ?>" alt="<?php echo SITE_NAME; ?>"> 
						<img class="play_icon" src="<?php echo base_url('assets/common/img/icons/play.jpg'); ?>" alt="Play icon">
					</a>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="push-top">
					<h2 class="section-title"><?php echo lang_string('meet'); ?> <?php echo $this->candidate_info->display_name_short; ?></h2>
					<p class="text-size-big"><?php echo $this->site_info->intro_msg; ?></p>
					<a href="<?php echo base_url('about'); ?>" class="btn btn-style-3"><?php echo lang_string('read_more'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php  
if ($this->is_campaign_phase) { ?>
	<div class="action-widget pull-bottom">
		<div class="container extra-size">
			<div class="row flex-row">
				<div class="col-md-12">
					<div class="action-item donate">
						<div class="action-inner">
							<h3 class="action-title size-2"><b><?php echo lang_string('donate_to_campaign'); ?></b></h3>
							<div id="chose-donate" class="chose-donate">
								<?php 
								$donation_amounts = donation_amounts();
								foreach ($donation_amounts as $amount) { ?>
									<button class="chose-item donate_btn" data-amount="<?php echo $amount; ?>"><?php echo get_currency_code().$amount; ?></button>
									<?php
								} ?>
								<a href="javascript:;" class="btn btn-style-4 btn-big donate_btn"><?php echo lang_string('donate'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
}
?>

<?php
if ($timelines) { ?>
	<div class="page-section-bg3">
		<div class="container extra-size2 <?php echo $this->is_campaign_phase ? 'm-t-100' : ''; ?>">
			<h2 class="section-title"><?php echo $this->candidate_info->display_name_short; ?><?php echo lang_string('s_ownership'); ?> <?php echo lang_string('timeline'); ?></h2>
			<div class="tabs tabs-section type-2 horizontal clearfix">
				<!--tabs navigation-->
				<ul class="tabs-nav clearfix">
					<?php
					foreach ($timeline_groups as $grow) { 
						$group_timelines = $timelines[$grow->id] ?? [];
						if (!$group_timelines) continue;
						?>
						<li><a href="#timeline_group_tab_<?php echo $grow->id; ?>"><?php echo $grow->title; ?></a></li>
						<?php
					} ?>
				</ul>
				<!--tabs content-->                 
				<div class="tabs-content">
					<?php
					foreach ($timeline_groups as $grow) { 
						$group_timelines = $timelines[$grow->id] ?? [];
						if (!$group_timelines) continue;
						?>
						<div id="timeline_group_tab_<?php echo $grow->id; ?>">
							<div class="tabs tabs-section type-2 vertical clearfix">
								<!--tabs navigation-->
								<ul class="tabs-nav clearfix">
									<?php
									foreach ($group_timelines as $row) { ?>
										<li><a href="#timeline_tab_<?php echo $row->id; ?>"><?php echo $row->title; ?></a></li>
										<?php
									} ?>
								</ul>
								<!--tabs content-->                 
								<div class="tabs-content">
									<?php
									foreach ($group_timelines as $row) { 
										$photo = $row->photo ? 'uploads/pix/timelines/'.$row->photo : 'uploads/pix/info/'.$this->site_info->about_intro_photo;
										?>
										<div id="timeline_tab_<?php echo $row->id; ?>">
											<div class="row">
												<div class="col-md-6 col-sm-12">
													<img src="<?php echo base_url($photo); ?>" alt="<?php echo $row->title; ?>">
												</div>
												<div class="col-md-6 col-sm-12">
													<?php echo $row->content; ?>
												</div>
											</div>
										</div>
										<?php 
									} ?>
								</div>
							</div>
						</div>
						<?php
					} ?>
				</div>
			</div>
			
		</div>
	</div>
	<?php 
}

if ($recent_posts) { ?>
	<div class="page-section">
		<div class="container extra-size2">
			<h2 class="section-title"><?php echo lang_string('recent_news'); ?></h2>
			<div class="row">
				<div class="col-md-12">
					<div class="events-holder content-element2">
						<?php
						foreach ($recent_posts as $row) { ?>
							<div class="event-item">
								<div class="event-date">
									<div class="event-month"><?php echo date('M', strtotime($row->date_created)); ?></div>
									<div class="event-day"><?php echo date('d', strtotime($row->date_created)); ?></div>
								</div>
								<div class="event-info">
									<div class="row">
										<div class="col-md-3 col-sm-12 col-md-push-9">
											<div class="entry-attachment" style="margin-bottom: -30px;">
												<?php 
												if ($row->featured_video) { ?>
													<div class="responsive-iframe">
														<iframe src="<?php echo $row->featured_video; ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
													</div>
													<?php
												} else { ?>
													<img src="<?php echo base_url('uploads/pix/blog/'.$row->featured_image); ?>" alt="<?php echo $row->title; ?>">
													<?php
												} ?>
											</div>
										</div>
										<div class="col-md-9 col-sm-12 col-md-pull-3">
											<h4 class="event-link">
												<a href="<?php echo blog_article_url($row->date_created, $row->slug); ?>"><?php echo $row->title; ?></a>
											</h4>
											<?php echo article_snippet_word($row->content, 35); ?>
											<p><a href="<?php echo blog_article_url($row->date_created, $row->slug); ?>" class="info-btn"><?php echo lang_string('read_more'); ?></a></p>
										</div>
									</div>
								</div>
							</div>
							<?php
						} ?>
					</div>
					<div class="align-center">
						<a href="<?php echo base_url('blog'); ?>" class="btn"><?php echo lang_string('more_news'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
}

if ($recent_videos) { ?>
	<div class="page-section-bg3">
		<div class="container extra-size2">
			<h2 class="section-title"><?php echo lang_string('recent_videos'); ?></h2>
			<div class="row">
				<div class="col-md-12">
					<div class="isotope two-collumn clearfix portfolio-holder" data-isotope-options='{"itemSelector" : ".item","layoutMode" : "fitRows","transitionDuration":"0.7s","fitRows" : {"columnWidth":".item"}}'>
						<?php
						foreach ($recent_videos as $row) { ?>
							<div class="item">
								<div class="project">
									<div class="project-image">
										<div class="responsive-iframe">
											<iframe src="<?php echo $row->content; ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0" allowfullscreen="true"></iframe>
										</div>
									</div>
								</div>
							</div>
							<?php
						} ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="align-center m-t-30">
						<a href="<?php echo base_url('videos'); ?>" class="btn"><?php echo lang_string('more_videos'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
} 