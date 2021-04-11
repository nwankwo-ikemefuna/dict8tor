<?php
defined('BASEPATH') or die('Direct access not allowed');

class Subscribers extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_SUBSCRIBERS;
        $this->module = MOD_SUBSCRIBERS;
        $this->model = 'subscriber';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
        $this->butts = ['list', 'add'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Subscribers', $count);
		$this->load->view('portal/admin/subscribers/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
        $this->ajax_header('Add Subscriber');
        $this->load->view('portal/admin/subscribers/adit', $data);
		$this->ajax_footer('add');
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->subscriber_model->get_details($id, 'id');
		$data['page'] = 'edit';
		$data['row'] = $row;
        $this->ajax_header('Edit Subscriber: '.$row->email, '', $id);
		$this->load->view('portal/admin/subscribers/adit', $data);
		$this->ajax_footer('edit');
	}


	public function view($id) { 
		//buttons
		$row = $this->subscriber_model->get_details($id, 'id');
        $this->butts = ['list', 'add', 'edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
		$this->ajax_header('Subscriber: '.$row->email, '', $id);
		$this->load->view('portal/admin/subscribers/view', $data);
		$this->ajax_footer('view');
	}

}