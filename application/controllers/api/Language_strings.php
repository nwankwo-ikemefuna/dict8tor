<?php
defined('BASEPATH') or die('Direct access not allowed');

class Language_strings extends Core_controller {

	public function __construct() {
		parent::__construct();
        $this->table = T_LANGUAGE_STRINGS;
        $this->module = MOD_LANGUAGE_STRINGS;
		$this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
	}
    
    
    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $languages = get_site_languages();
        $idx = (array) xpost('idx');
        $def_editables = (array) xpost('def_editables');
        $data = [];
        foreach ($idx as $id) {
            $default_editable = $def_editables[$id];
            foreach ($languages as $lang) {
                $col = 'value_'.$lang['key'];
                $input_field = "{$col}[{$id}]";
                if (isset(xpost($col)[$id])) {
                    $this->form_validation->set_rules($input_field, '', 'trim|required', ['required' => 'Ensure all fields are filled correctly']);
                    $data[] = [
                        'id' => $id,
                        $col => $default_editable ? xpost_txt($input_field) : xpost($input_field),
                    ];
                }
            }
        }
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        $this->common_model->update_batch($this->table, $data, 'id');
        json_response(['redirect' => 'language_strings/view']);
    }

}