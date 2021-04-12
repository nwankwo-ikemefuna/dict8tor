<?php
defined('BASEPATH') or die('Direct access not allowed');

class Employees extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_USERS;
		$this->module = MOD_EMPLOYEES;
        $this->model = 'user';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);

		$this->page_scripts = ['employees'];
    }


    public function index() { 
    	//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$status = xget('status');
        $where = ['usergroup' => ADMIN];
        $where = strlen($status) ? array_merge($where, ['status' => $status]) : $where;
		$count = $this->common_model->count_rows($this->table, $where, $this->trashed);
		$page_title = 'All Users';
        $this->ajax_header($page_title, $count);
		$this->load->view('portal/admin/employees/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
        $data['countries'] = $this->country_model->get_all([], "id, name");
        $data['roles'] = $this->permission_model->get_all([], "id, name");
        $this->ajax_header('Add User');
        $this->load->view('portal/admin/employees/adit', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
		$row = $this->user_model->get_details($id, 'id', ['p'], 'u.id, usergroup, last_name, first_name, other_name, u.sex, phone, email, dob, roles, active, is_super_user ## full_name, avatar, roles_name');
		if (!$row) {
			redirect('employees');
		}
		$data['page'] = 'edit';
		$data['row'] = $row;
        $data['countries'] = $this->country_model->get_all([], "id, name");
        $data['roles'] = $this->permission_model->get_all([], "id, name");
        $this->ajax_header('Edit User: '. $row->full_name, '', $id);
        $this->load->view('portal/admin/employees/adit', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$this->butts = ['list', 'add', 'edit'];
		$row = $this->user_model->get_details($id, 'id', ['d', 'p', 'cnt'], 'u.id, last_name, first_name, other_name, email, phone, dob, active ## full_name, gender, age, avatar, is_super_user_text, roles_name');
		if (!$row) {
			redirect('employees');
		}
		$data['row'] = $row;
        $this->ajax_header($row->full_name, '', $id);
		$this->load->view('portal/admin/employees/view', $data);
		$this->ajax_footer();
	}

}