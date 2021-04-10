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


    public function contact() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_rules('captcha_code', 'Captcha', 'trim|required|callback_validate_captcha');

        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            'first_name' => ucfirst(xpost('first_name')),
            'last_name' => ucfirst(xpost('last_name')),
            'email' => strtolower(xpost('email')),
            'phone' => xpost('phone'),
            'message' => xpost_txt('message')
        ];
        $this->common_model->insert(T_CONTACTS, $data);
        $this->notify_vendors($data);
        json_response('Successful');
    }


    private function notify_vendors($data) {
        $where = ['usergroup' => ADMIN, 'level' => 1];
        $vendors = $this->user_model->get_all([], 'email', $where);
        $emails = extract_emails($vendors);
		$message = 	"Hi admin, <br />
					You have a new contact message from ".SITE_NAME.". <br />
					<b>Contact Details:</b><br /> 
					Name: {$data['first_name']} {$data['last_name']}<br />
					Email: {$data['email']} <br />
					Phone: {$data['phone']} <br /><br />
                    {$data['message']}";
		@send_mail(SITE_NOTIF_MAIL, $emails, 'New Contact Message', $message);
	}
    
}