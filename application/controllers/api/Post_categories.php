<?php
defined('BASEPATH') or die('Direct access not allowed');

class Post_categories extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_POST_CATEGORIES;
		$this->module = MOD_BLOG_CATEGORIES;
		$this->model = 'blog_category';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = 'cat.id, cat.slug, cat.title_'.DEFAULT_LANGUAGE.' AS title, cat.order';
        $group_by = 'cat.id';
        $sql = $this->blog_category_model->sql([], $select, [], true);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $group_by);
    }


    private function adit($id = null) {
        $languages = get_site_languages();
        $language_columns = $this->blog_category_model->language_columns();
        $slug = url_title(strtolower(xpost('title_'.DEFAULT_LANGUAGE)));
        $data = [
            'slug' => $slug, 
            'order' => xpost('order')
        ];

        $this->form_validation->set_rules('order', 'Order', 'trim|required|is_natural');
        foreach ($language_columns as $key => $arr) {
            foreach ($languages as $lang) {
                $input_field = $key.'_'.$lang['key'];
                $this->form_validation->set_rules($input_field, $arr['title'], 'trim|required');
                $data[$input_field] = ($arr['input'] == 'textarea') ? xpost_txt($input_field) : ucwords(xpost($input_field));
            }
        }
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        //Slug already exists?
        $slug_exists = $this->common_model->exists($this->table, ['slug' => $slug], $id);
        if ($slug_exists) json_response('This category already exists', false);

        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'post_categories/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'post_categories/view/'.$id]);
    }
    
}