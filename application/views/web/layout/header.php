<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo site_meta($page_title, $meta_info); ?>

	<!-- Google Web Fonts
	================================================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CLato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

	<!-- CSS theme files
	============================================ -->
	<link href="<?php echo base_url(); ?>assets/vendors/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Font Awesome 4.7 -->
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Summernote -->
    <link href="<?php echo base_url(); ?>assets/vendors/summernote/summernote-bs4.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Toast -->
    <link href="<?php echo base_url(); ?>assets/vendors/toast/toast.min.css" rel="stylesheet" type="text/css" media="all"/>
    
    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>assets/common/css/bs-switch.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/common/css/helper.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/web/custom/css/speech2text.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/web/custom/css/styles.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/web/custom/css/theme-dark.css" rel="stylesheet" type="text/css" media="all" />

    <?php echo adsense_publisher_script(); ?>

</head>
<body>

<div class="site-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2><span class="site_name"><?php echo SITE_NAME; ?></span></h2>
                <p><?php echo SITE_DESCRIPTION; ?></p>
            </div>
            <div class="col-12 text-center">
                <?php echo form_custom_switch('Dark Mode', '', 'success', 'theme_switcher', 1, false, false, ['with_padding' => true]); ?>
            </div>
        </div>
                
        <hr />

        <div class="row m-t-70">
            <div class="col-12 col-md-8 main_col">