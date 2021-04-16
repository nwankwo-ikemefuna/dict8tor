<?php 
function site_meta($page_title = '', $meta_info = [], $show_analytics = false) { 
    $ci =& get_instance();
    ?>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title><?php echo $page_title; ?> :: <?php echo SITE_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>" />
    <meta name="author" content="<?php echo SITE_AUTHOR; ?>"  />
    <meta name="keywords" content="">
    <!-- Facebook Open Graph control metadata -->
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>" />
    <meta property="og:description" content="<?php echo SITE_DESCRIPTION; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="<?php echo time(); ?>" />
    <meta property="og:image" itemprop="image" content="<?php echo $meta_info['image'] ?: base_url(SITE_LOGO); ?>" />

    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(SITE_FAVICON); ?>" />
    <?php

    if ($show_analytics) { ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174509101-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-174509101-1');
        </script>
        <?php
    }
}

function load_scripts(array $scripts, $path) {
    if ($scripts) {
        foreach ($scripts as $script) { 
            $script_url = base_url().$path.'/'.$script.'.js'; ?>
            <script src="<?php echo $script_url; ?>"></script>
            <?php echo "\r\n";
        }
    }
}

function xpost($field, $default = NULL, $xss_clean = TRUE) {
	$ci =& get_instance();
    $data = $ci->input->post($field, $xss_clean);
    $data = ($data == 0 || !empty($data)) ? $data : $default;
	return $data;
}

function xpost_txt($field, $default = NULL, $xss_clean = TRUE) {
	$ci =& get_instance();
    $data = $ci->input->post($field, $xss_clean);
    $data = ($data == 0 || !empty($data)) ? nl2br_except_pre(ucfirst($data)) : $default;
	return $data;
}

function xget($field, $xss_clean = TRUE) {
	$ci =& get_instance();
	return $ci->input->get($field, $xss_clean);
}

function q_string() {
    //query strings
    if (isset($_SERVER['QUERY_STRING'])) {
        $params = $_GET;
        //we don't need to append trashed string automatically
        if (isset($params['trashed'])) {
            unset($params['trashed']);
        }
        $query_string = !empty($params) ? '?'.http_build_query($params) : '';
        return $query_string;
    } 
    return '';
}

function trashed_record_list() {
	return (int) (isset($_GET['trashed']) && $_GET['trashed'] == 1);
}

