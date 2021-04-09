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
		$this->auth->school_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
    }


    public function index() { 
    	//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$status = xget('status');
        $where = ['school_id' => SCHOOL_ID, inset_select('usergroup', SCHOOL_EMPLOYEES) => null];
        $where = strlen($status) ? array_merge($where, ['status' => $status]) : $where;
		$count = $this->common_model->count_rows($this->table, $where, $this->trashed);
		$page_title = strlen($status) ? EMP_STATUSES[$status].' Employees' : 'All Employees';
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
        $this->ajax_header('Add Employee');
        $this->load->view('portal/admin/employees/adit', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
        $this->check_school_data($this->table, $id);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
		$row = $this->user_model->get_details($id, 'id', ['d', 'p'], 'u.id, usergroup, last_name, first_name, other_name, dept_id, u.sex, username, phone, email, country, state, dob, permissions, status ## full_name, avatar, permissions_name');
		$data['page'] = 'edit';
		$data['row'] = $row;
        $data['countries'] = $this->country_model->get_all([], "id, name");
        $data['roles'] = $this->permission_model->get_all([], "id, name");
        $this->ajax_header('Edit Employee: '. $row->full_name, '', $id);
        $this->load->view('portal/admin/employees/adit', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		$this->check_school_data($this->table, $id);
		//buttons
		$this->butts = ['list', 'add', 'edit'];
		$row = $this->user_model->get_details($id, 'id', ['d', 'p', 'cnt'], 'u.id, last_name, first_name, other_name, username, email, phone, state, dob, status ## department, country_name, full_name, gender, age, avatar, permissions_name');
		$data['row'] = $row;
        $this->ajax_header('Employee: '.$row->full_name, '', $id);
		$this->load->view('portal/admin/employees/view', $data);
		$this->ajax_footer();
	}

}