<?php
defined('BASEPATH') or die('Direct access not allowed');

class Hands_on_info extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_HANDS_ON_INFO;
		$this->module = MOD_HANDS_ON;
		$this->model = 'hands_on_info';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


	public function index() { 
		redirect('settings/view');
	}


	public function edit() { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['save', 'view', 'cancel'];
        $row = $this->hands_on_info_model->get_details(1);
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['language_columns'] = $this->hands_on_info_model->language_columns();
		$data['image_columns'] = $this->hands_on_info_model->image_columns();
        $this->ajax_header('Edit Hands-On-Nigeria Info');
		$this->load->view('portal/admin/hands_on/info/edit_view', $data);
		$this->ajax_footer('edit');
	}


	public function view() { 
		//buttons
		$row = $this->hands_on_info_model->get_details(1);
        $this->butts = ['edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->hands_on_info_model->language_columns();
		$data['image_columns'] = $this->hands_on_info_model->image_columns();
		$this->ajax_header('Hands-On-Nigeria Info');
		$this->load->view('portal/admin/hands_on/info/edit_view', $data);
		$this->ajax_footer('view');
	}

}