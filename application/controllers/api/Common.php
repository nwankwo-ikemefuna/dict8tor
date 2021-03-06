<?php
defined('BASEPATH') or die('Direct access not allowed');

class Common extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function regenerate_csrf() {
        //the logic is already defined in json_response(), so...
        json_response();
    }


    public function regenerate_captcha() {
        $theme = xpost('theme') ?? [255, 255, 255];
        $captcha = generate_captcha($theme);
        json_response($captcha);
    }


    public function trash_ajax() { 
        $this->crud->trash_ajax();
    }


    public function bulk_trash_ajax() { 
        $this->crud->bulk_trash_ajax();
    }


    public function trash_all_ajax() { 
        $this->crud->trash_all_ajax();
    }


    public function restore_ajax() { 
        $this->crud->restore_ajax();
    }


    public function restore_all_ajax() { 
        $this->crud->restore_all_ajax();
    }


    public function bulk_restore_ajax() { 
        $this->crud->bulk_restore_ajax();
    }


    public function delete_ajax() { 
        $this->crud->delete_ajax();
    }


    public function bulk_delete_ajax() {
        $this->crud->bulk_delete_ajax();
    }


    public function clear_trash_ajax() { 
        $this->crud->clear_trash_ajax();
    }


    public function upload_smt_image() { 
        $this->summernote->upload();
    }


    public function delete_smt_image() { 
        $this->summernote->delete();
    }


    public function get_state_lgas() {
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $state = (int) xpost('state');
        $lgas = $this->lga_model->get_all([], "lga.id, lga.name", ['lga.state' => $state]);
        json_response($lgas);
    }
    
}