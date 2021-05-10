<?php
defined('BASEPATH') or die('Direct access not allowed');

class Account extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function login() {
        $this->auth->login('email');
    }


    public function logout() {
        $this->auth->logout('login');
    }


    public function forgot_pass() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $email = xpost('email');
        $reset_code = hash('sha512', mt_rand(1111111111, 9999999999));
        $data = ['password_reset_code' => $reset_code];
        $row = $this->user_model->get_details($email, 'email', [], "username");
        if (!$row) json_response('We can\'t find you!', false);
        //update code
        $this->common_model->update(T_USERS, $data, ['email' => xpost('email')]);
        //send email
        $reset_url = base_url('account/reset-pass/'.$row->username.'/'.$reset_code);
        $anchor_link = email_call2action_blue($reset_url, 'Reset Password');
        $message = "Hi <b>{$row->username}!</b> <br />
            You requested for password reset for your account. <br />
            Click on the link below to reset your password. <br /> 
            {$anchor_link} <br /> <br /> 
            If you did not make this request, ignore this message. <br /> 
            Please do not reply this message.";
        @send_mail(SITE_NOTIF_MAIL, $email, 'Account Password Recovery', $message);
        json_response();
    }


    public function reset_pass() {
        json_response('Functionality coming soon... Please bear with us.', false);
        $username = xpost('username');
        $password_reset_code = xpost('password_reset_code');
        $count = $this->common_model->count_rows(T_USERS, ['username' => $username, 'password_reset_code' => $password_reset_code]);
        if ( ! $count) json_response('Invalid username or code!', false);
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[password]', ['matches'   => 'Passwords do not match']);
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            'password' => password_hash(xpost('password'), PASSWORD_DEFAULT),
            'password_reset_code' => NULL
        ];
        $this->common_model->update(T_USERS, $data, ['username' => $username]);
        json_response();
    }
    
}