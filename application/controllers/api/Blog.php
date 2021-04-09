<?php
defined('BASEPATH') or die('Direct access not allowed');

class Blog extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function search() {
        $this->form_validation->set_rules('q', 'Search Term', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $search = urlencode(xpost('q'));
        json_response(['redirect' => 'blog?q='.$search]);
    }
    
}