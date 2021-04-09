<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    public function index() {
        $data['recent_posts'] = $this->blog_model->get_all([], 'b.title, b.slug, b.content, b.date_created, b.featured_item_type, b.featured_item', ['b.published' => 1], 0, 4);
        $data['timelines'] = $this->timeline_model->get_all([], 't.id, t.title, t.photo, t.content', ['t.type' => 1]);
        $data['priorities'] = $this->priority_model->get_all([], 'p.title, p.icon', [], 0, 4);
        $data['priority_intro'] = $this->extras_model->get_details('priority_intro');
        $this->web_header(SITE_NAME.' - '.SITE_TAGLINE);
        $this->load->view('web/index', $data);
        $this->web_footer('home');
    }


    public function about() {
        $this->web_header(lang_string('about'));
        $this->load->view('web/about');
        $this->web_footer('home');
    }

}