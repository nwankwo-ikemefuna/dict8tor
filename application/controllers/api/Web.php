<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function save_note() {
        if (!$this->session->dict8_user_loggedin) {
            json_response('You must be logged in to save this note');
        }
        $this->form_validation->set_rules('note', 'Note', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            'owner_id' => $this->session->dict8_owner_id,
            'note' => xpost_txt('note'),
        ];
        $this->common_model->insert(T_NOTES, $data);
        json_response('Successful');
    }
    
}