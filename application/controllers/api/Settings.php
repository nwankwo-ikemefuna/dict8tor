<?php
defined('BASEPATH') or die('Direct access not allowed');

class Settings extends Core_controller {

	public function __construct() {
		parent::__construct();
        $this->table = T_SCHOOLS;
        $this->module = MOD_SETTINGS;
		$this->auth->login_restricted();
        $this->auth->school_restricted(); 
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
	}
    
    
    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('short_name', 'Short Name', 'trim|required');
        $this->form_validation->set_rules('tagline', 'Motto', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            "name"          => xpost('name'),
            "short_name"    => xpost('short_name'),
            "tagline"       => xpost('tagline'),
            "address"       => xpost('address'),
            "email"         => xpost('email'),
            "phone"         => xpost('phone'),
        ];
        $this->common_model->update($this->table, $data, ['id' => SCHOOL_ID]);
        //reset session data
        $this->school_model->set_school_info(SCHOOL, true);
        json_response(['redirect' => 'settings/view']);
    }

}