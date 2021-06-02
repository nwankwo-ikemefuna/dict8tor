<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//get instance of CodeIgniter's super object
$CI =& get_instance();

//Tables
$tables = $CI->db->list_tables();
foreach ($tables as $table) {
	$const_table = 'T_' . strtoupper($table);	
	define($const_table, $table);
} 

//Modules
$modules = $CI->common_model->get_rows(T_MODULES);
foreach ($modules as $module) {
	//module
	$const_module = 'MOD_' . strtoupper($module->name);
	define($const_module, $module->id);
}

//site info
define('SITE_NAME', 'Dict8tor');
define('SITE_SHORT_NAME', 'Dict8tor');
define('SITE_LOGO',  base_url('assets/common/img/logo/logo.png'));
define('SITE_LOGO_PORTAL',  base_url('assets/common/img/logo/logo.png'));
define('SITE_LOGO_WEB',  base_url('assets/common/img/logo/logo.png'));
define('SITE_FAVICON', base_url('assets/common/img/logo/favicon.ico'));
define('SITE_LOCATION', 'Lagos, Nigeria');
define('SITE_TAGLINE', 'Save time by dictating notes rather than typing them');
define('SITE_DESCRIPTION', SITE_NAME.' helps you save time and boost productivity by letting you dictate your notes rather than typing them. An easy-to-use tool for individuals including but not limited to students, office secretaries, typists, transcriptionists and stenographers, and for all kinds of business needs.');
define('SITE_AUTHOR', 'Valkay');
define('SITE_AUTHOR_URL', 'https://linkedin.com/in/ikemefunanwankwo');

//mails
define('SITE_NOTIF_MAIL', 'info@dict8tor.com');

//usergroups
define('ADMIN', 1);
define('ALL_USERS', [ADMIN]);

// User Rights 
define('VIEW', 1);
define('ADD', 2);
define('EDIT', 3);
define('DEL', 4);
define('RIGHTS', [
	VIEW 	=> 'View',
	ADD 	=> 'Add',
	EDIT 	=> 'Edit',
	DEL 	=> 'Delete',
]);

//avatar
define('AVATAR_GENERIC', 'assets/common/img/avatar/generic.png');
define('AVATAR_MALE', 'assets/common/img/avatar/male.png');
define('AVATAR_FEMALE', 'assets/common/img/avatar/female.png');
define('IMAGE_404', 'assets/common/img/icons/not_found.png');

define('ACC_STATUSES', [0 => 'Inactive', 1 => 'Active']);
define('ACC_STATUSES_STYLED', [0 => '<span class="text-danger">Inactive</span>', 1 => '<span class="text-success">Active</span>']);

//misc
define('SEX_MALE', 1);
define('SEX_FEMALE', 2);
define('C_NIGERIA_ID', 135); //countries.id (Nigeria)
define('CRS_ID', 10); //states.id (Cross River)
define('SMS_RATE', 3.5);
define('CU_NAIRA', '&#8358;');
define('VISITOR_COUNTRY', ip_info_safe("Visitor", "Country"));
define('IN_NIGERIA', (VISITOR_COUNTRY == 'Nigeria'));