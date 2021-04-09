<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo site_meta($page_title); ?>

    <!-- Vendors -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>vendors/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Font Awesome 4.7 -->
    <link href="<?php echo base_url(); ?>vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
    
    <!-- Template styles -->
    <link href="<?php echo base_url(); ?>assets/portal/template/css/main.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/portal/template/css/color-settings.css" rel="stylesheet" type="text/css" media="all" data-role="color-settings"/>
    <link href="<?php echo base_url(); ?>assets/portal/template/css/guest.css" rel="stylesheet" type="text/css" media="all"/>

    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>assets/common/css/helper.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/portal/custom/css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body class="nav-md theme-green">

    <div class="main-container login-register">
        <div class="d-flex justify-content-center w-100 align-items-center">
            <div class="login-container">
                <div class="form-container">
                    <div class="text-center">
                        <a class="site-title navbar-brand site-logo" title="<?php echo SITE_NAME; ?>" href="<?php echo base_url(); ?>"><img class="login_logo" alt="<?php echo SITE_NAME; ?>" src="<?php echo base_url(SITE_LOGO_PORTAL); ?>"></a>
                    </div>
                    <h5 class="text-center text-bold"><?php echo $page_title; ?></h5>
                    <?php echo flash_message('success_msg'); ?>
                    <?php echo flash_message('error_msg', 'danger'); ?>