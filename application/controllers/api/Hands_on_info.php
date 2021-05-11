<?php
defined('BASEPATH') or die('Direct access not allowed');

class Hands_on_info extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_HANDS_ON_INFO;
		$this->module = MOD_HANDS_ON;
		$this->model = 'hands_on_info';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $languages = get_site_languages();
        $language_columns = $this->priority_model->language_columns();
        $data['published'] = xpost('published');
        $this->form_validation->set_rules('published', 'Published', 'trim|is_natural|in_list[0,1]');
        foreach ($language_columns as $key => $arr) {
            foreach ($languages as $lang) {
                $input_field = $key.'_'.$lang['key'];
                $this->form_validation->set_rules($input_field, $arr['title'], 'trim|required');
                $data[$input_field] = ($arr['input'] == 'textarea') ? xpost_txt($input_field) : ucwords(xpost($input_field));
            }
        }
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $this->common_model->update($this->table, $data, ['id' => 1]);
        json_response(['redirect' => 'hands_on_info/view']);
    }
    
}