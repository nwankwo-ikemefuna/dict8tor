<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    public function index() {
        $data['recent_posts'] = $this->blog_model->get_all([], "b.slug, b.featured_image, b.featured_video, b.date_created ## title, content", ['b.published' => 1], 0, 4);
        $data['recent_videos'] = $this->video_model->get_all([], "## title, content", ['v.published' => 1], 0, 4);
        $data['timeline_groups'] = $this->timeline_group_model->get_all([], "tg.id ## title", ['tg.published' => 1]);
        $data['timelines'] = $this->timeline_model->map('group_id', [], "t.id, t.group_id, t.photo ## title, content", ['t.candidate_type' => 1, 't.published' => 1]);
        $data['priorities'] = $this->priority_model->get_all([], "p.icon ## title", ['p.published' => 1], 0, 4);
        $this->web_header(SITE_NAME.' - '.SITE_TAGLINE, 'home');
        $this->load->view('web/index', $data);
        $this->web_footer('home');
    }


    public function about() {
        $breadcrumbs = [lang_string('home') => '', lang_string('about') => '*'];
        $this->web_header(lang_string('about'), 'about', [], $breadcrumbs);
        $this->load->view('web/about');
        $this->web_footer('about');
    }


    public function videos() {
        $where = ['v.published' => 1];
        $uri_segment = 2;
        $per_page = 4;
        $page = $this->uri->segment($uri_segment) ? $this->uri->segment($uri_segment) : 0;
        $offset = paginate_offset($page, $per_page);
        $records = $this->video_model->get_all([], 'v.published ## title, content', $where, 0, $per_page, $offset);
        $total_records = $this->video_model->get_total_record([], $where);
        $data = paginate($records, $total_records, $per_page, 'videos', $uri_segment);
        $breadcrumbs = [lang_string('home') => '', lang_string('videos') => '*'];
        $this->web_header(lang_string('videos'), 'videos', [], $breadcrumbs);
        $this->load->view('web/videos', $data);
        $this->web_footer('videos');
    }


    public function hands_on() {
        $this->page_scripts = array_merge($this->page_scripts, ['hands_on']);
        if (!$this->hands_on_info->published) {
            redirect('');
        }
        $states = $this->state_model->get_all([], "stt.id, stt.name", ['stt.country' => C_NIGERIA_ID]);
        $lgas = $this->lga_model->get_all([], "lga.id, lga.name", ['lga.state' => CRS_ID]);
        $data['form_elements_applicant'] = $this->hands_on_application_model->form_elements_applicant($states, $lgas);
        $data['form_elements_grant'] = $this->hands_on_application_model->form_elements_grant($lgas);
        $data['form_elements_ngo'] = $this->hands_on_application_model->form_elements_ngo();
        $breadcrumbs = [lang_string('home') => '', lang_string('hands_on') => '*'];
        $meta_image = get_uploaded_file('pix/info/'.$this->hands_on_info->featured_image);
        $this->web_header(lang_string('hands_on'), 'hands_on', ['image' => $meta_image], $breadcrumbs);
        $this->load->view('web/hands_on', $data);
        $this->web_footer('hands_on');
    }

}