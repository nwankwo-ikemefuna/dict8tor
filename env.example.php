<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//general app config
define('LOCAL_APP_CONFIG', [
	'base_url' 			=> 'http://dev.isobassey.com/', //with trailing slash
	'sess_expiration' 	=> 60*60*2, //session time to live => 2 hours
	'git_branch' 		=> 'dev', //git branch from which updates are pulled automatically using web hooks (for production server only)
	'sync_key' 			=> 'anything*but*ampersand', //passkey used for database sync: should NOT contain & symbol as this will be passed to url as GET param
]);

//db config
$show_db_errors = true;
if (isset($_GET['DB_DEBUG_ERROR'])) {
	$show_db_errors = ($_GET['DB_DEBUG_ERROR'] == 1);
} 
define('LOCAL_DB_CONFIG', [
	'hostname' => '127.0.0.1',
	'database' => 'db_name',
	'username' => 'db_username',
	'password' => 'db_password',
	'db_debug' => $show_db_errors,
]);

//SMS lib config
define('LOCAL_SMS_CONFIG', [
	'termii' => [
		'url' 		=> 'https://termii.com/api/sms/send',
		'api_key' 	=> 'TLD0ow5CGqR7awKprZgUyu5wHbRgTNViplK3j2V1Ey4LNtCapd3i6U3ILHtFTp',
		'from' 		=> 'talert', //N-Alert, talert
		'type' 		=> 'plain', //voice, plain
		'channel' 	=> 'dnd', //generic, dnd, whatsapp
	]
]);

//AWS s3 config
define('AWS_S3_CONFIG', [
	'enabled' 		=> true, //if disabled, files will be uploaded and served from local
	'region' 		=> 'eu-central-1', //frankfurt
	'bucket' 		=> 'my-bucket',
	'access_key' 	=> 'my-acccess-key',
	'secret_key' 	=> 'my-secret-key',
	'upload_dir' 	=> 'project-name', //eg qsm
]);

//Google Adsense
define('ADSENSE_CONFIG', [
	'publisher_id' 		=> 'ca-pub-2022130965708164',
	'enabled' 			=> true,
	'top_banner' 		=> true,
	'sidebar_square' 	=> true,
	'sidebar_vertical' 	=> true,
]);