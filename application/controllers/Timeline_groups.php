<?php
defined('BASEPATH') or die('Direct access not allowed');

class Timeline_groups extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_TIMELINE_GROUPS;
		$this->module = MOD_TIMELINES;
		$this->model = 'timeline_group';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Timeline Groups', $count);
		$this->load->view('portal/admin/timelines/groups/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $type = xget('type');
        $data['page'] = 'add';
        $data['row'] = '';
        $data['language_columns'] = $this->timeline_group_model->language_columns();
        $data['next_order'] = $this->common_model->next_order($this->table);
        $this->ajax_header('Add Timeline Group');
        $this->load->view('portal/admin/timelines/groups/adit_view', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->timeline_group_model->get_details($id, 'id');
		$data['page'] = 'edit';
		$data['row'] = $row;
        $data['language_columns'] = $this->timeline_group_model->language_columns();
        $this->ajax_header('Edit Timeline Group: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/timelines/groups/adit_view', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$row = $this->timeline_group_model->get_details($id, 'id');
        $this->butts = ['list', 'add', 'edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->timeline_group_model->language_columns();
		$this->ajax_header('Timeline Group: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/timelines/groups/adit_view', $data);
		$this->ajax_footer();
	}

}