<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo site_meta($page_title); ?>
    
    <!-- Vendors -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Jquery ui -->
    <link href="<?php //echo base_url(); ?>vendors/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Font Awesome 4.7 -->
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Datatables BS 4 -->
    <link href="<?php echo base_url(); ?>assets/vendors/datatables_bs4/datatables.min.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url(); ?>assets/vendors/datatables_bs4/config.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Tempus Dominus Datetimepicker -->
    <link href="<?php echo base_url(); ?>assets/vendors/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url(); ?>assets/vendors/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Selectpicker -->
    <link href="<?php echo base_url(); ?>assets/vendors/selectpicker/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Summernote -->
    <link href="<?php echo base_url(); ?>assets/vendors/summernote/summernote-bs4.css" rel="stylesheet" type="text/css" media="all"/>
    <!--  PSG Countdown Timer -->
    <link href="<?php echo base_url(); ?>assets/vendors/psg-countdown/css/psgTimer.css" rel="stylesheet" type="text/css" media="all"/>

    <!-- Template styles -->
    <link href="<?php echo base_url(); ?>assets/portal/template/css/main.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/portal/template/css/color-settings.css" rel="stylesheet" type="text/css" media="all" data-role="color-settings"/>
    <link href="<?php echo base_url(); ?>assets/portal/template/css/dashboard.css" rel="stylesheet" type="text/css" media="all"/>

    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>assets/common/css/helper.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/portal/custom/css/style.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body class="nav-md theme-green">
    <div class="main-container">
        <!-- sidebar -->
        <div class="sidebar">
            <div class="scroll-wrapper">
                <div class="navbar nav-title">
                    <a class="site-title navbar-brand site-logo" title="<?php echo site_name(); ?>" href="<?php echo base_url(); ?>"><img alt="<?php echo site_name(); ?> logo" src="<?php echo base_url(SITE_LOGO_PORTAL); ?>"></a> 
                    <a href="<?php echo base_url(); ?>" class="text-white hide">
                        <h5><?php echo site_name('short_name'); ?></h5>
                    </a>
                </div>
                <div class="nav toggle">
                    <a href="javascript:void(0)" id="sidebar-menu-toggle" class="btn btn-circle ripple">
                       <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile-pic">
                        <?php ajax_page_link('user/view', '<img src="'.user_avatar().'" alt="Profile picture" class="rounded-circle profile-img">'); ?>
                    </div>
                    <div class="profile-info">
                        <h2><span class="text-muted">Welcome, </span><?php ajax_page_link('user/view', $this->session->user_first_name); ?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
        
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main-menu-wrapper">
                    <div class="menu-section">
                        <ul class="nav side-menu flex-column">

                            <?php 
                            //general menus upper
                            side_menu('Dashboard', 'user', 'dashboard');

                            //sync data
                            side_menu('Sync Dashboard', 'portal', 'refresh', '', '', false);

                            //settings
                            side_menu_parent_open_auth(MOD_SETTINGS, VIEW, ADMIN, 'Settings', 'cog');
                                side_menu_auth(MOD_SETTINGS, VIEW, ADMIN, 'General Site Info', 'settings/view');
                                side_menu_auth(MOD_SETTINGS, VIEW, ADMIN, 'Phase 1 Info', 'info/view/1');
                                side_menu_auth(MOD_SETTINGS, VIEW, ADMIN, 'Phase 2 Info', 'info/view/2');
                                side_menu_auth(MOD_SETTINGS, VIEW, ADMIN, 'Language Strings', 'language_strings/view');
                            side_menu_parent_close_auth(MOD_SETTINGS, VIEW, ADMIN);

                            //candidates
                            side_menu_parent_open_auth(MOD_CANDIDATES, VIEW, ADMIN, 'Candidates', 'users');
                                side_menu_auth(MOD_CANDIDATES, VIEW, ADMIN, 'Main Candidate', 'candidates/view/1');
                                side_menu_auth(MOD_CANDIDATES, VIEW, ADMIN, 'Support Candidate', 'candidates/view/2');
                            side_menu_parent_close_auth(MOD_CANDIDATES, VIEW, ADMIN);

                            //timelines
                            side_menu_parent_open_auth(MOD_TIMELINES, VIEW, ADMIN, 'Timelines', 'calendar');
                                side_menu_auth(MOD_TIMELINES, VIEW, ADMIN, 'Main Candidate', 'timelines?type=1');
                                side_menu_auth(MOD_TIMELINES, VIEW, ADMIN, 'Support Candidate', 'timelines?type=2');
                                side_menu_auth(MOD_TIMELINES, VIEW, ADMIN, 'Timeline Groups', 'timeline_groups');
                            side_menu_parent_close_auth(MOD_TIMELINES, VIEW, ADMIN);

                            //issue and priorities
                            side_menu_parent_open_auth(MOD_PRIORITIES, VIEW, ADMIN, 'Issues & Priorities', 'tasks');
                                side_menu_auth(MOD_PRIORITIES, VIEW, ADMIN, 'All Issues/Priorities', 'priorities');
                                side_menu_auth(MOD_PRIORITIES, VIEW, ADMIN, 'Add Issue/Priority', 'priorities/add');
                            side_menu_parent_close_auth(MOD_PRIORITIES, VIEW, ADMIN);

                            //blog
                            side_menu_parent_open_auth(MOD_BLOG, VIEW, ADMIN, 'Blog', 'book');
                                side_menu_auth(MOD_BLOG, VIEW, ADMIN, 'Blog Posts', 'posts');
                                side_menu_auth(MOD_BLOG, VIEW, ADMIN, 'Add Post', 'posts/add');
                                side_menu_auth(MOD_BLOG_CATEGORIES, VIEW, ADMIN, 'Blog Categories', 'post_categories/index');
                            side_menu_parent_close_auth(MOD_BLOG, VIEW, ADMIN);

                            //videos
                            side_menu_parent_open_auth(MOD_VIDEOS, VIEW, ADMIN, 'Videos', 'video-camera');
                                side_menu_auth(MOD_VIDEOS, VIEW, ADMIN, 'Videos', 'videoz');
                                side_menu_auth(MOD_VIDEOS, VIEW, ADMIN, 'Add Video', 'videoz/add');
                            side_menu_parent_close_auth(MOD_VIDEOS, VIEW, ADMIN);

                            //hands-on
                            side_menu_parent_open_auth(MOD_HANDS_ON, VIEW, ADMIN, 'Hands-On', 'support');
                                side_menu_auth(MOD_HANDS_ON, VIEW, ADMIN, 'Applications', 'hands_on_applications');
                                side_menu_auth(MOD_HANDS_ON, VIEW, ADMIN, 'Grant Info', 'hands_on_info/view');
                            side_menu_parent_close_auth(MOD_HANDS_ON, VIEW, ADMIN);

                            //subscribers
                            side_menu_parent_open_auth(MOD_SUBSCRIBERS, VIEW, ADMIN, 'Subscribers', 'users');
                                side_menu_auth(MOD_SUBSCRIBERS, VIEW, ADMIN, 'All Subscribers', 'subscribers');
                            side_menu_parent_close_auth(MOD_SUBSCRIBERS, VIEW, ADMIN);

                            //user accounts
                            side_menu_parent_open_auth(MOD_EMPLOYEES, VIEW, ADMIN, 'User Accounts', 'users');
                                side_menu_auth(MOD_EMPLOYEES, VIEW, ADMIN, 'All Users', 'employees');
                                side_menu_auth(MOD_EMPLOYEES, VIEW, ADMIN, 'Add User', 'employees/add');
                                side_menu_auth(MOD_EMPLOYEES, VIEW, ADMIN, 'Roles & Privileges', 'permissions');
                            side_menu_parent_close_auth(MOD_EMPLOYEES, VIEW, ADMIN);
                            
                            //user
                            side_menu_parent_open('My Account', 'user');
                                side_menu('Profile', 'user/view');
                                side_menu('Change Password', 'user/reset_pass');
                                side_menu('Logout', $logout_url, '', '', '', false);
                            side_menu_parent_close();
                            ?>
                            
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
            <div class="sidebar-triangle-wrapper">
                <div class="sidebar-graphic-section">
                    <div class="triangle-1"></div>
                    <div class="triangle-2"></div>
                </div>
            </div>
        </div>
        <!-- /sidebar -->

        <div class="content-wrapper">

            <!-- header content  -->
            <header class="header">
                <nav class="header-menu">
                    <div class="nav toggle">
                        <a href="javascript:void(0)" id="menu-toggle" class="ripple">
                            <span class="bars"></span>
                        </a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="profile-dropdown dropdown">
                            <a href="javascript:void(0)" class="user-profile dropdown-toggle ripple" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo user_avatar(); ?>" alt="Profile picture" class="rounded-circle">
                                <span class="d-none d-sm-block"><?php echo $this->session->user_first_name; ?></span>
                                <span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu float-right">
                                <li class="d-none d-block-xs p-0">
                                    <button type="button" class="close btn btn-circle"><i class="fa fa-close"></i></button>
                                    <div class="profile clearfix">
                                        <div class="profile-pic">
                                            <img src="<?php echo user_avatar(); ?>" alt="Profile picture" class="rounded-circle profile-img">
                                        </div>
                                        <div class="profile-info">
                                            <h2><?php echo $this->session->user_first_name; ?></h2>
                                        </div>
                                    </div>
                                </li>
                                <li><?php ajax_page_link('user/view', '<i class="fa fa-user-o" aria-hidden="true"></i>Profile'); ?></li>
                                <li class="divider"></li>
                                <li><?php ajax_page_link('user/reset_pass', '<i class="fa fa-key" aria-hidden="true"></i>Change Password'); ?></li>
                                 <li class="divider"></li>
                                <li><a href="<?php echo base_url($logout_url); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </header>
            <!-- /header content -->
            
            <div class="user_type">
                <i class="fa fa-user-circle-o m-l-10"></i>
                <?php ajax_page_link('user', $this->session->user_usergroup_title); ?>
                <span class="float-sm-right">
                    
                </span>
            </div>

            <div id="ajax_page_container">