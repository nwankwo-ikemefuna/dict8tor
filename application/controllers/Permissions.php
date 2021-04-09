<?php
defined('BASEPATH') or die('Direct access not allowed');

class Permissions extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_PERMISSIONS;
        $this->module = MOD_PERMISSIONS;
        $this->model = 'permission';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->school_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$where = ['school_id' => SCHOOL_ID];
		$count = $this->common_model->count_rows($this->table, $where, $this->trashed);
		$page_title = 'All Permissions';		
		$this->ajax_header($page_title, $count);
		$this->load->view('portal/admin/permissions/index');
		$this->ajax_footer();
	}


	public function add() {
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
        $this->butts = ['save', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
        $data['modules'] = $this->module_model->get_all([], "m.id, m.title, m.rights", ['active' => 1, 'private' => 0]);
        $this->ajax_header('Add Roles And Permissions');
		$this->load->view('portal/admin/permissions/adit', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
		$row = $this->permission_model->get_details($id, 'id', [], 'id, name, rights');
		$data['page'] = 'edit';
		$data["row"] = $row;
        $data['modules'] = $this->module_model->get_all([], "m.id, m.title, m.rights", ['active' => 1, 'private' => 0]);
		$this->ajax_header('Edit Roles and Permissions: '.$row->name, '', $id);
		$this->load->view('portal/admin/permissions/adit', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$this->butts = ['list', 'add', 'edit'];
		$row = $this->permission_model->get_details($id, 'id', ['emp'], 'p.id, name, rights ## employee_count');
		$data["row"] = $row;
		$data['modules'] = $this->module_model->get_all([], "m.id, m.title, m.rights", ['active' => 1, 'private' => 0]);
        $this->ajax_header('Permissions: '.$row->name, '', $id);
		$this->load->view('portal/admin/permissions/view', $data);
		$this->ajax_footer();
	}

}
