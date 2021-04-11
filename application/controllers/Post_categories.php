<?php
defined('BASEPATH') or die('Direct access not allowed');

class Post_categories extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_POST_CATEGORIES;
		$this->module = MOD_BLOG_CATEGORIES;
		$this->model = 'blog_category';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}

	
	public function index() { 
		//buttons
		$this->butts = ['add', 'list'];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Post Categories', $count);
		$this->load->view('portal/admin/posts/categories/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
		$data['language_columns'] = $this->blog_category_model->language_columns();
        $data['next_order'] = $this->common_model->next_order($this->table);
        $this->ajax_header('Add Post Category');
        $this->load->view('portal/admin/posts/categories/adit_view', $data);
		$this->ajax_footer();
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->blog_category_model->get_details($id, 'id');
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['language_columns'] = $this->blog_category_model->language_columns();
        $this->ajax_header('Edit Post Category: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/posts/categories/adit_view', $data);
		$this->ajax_footer();
	}


	public function view($id) { 
		//buttons
		$row = $this->blog_category_model->get_details($id, 'id');
        $this->butts = ['list', 'add', 'edit'];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->blog_category_model->language_columns();
		$this->ajax_header('Post Category: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/posts/categories/adit_view', $data);
		$this->ajax_footer();
	}

}