<?php
defined('BASEPATH') or die('Direct access not allowed');

class Settings extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->module = MOD_SETTINGS;
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		redirect('settings/view');
	}


	public function view() { 
		//buttons
		$this->butts = ['edit'];
        $this->ajax_header('Site Info');
		$this->load->view('portal/admin/settings/view');
		$this->ajax_footer();
	}


	public function edit() { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['save', 'cancel'];
        $this->ajax_header('Edit Site Info');
		$this->load->view('portal/admin/settings/edit');
		$this->ajax_footer();
	}
	
}