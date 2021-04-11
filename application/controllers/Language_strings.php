<?php
defined('BASEPATH') or die('Direct access not allowed');

class Language_strings extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->module = MOD_LANGUAGE_STRINGS;
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		redirect('language_strings/view');
	}


	public function view() { 
		//buttons
		$this->butts = ['edit'];
		$data['rows'] = $this->language_string_model->get_all();
        $data['is_edit'] = false;
        $this->ajax_header("Language Strings");
		$this->load->view('portal/admin/language_strings/view_edit', $data);
		$this->ajax_footer();
	}


	public function edit() { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['save', 'view', 'cancel'];
        $data['rows'] = $this->language_string_model->get_all();
		$data['is_edit'] = true;
        $this->ajax_header("Edit Language Strings");
		$this->load->view('portal/admin/language_strings/view_edit', $data);
		$this->ajax_footer();
	}
	
}