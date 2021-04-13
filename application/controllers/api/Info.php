<?php
defined('BASEPATH') or die('Direct access not allowed');

class Info extends Core_controller {

	public function __construct() {
		parent::__construct();
        $this->table = T_INFO;
        $this->module = MOD_SETTINGS;
		$this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
	}
    
    
    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $phase = xpost('phase');
        $languages = get_site_languages();
        $language_columns = $this->info_model->language_columns();
        $data = [];
        foreach ($language_columns as $key => $arr) {
            foreach ($languages as $lang) {
                $input_field = $key.'_'.$lang['key'];
                $this->form_validation->set_rules($input_field, $arr['title'], 'trim|required');
                $data[$input_field] = ($arr['input'] == 'textarea') ? xpost_txt($input_field) : xpost($input_field);
            }
        }
        $data['intro_video'] = xpost('intro_video');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        //images
        $image_columns = $this->info_model->image_columns();
        $image_columns_select = implode(', ', array_keys($image_columns));
        $row = $this->info_model->get_details($phase, 'phase', [], $image_columns_select);
        foreach ($image_columns as $key => $arr) {
            $upload_conf = ['path' => 'uploads/pix/info', 'ext' => 'png|svg|jpg|jpeg', 'size' => $arr['max'], 'required' => false];
            $file_name = upload_image($key, $upload_conf, true, $row->$key);
            $data[$key] = $file_name;
        }
        $this->common_model->update($this->table, $data, ['phase' => $phase]);
        json_response(['redirect' => 'info/view/'.$phase]);
    }

}