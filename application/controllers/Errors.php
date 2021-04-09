<?php
defined('BASEPATH') or die('Direct access not allowed');

class Errors extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function error_404() { 
        $layout = $this->layout_type();
        $header_method = $layout['header'];
        $footer_method = $layout['footer'];
        $data['is_ajax'] = $layout['is_ajax'];
        $this->$header_method('404');
        $this->load->view('errors/html/error_404', $data);
        $this->$footer_method();
    }   


    public function forbidden() { 
        $layout = $this->layout_type();
        $header_method = $layout['header'];
        $footer_method = $layout['footer'];
        $data['is_ajax'] = $layout['is_ajax'];
        $this->$header_method('403');
        $this->load->view('errors/html/error_403', $data);
        $this->$footer_method();
    }   


    private function layout_type() {
        if ($this->input->is_ajax_request()) {
            $header_method = 'ajax_header';
            $footer_method = 'ajax_footer';
            $is_ajax = true;
        } else {
            $header_method = 'auth_header';
            $footer_method = 'auth_footer';
            $is_ajax = false;
        }
        return ['header' => $header_method, 'footer' => $footer_method, 'is_ajax' => $is_ajax];
    }

}