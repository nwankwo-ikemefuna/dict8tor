<?php 

function user_group($groups) {
	$ci =& get_instance();
	if ( ! $ci->session->user_loggedin) return false;
	if (is_array($groups)) return in_array($ci->session->user_usergroup, $groups);
	return ($ci->session->user_usergroup == $groups);
}

function site_name($field = 'name') {
	$ci =& get_instance();
	return constant('SITE_'.strtoupper($field));
}

function user_avatar() {
	$ci =& get_instance();
	if (strlen($ci->session->user_photo)) 
		return base_url($ci->session->user_avatar);
	if ($ci->session->user_sex == SEX_MALE) {
		$default = AVATAR_MALE;
	} elseif ($ci->session->user_sex == SEX_FEMALE) {
		$default = AVATAR_FEMALE;
	} else {
		$default = AVATAR_GENERIC;
	}
	return base_url($default);
}

