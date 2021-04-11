<?php
defined('BASEPATH') or die('Direct access not allowed');

class Blog extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    protected function header($page_title, $breadcrumbs = []) {
		$data['page_title'] = $page_title;
		$data['breadcrumbs'] = $breadcrumbs;
        $this->web_header(lang_string('blog'));
		return $this->load->view('blog/layout/header', $data);
	}
	

	protected function footer() {
        $featured_posts_where = ['b.published' => 1, 'b.featured' => 1];
        $data['featured_posts'] = $this->blog_model->get_all([], 'b.slug, b.date_created ## title', $featured_posts_where, 0, 4);
        $data['blog_categories'] = $this->blog_category_model->get_all([], 'slug ## title');
		$this->load->view('blog/layout/footer', $data);
        return $this->web_footer();
	}


    public function index() {
        $where = ['b.published' => 1];
        //searching?
        $search = urldecode(xget('q'));
        if ($search) {
            $this_where = $this->blog_model->search($search);
            $where = array_merge($where, [$this_where => null]);
        }
        $uri_segment = 2;
        $per_page = 3;
        $page = $this->uri->segment($uri_segment) ? $this->uri->segment($uri_segment) : 0;
        $offset = paginate_offset($page, $per_page);
        $records = $this->blog_model->get_all(['cat'], 'b.slug, b.featured_item_type, b.featured_item, b.date_created, b.published ## title, content, category_title, category_slug', $where, 0, $per_page, $offset);
        $total_records = $this->blog_model->get_total_record([], $where);
        $data = paginate($records, $total_records, $per_page, 'blog', $uri_segment);
        $breadcrumbs = [lang_string('home') => '', lang_string('blog') => '*'];
        $this->header(lang_string('blog'), $breadcrumbs);
        $this->load->view('blog/index', $data);
        $this->footer();
    }


    public function categories($slug) {
        //category details
        $cat_details = $this->blog_category_model->get_details($slug, 'slug', 'cat.id ## title');
        if (!$cat_details->id) {
            redirect('blog'); //all posts 
        }
        $uri_segment = 4;
        $per_page = 3;
        $page = $this->uri->segment($uri_segment) ? $this->uri->segment($uri_segment) : 0;
        $offset = paginate_offset($page, $per_page);
        $where = ['b.category_id' => $cat_details->id, 'b.published' => 1];
        $records = $this->blog_model->get_all(['cat'], 'b.slug, b.featured_item_type, b.featured_item, b.date_created, b.published ## title, content, category_title, category_slug', $where, 0, $per_page, $offset);
        $total_records = $this->blog_model->get_total_record([], $where);
        $data = paginate($records, $total_records, $per_page, 'blog/categories/'.$slug, $uri_segment);
        $breadcrumbs = [lang_string('home') => '', lang_string('blog') => 'blog', lang_string('blog_category') => '*'];
        $this->header($cat_details->title, $breadcrumbs);
        $this->load->view('blog/index', $data);
        $this->footer();
    }


    public function view($date, $slug) {
        if (!$date || !$slug) {
            redirect('blog'); //all posts 
        }
        $where = ['DATE(b.date_created)' => $date, 'b.published' => 1];
        $row = $this->blog_model->get_details($slug, 'slug', ['cat'], 'b.id, b.category_id, b.slug, b.featured_item_type, b.featured_item, b.date_created, b.published ## title, content, category_title, category_slug', $where);
        if (!$row) {
            redirect('blog'); //all posts 
        }
        $breadcrumbs = [lang_string('home') => '', lang_string('blog') => 'blog', lang_string('blog_post') => '*'];
        $data['row'] = $row;
        $related_posts_where = [
            'b.published' => 1, 
            'b.category_id' => $row->category_id, //same category
            'b.id !=' => $row->id, //not this post being viewed
        ];
        $data['related_posts'] = $this->blog_model->get_all(['cat'], 'b.slug, b.date_created, b.featured_item_type, b.featured_item, ## title, category_title, category_slug', $related_posts_where, 0, 3);
        $this->header($row->title, $breadcrumbs);
        $this->load->view('blog/view', $data);
        $this->footer();
    }

}