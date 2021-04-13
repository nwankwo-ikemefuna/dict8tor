<?php
defined('BASEPATH') or die('Direct access not allowed');

class Info extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->module = MOD_SETTINGS;
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		redirect('info/view/'.$this->active_phase);
	}


	public function view($phase) { 
		//buttons
		$this->butts = ['edit'];
		$data['row'] = $this->info_model->get_details($phase, 'phase');
		$data['language_columns'] = $this->info_model->language_columns();
        $data['image_columns'] = $this->info_model->image_columns();
        $data['is_edit'] = false;
        $this->ajax_header("Phase {$phase} Info", '', $phase);
		$this->load->view('portal/admin/info/view_edit', $data);
		$this->ajax_footer();
	}


	public function edit($phase) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['save', 'view', 'cancel'];
        $data['row'] = $this->info_model->get_details($phase, 'phase');
		$data['language_columns'] = $this->info_model->language_columns();
        $data['image_columns'] = $this->info_model->image_columns();
		$data['is_edit'] = true;
        $this->ajax_header("Edit Phase {$phase} Info", '', $phase);
		$this->load->view('portal/admin/info/view_edit', $data);
		$this->ajax_footer();
	}
	
}