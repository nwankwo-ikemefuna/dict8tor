<?php
defined('BASEPATH') or die('Direct access not allowed');

class User extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_USERS;
		$this->module = MOD_ALL_ACCESS;
		$this->auth->login_restricted();
	}

	
	public function index() { 
		$this->ajax_header('Dashboard');
		$this->load->view('portal/'.$this->session->user_usergroup_name.'/index');
		$this->ajax_footer();
	}


	public function view() { 
		$this->auth->def_password_restricted();
		// $this->sandbox_model->get_question_options("mathematics_questions");
		//buttons
		$xtra_butts = [
            ['text' => 'Change Password', 'type' => 'url', 'target' => 'user/reset_pass', 'icon' => 'key']
        ];
        $this->butts = ['edit', 'xtra_butts' => $xtra_butts];
		$this->ajax_header('My Profile');
		$this->load->view('portal/profile/view');
		$this->ajax_footer();
	}


	public function edit() { 
		$this->auth->def_password_restricted();
		//buttons
		$this->butts = ['view', 'save', 'cancel'];
		$data['states'] = $this->state_model->get_all([], "id, name", ['country' => $this->session->user_country]);
        $this->ajax_header('Edit Profile');
		$this->load->view('portal/profile/edit', $data);
		$this->ajax_footer();
	}


	public function reset_pass() { 
		//buttons
		$this->butts = ['save'];
		$this->ajax_header('Reset Password');
		$this->load->view('portal/profile/reset_pass');
		$this->ajax_footer();
	}

}