function get_requested_page() {
	return current_url() . (strlen($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
}

function get_requested_resource() {
    //we don't want the scheme and host pls
    $requested_page = get_requested_page();
    $resource = str_replace(base_url(), '', $requested_page);
    return $resource;
}

function get_requested_resource_ajax() {
    $ci =& get_instance();
    $requested_page = isset($_SESSION['ajax_requested_page']) 
        ? str_replace(base_url(), '', $ci->session->ajax_requested_page)
        : 'user';
    //is there a leading slash?
    $requested_page = $requested_page[0] === '/' ? substr($requested_page, 1) : $requested_page; 
    //ensure we don't return asset files like images, js, css, etc
    //our urls do not contain the .php extension, so we can consider anything that has a dot to be a nuisance.
    if (preg_match('/\./', $requested_page)) {
        //set to default
        $requested_page = 'user';
    }
    return $requested_page;
}

function response_headers(
	$content_type = 'application/json', 
	$allow_origin = '*', 
	$allow_cred = 'true',
	$allow_headers = 'X-Requested-With, Content-Type, Origin, Method, X-API-KEY, Cache-Control, Pragma, Accept, Accept-Encoding',
	$cache_control = 'no-cache, must-revalidate') {
	header("Access-Control-Allow-Origin: " . 		$allow_origin);
	header("Access-Control-Allow-Credentials: " . 	$allow_cred);
	header("Access-Control-Allow-Headers: " . 		$allow_headers);
	header("Content-Type: " . 						$content_type);
	header("Cache-Control: " . 						$cache_control);
}

function csrf_input($hidden = true) {
    $ci =& get_instance();
    $type = $hidden ? 'hidden' : 'text';
    echo '<input type="'.$type.'" class="'.$ci->security->get_csrf_token_name().'" value="'.$ci->security->get_csrf_hash().'">';
}

function q_string_input($hidden = true) {
    $ci =& get_instance();
    $type = $hidden ? 'hidden' : 'text';
    echo '<input type="'.$type.'" class="q_string" value="'.q_string().'">';
}

function regenerate_csrf() {
    $ci =& get_instance();
    if ($ci->config->item('csrf_protection')) {
        //NB: for this to work with forms, make sure system/helpers/form_helper/form_open() hidden csrf token input has the class as the name of the csrf token
        //regenerate new csrf hash
        $csrf_token_name = $ci->security->get_csrf_token_name();
        $res[$csrf_token_name] = $ci->security->get_csrf_hash();
        return $res;
    }
    return [];
}

function json_response($data = null, $status = true, $code = HTTP_OK) {
    http_response_code($code);
    $res = ['status' => $status];
    $body = $status ? ['body' => ['msg' => $data]] : ['error' => $data];
    $csrf_hash = regenerate_csrf();
    $res = array_merge($res, $body, $csrf_hash);
    echo json_encode($res);
    exit;
}

function json_response_db($is_update = false) {
	$ci =& get_instance();
	$error = $is_update ? 'No changes detected' : 'Sorry, something went wrong. If issue persists, report to site administrator';
	return $ci->db->affected_rows() > 0 ? json_response('Successful') : json_response($error, false);
}

function json_response_update() {
    json_response('No changes made or an error occured.', false);
}

function generate_captcha($theme = [255, 255, 255]) {
    $ci =& get_instance();
    $expire_time = 600; //10 mins
    // Captcha configuration
    $config = [
        'img_path'      => 'captcha/',
        'img_url'       => base_url().'captcha/',
        'font_path'     => base_url().'system/fonts/texb.ttf',
        'img_width'     => '120',
        'img_height'    => 45,
        'word_length'   => 6,
        'font_size'     => 20,
        'expiration'    => $expire_time,
        'colors'        => [
            'background' => [242, 242, 242],
            'border' => $theme,
            'text' => [102, 102, 102],
            'grid' => $theme
        ]
    ];
    $captcha = create_captcha($config);
    $captcha_code = $captcha['word'];
    $captcha_image = $captcha['image'];
    
    //unset previous captcha
    $ci->session->unset_tempdata('captcha_code');
    //set new captcha
    $ci->session->set_tempdata('captcha_code', $captcha_code, $expire_time);

    //return captcha image
    return $captcha_image;
}

function password_strength($password) {
    //ensure password is specified first
    if (!strlen($password)) return ['has_err' => true, 'err' => 'Password is required'];

    $uppercase = preg_match('/[A-Z]/', $password); //at least 1 uppercase letter
    $lowercase = preg_match('/[a-z]/', $password); //at least 1 lowercase letter
    $number    = preg_match('/[0-9]/', $password); //at least 1 number 
    $character = preg_match('/(?=\S*[\W])/', $password); //at least 1 special xter
    $has_err = false;
    $err = "Password is missing the following: ";
    if( ! $uppercase) {
        $err .= ($has_err ? ', ':'') . 'at least 1 uppercase letter';
        $has_err = true;
    }
    if( ! $lowercase) {
        $err .= ($has_err ? ', ':'') . 'at least 1 lowercase letter';
        $has_err = true;
    }
    if( ! $number) {
        $err .= ($has_err ? ', ':'') . 'at least 1 digit';
        $has_err = true;
    }
    if( ! $character) {
        $err .= ($has_err ? ', ':'') . 'at least 1 special character';
        $has_err = true;
    }
    return ['has_err' => $has_err, 'err' => $err];
}

function verify_url_title($url_title, $real_title, $redirect = '') {
	if ($url_title != url_title($real_title)) 
        redirect($redirect);
}

function scandir_recursive($dir) {
    $result = [];
    foreach(scandir($dir) as $filename) {
        //remove annoying dots
        if (in_array($filename[0], ['.', '..'])) continue;
        $path = $dir . DIRECTORY_SEPARATOR . $filename;
        if (is_dir($path)) {
        	//if dir, run through
            foreach (scandir_recursive($path) as $childFilename) {
                $result[] = $filename . DIRECTORY_SEPARATOR . $childFilename;
            }
        } else {
            $result[] = $filename;
        }
    }
    return $result;
}

function youtube_embed_url($url) {
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    return 'https://www.youtube.com/embed/' . $youtube_id ;
}