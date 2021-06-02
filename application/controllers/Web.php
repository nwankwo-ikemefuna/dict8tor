<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->page_scripts = ['site'];
    }


    public function index() {
        $this->web_header(SITE_NAME.' - '.SITE_TAGLINE, 'home', ['image' => SITE_LOGO]);
        $this->load->view('web/index');
        $this->web_footer('home');
    }


    public function note() {
        $this->load->library('pdf');
        $config = [
            'title'         => 'My '.SITE_NAME.' Note',
            'subject'       => 'My '.SITE_NAME.' Note',
            'keywords'      => SITE_NAME,
            'with_header'   => false,
            'with_footer'   => false,
            'download'      => true,
            'output_type'   => 'text',
            'align'         => 'L', //left
            'file_name'     => strtolower(SITE_NAME.'_note.pdf'),
            'content'       => $this->session->last_dict8_note ?? 'Sample '.SITE_NAME.' Note',
        ];
        $this->pdf->generate($config);
    }

}