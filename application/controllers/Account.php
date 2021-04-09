<?php
defined('BASEPATH') or die('Direct access not allowed');

class Account extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function login() {
        $this->auth_header('Login');
        $this->load->view('auth/login');
        $this->auth_footer();
    }


    public function activate_account() {
        $this->auth_header('Activate Account');
        $this->load->view('auth/activate_account');
        $this->auth_footer();
    }


    public function forgot_pass() {
        $this->auth_header('Password Recovery');
        $this->load->view('auth/forgot_pass');
        $this->auth_footer();
    }


    public function reset_pass($username, $reset_code) {
        $data['username'] = $username;
        $data['reset_code'] = $reset_code;
        $this->auth_header('Password Reset');
        $this->load->view('auth/reset_pass', $data);
        $this->auth_footer();
    }


    public function logout() {
        $this->auth->logout('login');
    }
    
}