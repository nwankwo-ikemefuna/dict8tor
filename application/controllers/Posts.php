<?php
defined('BASEPATH') or die('Direct access not allowed');

class Posts extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_POSTS;
		$this->module = MOD_BLOG;
		$this->model = 'blog';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);

        $this->page_scripts = ['posts'];
	}

	
	public function index() { 
		//buttons
        $xtra_butts = [
            ['type' => 'url_external', 'text' => 'View in Blog', 'target' => 'blog', 'icon' => 'eye']
        ];
        $this->butts = ['list', 'add', 'xtra_butts' => $xtra_butts];
		$this->ba_opts = ['delete'];
		$count = $this->common_model->count_rows($this->table, [], $this->trashed);
		$this->ajax_header('All Posts', $count);
		$this->load->view('portal/admin/posts/index');
		$this->ajax_footer();
	}


	public function add() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'save_more', 'cancel'];
        $data['page'] = 'add';
        $data['row'] = '';
		$data['language_columns'] = $this->blog_model->language_columns();
        $data['blog_categories'] = $this->blog_category_model->get_all([], 'id, slug ## title');
        $this->ajax_header('Add Post');
        $this->load->view('portal/admin/posts/adit_view', $data);
		$this->ajax_footer('add');
	}


	public function edit($id) { 
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['list', 'save', 'view', 'cancel'];
        $row = $this->blog_model->get_details($id, 'id', ['cat']);
		$data['page'] = 'edit';
		$data['row'] = $row;
		$data['language_columns'] = $this->blog_model->language_columns();
        $data['blog_categories'] = $this->blog_category_model->get_all([], 'id, slug ## title');
        $this->ajax_header('Edit Post: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/posts/adit_view', $data);
		$this->ajax_footer('edit');
	}


	public function view($id) { 
		//buttons
		$row = $this->blog_model->get_details($id, 'id', ['cat']);
        $xtra_butts = [
            ['type' => 'url_external', 'text' => 'View in Blog', 'target' => blog_article_url($row->date_created, $row->slug, false), 'icon' => 'eye']
        ];
        $this->butts = ['list', 'add', 'edit', 'xtra_butts' => $xtra_butts];
        $data['page'] = 'view';
		$data['row'] = $row;
        $data['language_columns'] = $this->blog_model->language_columns();
		$this->ajax_header('Post: '.$row->{'title_'.DEFAULT_LANGUAGE}, '', $id);
		$this->load->view('portal/admin/posts/adit_view', $data);
		$this->ajax_footer('view');
	}

}