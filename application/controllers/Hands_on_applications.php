<?php
defined('BASEPATH') or die('Direct access not allowed');

class Hands_on_applications extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_HANDS_ON_APPLICATIONS;
        $this->module = MOD_HANDS_ON;
        $this->model = 'hands_on_application';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
        $this->butts = ['list'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Applications', $count);
		$this->load->view('portal/admin/hands_on/applications/index');
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$row = $this->hands_on_application_model->get_details($id, 'id', ['stt', 'lga', 'p_lga']);
        $this->butts = ['list'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['form_elements_applicant'] = $this->hands_on_application_model->form_elements_applicant();
        $data['form_elements_grant'] = $this->hands_on_application_model->form_elements_grant();
        $data['form_elements_ngo'] = $this->hands_on_application_model->form_elements_ngo();
		$this->ajax_header('Application: '.$row->full_name, '', $id);
		$this->load->view('portal/admin/hands_on/applications/view', $data);
		$this->ajax_footer('view');
	}

}