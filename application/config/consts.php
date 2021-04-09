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
$site_info = $CI->site_info;
define('SITE_NAME', $site_info->name);
define('SITE_SHORT_NAME', $site_info->initials);
define('SITE_LOGO', 'uploads/pix/logo/'.$site_info->logo);
define('SITE_LOGO_PORTAL', 'uploads/pix/logo/'.$site_info->logo_portal);
define('SITE_LOGO_WEB', 'uploads/pix/logo/'.$site_info->logo);
define('SITE_FAVICON', 'uploads/pix/logo/'.$site_info->favicon);
define('SITE_LOCATION', $site_info->address);
define('SITE_TAGLINE', $site_info->tagline);
define('SITE_DESCRIPTION', $site_info->description);
define('SITE_AUTHOR', 'Q2R');
define('SITE_AUTHOR_URL', 'https://q2rweb.com');

//mails
define('SITE_NOTIF_MAIL', 'info@eroodyte.com');

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

define('DEFAULT_LANGUAGE', 'english');

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
define('C_NIGERIA', 135);
define('SMS_RATE', 3.5);
define('CU_NAIRA', '&#8358;');
define('VISITOR_COUNTRY', ip_info_safe("Visitor", "Country"));
define('IN_NIGERIA', (VISITOR_COUNTRY == 'Nigeria'));