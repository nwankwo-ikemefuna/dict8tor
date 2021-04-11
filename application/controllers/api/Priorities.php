<?php
defined('BASEPATH') or die('Direct access not allowed');

class Priorities extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_PRIORITIES;
		$this->module = MOD_PRIORITIES;
		$this->model = 'priority';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = 'p.id, p.title_'.DEFAULT_LANGUAGE.' AS title, p.icon, p.order ## published_text';
        $group_by = 'p.id';
        $sql = $this->priority_model->sql([], $select, [], true);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $group_by);
    }


    private function adit($id = null) {
        $languages = get_site_languages();
        $language_columns = $this->priority_model->language_columns();
        $data = [
            'icon' => xpost('icon'),
            'order' => xpost('order'),
            'published' => xpost('published') ?: 0,
        ];

        $this->form_validation->set_rules('icon', 'Icon', 'trim|required');
        $this->form_validation->set_rules('order', 'Order', 'trim|required|is_natural');
        $this->form_validation->set_rules('published', 'Published', 'trim|is_natural|in_list[0,1]');
        foreach ($language_columns as $key => $arr) {
            foreach ($languages as $lang) {
                $input_field = $key.'_'.$lang['key'];
                $this->form_validation->set_rules($input_field, $arr['title'], 'trim|required');
                $data[$input_field] = ($arr['input'] == 'textarea') ? xpost_txt($input_field) : ucwords(xpost($input_field));
            }
        }
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        //Slug already exists?
        $priority_exists = $this->common_model->exists($this->table, ['title_'.DEFAULT_LANGUAGE => xpost('title_'.DEFAULT_LANGUAGE)], $id);
        if ($priority_exists) json_response('This issue/priority already exists', false);

        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'priorities/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'priorities/view/'.$id]);
    }
    
}