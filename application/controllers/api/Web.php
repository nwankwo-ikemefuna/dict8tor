<?php
defined('BASEPATH') or die('Direct access not allowed');

class Web extends Core_controller {
    public function __construct() {
        parent::__construct();
    }


    public function switch_language() {
        $this->form_validation->set_rules('language', 'Language', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        //ensure language has data for current phase
        $language = xpost('language');
        $info = $this->setting_model->get_site_language_info($language);
        if (!$info) json_response('Sorry! No content for selected language!', false);
        //switch it
        $this->session->set_userdata('active_language', $language);
        //(re)set language strings
        $this->setting_model->set_lang_strings(true);
        json_response('Successful');
    }


    public function subscribe() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[subscribers.email]', 
			array('is_unique' => lang_string('email_already_subscribed'))
		);
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural|is_unique[subscribers.phone]', 
			array('is_unique' => lang_string('phone_already_subscribed'))
		);

        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            'email' => strtolower(xpost('email')),
            'phone' => xpost('phone')
        ];
        $this->common_model->insert(T_SUBSCRIBERS, $data);
        json_response('Successful');
    }
    
}