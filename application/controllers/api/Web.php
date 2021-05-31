<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function note_actions() {
        $this->form_validation->set_rules('action', 'Note Action', 'trim|required|in_list[save,export_pdf]');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $action = xpost('action');
        switch ($action) {
            case 'save':
                $this->save_note();
                break;
            case 'export_pdf':
                $this->session->set_userdata('last_dict8_note', xpost('note'));
                json_response('Successful');
                break;
            default:
                # code...
                break;
        }
    }


    private function save_note() {
        if (!$this->session->dict8_user_loggedin) {
            json_response('You must be logged in to save this note');
        }
        $data = [
            'owner_id' => $this->session->dict8_owner_id,
            'note' => xpost_txt('note'),
        ];
        $this->common_model->insert(T_NOTES, $data);
        json_response('Successful');
    }

    
}