<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    public function index() {
        $this->web_header(SITE_NAME.' - '.SITE_TAGLINE, 'home');
        $this->load->view('web/index');
        $this->web_footer('home');
    }

}