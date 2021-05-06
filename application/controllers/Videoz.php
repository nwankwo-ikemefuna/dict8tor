<?php
defined('BASEPATH') or die('Direct access not allowed');

class Videoz extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_VIDEOS;
		$this->module = MOD_VIDEOS;
		$this->model = 'video';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);

        $this->page_scripts = [];
	}

	
	public function index() { 
		//buttons
        $xtra_butts = [
            ['type' => 'url_external', 'text' => 'View in Website', 'target' => 'videos', 'icon' => 'eye']
        ];
        $this->butts = ['list', 'add', 'xtra_butts' => $xtra_butts];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Posts', $count);
		$this->load->view('portal/admin/videos/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
		$data['language_columns'] = $this->video_model->language_columns();
        $this->ajax_header('Add Video');
        $this->load->view('portal/admin/videos/adit_view', $data);
		$this->ajax_footer('add');
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->video_model->get_details($id, 'id', ['cat']);
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['language_columns'] = $this->video_model->language_columns();
        $this->ajax_header('Edit Video: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/videos/adit_view', $data);
		$this->ajax_footer('edit');
	}


	public function view($id) { 
		//buttons
		$row = $this->video_model->get_details($id, 'id');
        $this->butts = ['list', 'add', 'edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->video_model->language_columns();
		$this->ajax_header('Video: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/videos/adit_view', $data);
		$this->ajax_footer('view');
	}

}