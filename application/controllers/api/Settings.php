<?php
defined('BASEPATH') or die('Direct access not allowed');

class Settings extends Core_controller {

	public function __construct() {
		parent::__construct();
        $this->table = T_SETTINGS;
        $this->module = MOD_SETTINGS;
		$this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
	}
    
    
    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $this->form_validation->set_rules('phase', 'Phase', 'trim|required|is_natural|in_list[1,2]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('show_language_options', 'Show Language Options', 'trim|is_natural|in_list[0,1]');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $data = [
            'phase'                 => xpost('phase'),
            'address'               => xpost('address'),
            'email'                 => xpost('email'),
            'phone'                 => xpost('phone'),
            'show_language_options' => xpost('show_language_options') ?: 0,
        ];
        $row = $this->setting_model->get_details(1, 'id', [], 's.logo, s.logo_portal, s.favicon');
        //images
        $image_columns = $this->setting_model->image_columns();
        $image_columns_select = implode(', ', array_keys($image_columns));
        $row = $this->setting_model->get_details(1, 'id', [], $image_columns_select);
        foreach ($image_columns as $key => $arr) {
            $upload_conf = ['path' => 'pix/logo', 'ext' => 'png|ico|jpg|jpeg', 'size' => $arr['max'], 'required' => false];
            $file_name = upload_image($key, $upload_conf, true, $row->$key);
            $data[$key] = $file_name;
        }
        $this->common_model->update($this->table, $data, ['id' => 1]);
        json_response(['redirect' => 'settings/view']);
    }

}