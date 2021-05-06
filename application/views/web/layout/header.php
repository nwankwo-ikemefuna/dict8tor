<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo site_meta($page_title, $meta_info); ?>

	<!-- Google Web Fonts
	================================================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CLato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

	<!-- Vendor CSS
	============================================ -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/font/linea-basic/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/font/linea-ecommerce/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/font/linea-arrows/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/plugins/fancybox/jquery.fancybox.css">

	<!-- CSS theme files
	============================================ -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/css/fontello.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/web/template/css/responsive.css">
    
    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>assets/common/css/helper.css" rel="stylesheet" type="text/css" media="all" />
    <!-- <link href="assets/web/custom/css/style.css" rel="stylesheet" type="text/css" media="all" /> -->

</head>
<body>

	<!-- <div class="loader"></div> -->
	
	<!-- - - - - - - - - - - - - - Wrapper - - - - - - - - - - - - - - - - -->
	<div id="wrapper" class="wrapper-container">

		<!-- - - - - - - - - - - - - Mobile Menu - - - - - - - - - - - - - - -->
		<nav id="mobile-advanced" class="mobile-advanced"></nav>

		<header id="header" class="sticky-header fixed-header">
			<!-- top-header -->
			<div class="top-header">

				<!-- logo -->		
				<div class="logo-wrap">
					<a href="<?php echo base_url(); ?>" class="logo"><img src="<?php echo base_url(SITE_LOGO_WEB); ?>" alt="<?php echo SITE_NAME; ?>"></a>
				</div>

				<!--main menu-->
				<div class="menu-holder">
					<div class="menu-wrap">
						<div class="nav-item">
							<nav id="main-navigation" class="main-navigation">
								<ul id="menu" class="clearfix">
									<li class="<?php echo active_link($current_page, 'home', 'current'); ?>"><a href="<?php echo base_url(); ?>"><?php echo lang_string('home'); ?></a></li>
									<li class="<?php echo active_link($current_page, 'about', 'current'); ?>"><a href="<?php echo base_url('about'); ?>"><?php echo lang_string('about'); ?></a></li>
									<li class="<?php echo active_link($current_page, 'videos', 'current'); ?>"><a href="<?php echo base_url('videos'); ?>"><?php echo lang_string('videos'); ?></a></li>
									<li class="<?php echo active_link($current_page, 'blog', 'current'); ?>"><a href="<?php echo base_url('blog'); ?>"><?php echo lang_string('blog'); ?></a></li>
									<?php
									if ($this->site_info->show_language_options) { ?>
										<li>
											<div class="lang-section">
												<?php
												$site_languages = get_site_languages();
												foreach ($site_languages as $lang) { ?>
													<a href="javascript:;" class="switch_language <?php echo ($this->session->active_language == $lang['key']) ? 'active' : ''; ?>" data-lang="<?php echo $lang['key']; ?>"><?php echo $lang['alias']; ?></a>
													<?php
												}
												?>
											</div>
										</li>
										<?php
									} ?>
								</ul>
							</nav>
							<?php
							if ($this->is_campaign_phase) { ?>
								<a href="javascript:;" class="btn btn-style-6 btn-big donate_btn"><?php echo lang_string('donate'); ?></a>
								<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</header>