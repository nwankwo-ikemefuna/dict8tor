<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    public function index() {
        $data['recent_posts'] = $this->blog_model->get_all([], "b.slug, b.featured_item_type, b.featured_item, b.date_created ## title, content", ['b.published' => 1], 0, 4);
        $data['timelines'] = $this->timeline_model->get_all([], "t.id, t.photo ## title, content", ['t.candidate_type' => 1, 't.published' => 1]);
        $data['priorities'] = $this->priority_model->get_all([], "p.icon ## title", ['p.published' => 1], 0, 4);
        $this->web_header(SITE_NAME.' - '.SITE_TAGLINE, 'home');
        $this->load->view('web/index', $data);
        $this->web_footer('home');
    }


    public function about() {
        $this->web_header(lang_string('about'), 'about');
        $this->load->view('web/about');
        $this->web_footer('home');
    }

}