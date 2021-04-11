<?php
defined('BASEPATH') or die('Direct access not allowed');

class Timelines extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_TIMELINES;
		$this->module = MOD_TIMELINES;
		$this->model = 'timeline';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$type = xget('type');
        $candidate_details = $this->candidate_model->get_details($type, 'type', [], 'display_name_full');
		$where = ['candidate_type' => $type];
		$count = $this->common_model->count_rows($this->table, $where, $this->trashed);
        $page_title = 'All Timelines: '.$candidate_details->display_name_full;
		$this->ajax_header($page_title, $count);
		$this->load->view('portal/admin/timelines/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $type = xget('type');
        $data['page'] = 'add';
        $data['row'] = '';
        $data['language_columns'] = $this->timeline_model->language_columns();
        $data['next_order'] = $this->common_model->next_order($this->table, ['candidate_type' => $type]);
        $this->ajax_header('Add Timeline');
        $this->load->view('portal/admin/timelines/adit_view', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->timeline_model->get_details($id, 'id');
		$data['page'] = 'edit';
		$data['row'] = $row;
        $data['language_columns'] = $this->timeline_model->language_columns();
        $this->ajax_header('Edit Timeline: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/timelines/adit_view', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$row = $this->timeline_model->get_details($id, 'id');
		$xtra_butts = [
            ['text' => 'Candidate', 'target' => 'candidates/view/'.$row->candidate_type, 'icon' => 'user']
        ];
        $this->butts = ['list', 'add', 'edit', 'xtra_butts' => $xtra_butts];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->timeline_model->language_columns();
		$this->ajax_header('Timeline: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/timelines/adit_view', $data);
		$this->ajax_footer();
	}

}