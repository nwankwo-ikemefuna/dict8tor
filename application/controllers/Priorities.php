<?php
defined('BASEPATH') or die('Direct access not allowed');

class Priorities extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_PRIORITIES;
		$this->module = MOD_PRIORITIES;
		$this->model = 'priority';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
        $this->butts = ['list', 'add'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Priorities', $count);
		$this->load->view('portal/admin/priorities/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
		$data['language_columns'] = $this->priority_model->language_columns();
        $data['next_order'] = $this->common_model->next_order($this->table);
        $this->ajax_header('Add Priority');
        $this->load->view('portal/admin/priorities/adit_view', $data);
		$this->ajax_footer('add');
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->priority_model->get_details($id, 'id', ['cat']);
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['language_columns'] = $this->priority_model->language_columns();
        $this->ajax_header('Edit Priority: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/priorities/adit_view', $data);
		$this->ajax_footer('edit');
	}


	public function view($id) { 
		//buttons
		$row = $this->priority_model->get_details($id, 'id', ['cat']);
        $this->butts = ['list', 'add', 'edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->priority_model->language_columns();
		$this->ajax_header('Priority: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/priorities/adit_view', $data);
		$this->ajax_footer('view');
	}

}