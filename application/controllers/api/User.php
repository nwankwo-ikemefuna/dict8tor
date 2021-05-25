<?php
defined('BASEPATH') or die('Direct access not allowed');

class User extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_USERS;
		$this->auth->login_restricted();
	}

	public function edit() { 
		$this->form_validation->set_rules('country', 'Country', 'trim');
        $this->form_validation->set_rules('state', 'State', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural');
		if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        $dob = trim(xpost('dob'));
        if (strlen($dob) && !validate_date($dob, 'Y-m-d')) {
            json_response("Invalid Date of Birth format. Expected format is DD/MM/YYYY eg 23/06/2001", false);
        }

        //Email already exists?
        $email = strtolower(xpost('email'));
        if (strlen($email)) {
            $email_exists = $this->common_model->exists($this->table, ['email' => xpost('email')], $this->session->user_id);
            if ($email_exists) json_response('Email is already in use', false);
        }

        $data = [
            'country'               => strlen(xpost('country')) ? xpost('country') : NULL,
            'state'                 => strlen(xpost('state')) ? xpost('state') : NULL,
            'phone'                 => xpost('phone'),
            'email'                 => strtolower(xpost('email')),
            'dob'                   => strlen($dob) ? $dob : null,
        ];
        $this->common_model->update($this->table, $data, ['id' => $this->session->user_id]);
        //update session data
        $session_data = $this->auth->login_data($this->session->user_id);
        $this->session->set_userdata($session_data);
        json_response(['redirect' => 'user/view']);
    }


    public function reset_pass() { 
        $this->form_validation->set_rules('curr_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|differs[curr_password]', ['differs' => 'New password cannot be same as current password']);
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[password]', ['matches'   => 'Passwords do not match']);
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        //is current password correct?
        if ( ! password_verify(xpost('curr_password'), $this->session->user_password))
            json_response('Current password not correct', false);
        $new_password = password_hash(xpost('password'), PASSWORD_DEFAULT);
        $data = ['password' => $new_password, 'password_set' => 1];
        $this->common_model->update($this->table, $data, ['id' => $this->session->user_id]);
        //update session data
        $this->session->user_password = $new_password;
        $this->session->user_password_set = 1;
        json_response(['redirect' => 'user']);
    }


    public function change_avatar() {
        $path = 'pix/users';
        $conf = [
        	'path' => $path, 
        	'ext' => 'jpg|jpeg|png', 
        	'size' => 100, 
        	'resize' => true, 
        	'resize_width' => 100, 
        	'resize_height' => 100,
        	'delete_origin' => true, //delete original 
        	'required' => true
        ];
        $upload = upload_file('photo', $conf);
        //file upload fails
        if ( ! $upload['status']) json_response($upload['error'], false);
        //delete current avatar
        //we can't rely on the avatar saved in session, so we make a fresh query to fetch the avatar
        $avatar = $this->user_model->get_details($this->session->user_id, 'id', [], 'photo')->photo;
        unlink_file($path, $avatar);
        //update new
        $this->common_model->update($this->table, ['photo' => $upload['file_name']], ['id' => $this->session->user_id]);
        //reload page
        json_response(['redirect' => 'user/change_avatar']);
    }


}