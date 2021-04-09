<?php
defined('BASEPATH') or die('Direct access not allowed');

class Departments extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_DEPARTMENTS;
		$this->module = MOD_DEPARTMENTS;
		$this->model = 'dept';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('Departments', $count);
		$this->load->view('portal/admin/departments/index');
		$this->ajax_footer();
	}


	public function add() { 
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
        $data['users'] = $this->user_model->get_all([], "u.id ## full_name", ['usergroup' => ADMIN]);
        $data['next_order'] = $this->common_model->next_order($this->table);
        $this->ajax_header('Add Department');
        $this->load->view('portal/admin/departments/adit', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->dept_model->get_details($id, 'id', [], 'id, name, hod_id, order');
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['users'] = $this->user_model->get_all([], "u.id ## full_name", ['usergroup' => ADMIN]);
		$this->ajax_header('Edit Department: '.$row->name, '', $id);
		$this->load->view('portal/admin/departments/adit', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$xtra_butts = [
            ['text' => 'Classes', 'target' => 'classes?dept_id='.$id, 'icon' => 'institution'],
            ['text' => 'Courses', 'target' => 'courses?dept_id='.$id, 'icon' => 'book']
        ];
		$this->butts = ['list', 'add', 'edit', 'xtra_butts' => $xtra_butts];
		$row = $this->dept_model->get_details($id, 'id', ['c', 'hod'], 'd.id, d.name, d.order ## hod, class_count');
		$data['row'] = $row;
        $this->ajax_header('Department: '.$row->name, '', $id);
		$this->load->view('portal/admin/departments/view', $data);
		$this->ajax_footer();
	}

}