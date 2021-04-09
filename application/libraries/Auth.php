<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

	private $ci;
	private $license_enabled = TRUE;
	private $token_enabled = TRUE;

	public function __construct() {
		$this->ci =& get_instance();
	}


	public function login($username_key, $loggedin_from = 'login', $success_msg = 'Login successful') {
		$this->ci->form_validation->set_rules($username_key, ucfirst($username_key), 'trim|required');
        $this->ci->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->ci->form_validation->run() === FALSE) 
            json_response(validation_errors(), false);    

        $username = xpost($username_key);
        $password = xpost('password');
        $row = $this->ci->user_model->get_details($username, $username_key, [], "id, password");
		//user exists, is not trashed, and password is correct...
        if ($row && password_verify($password, $row->password)) {
        	$this->ci->session->set_userdata($this->login_data($row->id));
        	// $this->ci->session->set_userdata('account_login_url','login');
        	$this->set_requested_page();
        	//update last login
        	$this->ci->common_model->update(T_USERS, ['last_login' => date('Y-m-d H:i:s')], ['id' => $row->id]);
        	$this->loggedin_from($loggedin_from);
        	json_response($success_msg);
        }
        json_response('Invalid login!', false);
    }


    public function login_data($id) {
    	$row = (array) $this->ci->user_model->get_details($id, 'id', ['all']);
		if ( ! $row) return;
		//we don't want these guys
		unset($row['password_reset_code']);
        //prefix user_ to every data key
        $keys = array_keys($row);
		$data = [];
        foreach ($keys as $key) {
            $data['user_'.$key] = $row[$key];
        }
		//others
		$data = array_merge($data, [
			'user_loggedin' => TRUE,
			'user_avatar' => $row['avatar']
		]);
		return $data;
    } 


    public function logout($redirect = 'login') {
    	$data = array_keys($this->login_data($this->ci->session->user_id));
    	$this->ci->session->unset_userdata($data);
    	redirect($redirect);
    }


    public function loggedin_from($url) {
        $cookie = [
            'name' => 'cookie_login_url',
            'value' => $url,
            'expire' => 3600*24*7, //1 week
        ];
       $this->ci->input->set_cookie($cookie);
    }


	public function is_logged_in($redirect = 'portal', $msg = 'You are already logged in!') {
    	if ($this->ci->session->user_loggedin) {
            $this->ci->session->set_flashdata('info_msg', $msg);
            redirect($redirect);
        }
    }


    public function set_requested_page() {
    	$this->ci->session->set_userdata('ajax_requested_page', base_url('user'));
	}


    private function update_requested_page() {
		//create a session to hold the current requested page
		$this->ci->session->set_userdata('ajax_requested_page', get_requested_page());
	}


	public function ajax_request_restricted() {
		//requested page via ajax?
		if ( ! $this->ci->input->is_ajax_request()) {
			//update requested page
			redirect('portal');
		}
	}


	/**
	* Restrict access to pages requiring user to be logged in
	* redirect to login page if user is not logged
	* @return boolean
	*/
	public function login_restricted($usergroup = null, $redirect = 'login') {
		//all
		if ($this->ci->session->user_loggedin && ! empty($usergroup)) return TRUE;
		//specific usergroup
		if ($this->ci->session->user_loggedin && user_group($usergroup)) return TRUE;
		//all usergroups
		if ($this->ci->session->user_loggedin && $usergroup === null) return TRUE;
		//update requested page
		$this->update_requested_page();
		//redirect to login page
		$this->ci->session->set_flashdata('error_msg', 'You are not logged in. Please login to continue.');
		$redirect = isset($_COOKIE['cookie_login_url']) ? $this->ci->input->cookie('cookie_login_url', true) : $redirect;
		$this->logout($redirect);
	}


	/**
	* Restrict access to pages requiring user to have reset default password
	* redirect to login page if user is not logged
	* @return boolean
	*/
	public function def_password_restricted($redirect = 'user/reset_pass') {
		//all
		if ($this->ci->session->user_loggedin && $this->ci->session->user_password_set == 1) return TRUE;
		//create a session to hold the current requested page
		$this->update_requested_page();
		//redirect to password reset page
		$this->ci->session->set_flashdata('error_msg', 'You have not reset your default password');
		redirect($redirect);
	}


	/**
	* Restrict access to pages without the right user group and permissions
	* @return boolean
	*/
	public function vet_access($module, $right, $usergroups = null) {
		//module access is open?
		if ($module == MOD_ALL_ACCESS) return true;

		//level 1 user here?
		if (intval($this->ci->session->user_level) === 1) return true;
		//user group 
		$group = $this->ci->session->user_usergroup;
		//is usergroup an array? Cast into array if not
		$usergroups = is_array($usergroups) ? $usergroups : (array) $usergroups;
		if ( !empty($usergroups) && ! in_array($group, $usergroups) ) return false;

		//module access is open to a particular usergroup?
		if ($module == MOD_GROUP_ACCESS && in_array($group, $usergroups)) return true;
		
		//user permissions
		$permissions = $this->ci->session->user_permissions;
	    if ( ! strlen($permissions)) return false;
	    //let's work on the permissions
	    // json example
	    // [
	    // 	{1: [1,2,3]},
	    // 	{6: [2,4]},
	    // ]
	    // where 1 and 6 are module Ids
	    // 1,2,3 and 2,4 are CRUD rights
	    $perms_arr = (array) json_decode($permissions, true);
	    if (empty($perms_arr)) return false;
	    $perm_modules = array_keys($perms_arr);
	    //if user does not have module permission, kick away
	    if (!in_array($module, $perm_modules)) return false;
	    //rights
	    $perm_rights = (array) $perms_arr[$module];
	    //if user does not have right permission, kick away
	    if (!in_array($right, $perm_rights)) return false;
	    //if they survive all this...
	    return true;
	}

	

	/**
	* Restrict access to pages without the right permissions
	* redirect to forbidden page
	* @return boolean
	*/
	public function module_restricted($module, $right, $usergroups = null, $ajax = false, $redirect = 'forbidden') {
		$grant_access = $this->vet_access($module, $right, $usergroups);
		if ($grant_access) return TRUE;
		if ($ajax) {
			json_response('Action denied! Insufficient permissions!', false);
		} else {
			$this->ci->session->set_flashdata('error_msg', 'You do not have sufficient permissions to perform the action you attempted.');
			redirect($redirect);
		}
	}


}