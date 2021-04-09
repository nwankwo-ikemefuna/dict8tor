<?php
defined('BASEPATH') or die('Direct access not allowed');

class Messaging extends Core_controller {

	public function __construct() {
		parent::__construct();
        $this->module = MOD_MESSAGING;
		$this->auth->login_restricted();
        $this->auth->school_restricted(); 
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function custom_sms() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $this->form_validation->set_rules('numbers', 'Numbers', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $message = xpost('message');
        $numbers = xpost('numbers');
        //get school's sms units
        $sms_units = $this->school_model->get_details(SCHOOL_ID, 'id', [], 'sms_units')->sms_units;
        $sms = $this->sms->send($numbers, $message, $sms_units);
        json_response($sms['msg'], $sms['status']);
    }


    public function send_activation_sms() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $sms = $this->msg_model->send_activation_code();
        if ($sms['sent'] < 1) json_response($sms['error'], false);
        json_response("Message successfully sent to {$sms['sent']} ".inflect($sms['sent'], 'contact'));
    }

}