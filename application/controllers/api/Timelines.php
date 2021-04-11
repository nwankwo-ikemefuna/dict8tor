<?php
defined('BASEPATH') or die('Direct access not allowed');

class Timelines extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_TIMELINES;
        $this->module = MOD_TIMELINES;
        $this->model = 'timeline';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = 't.id, t.title_'.DEFAULT_LANGUAGE.' AS title, t.order ## published_text';
        $type = xget('type');
        $where = ['candidate_type' => $type];
        $group_by = 't.id';
        $sql = $this->timeline_model->sql([], $select, $where, true);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $group_by);
    }


    private function adit($id = null) {
        $languages = get_site_languages();
        $language_columns = $this->timeline_model->language_columns();
        $data = [
            'candidate_type' => xpost('candidate_type'), 
            'order' => xpost('order'),
            'published' => xpost('published') ?: 0
        ];
        
        $this->form_validation->set_rules('candidate_type', 'Candidate Type', 'trim|required|is_natural|in_list[1,2]');
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

        //Timeline already exists?
        $timeline_exists = $this->common_model->exists($this->table, ['title_'.DEFAULT_LANGUAGE => xpost('title_'.DEFAULT_LANGUAGE)], $id);
        if ($timeline_exists) json_response('This timeline already exists for this candidate', false);

        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $upload_conf = ['path' => 'uploads/pix/timelines', 'ext' => 'png|jpg|jpeg', 'size' => 300, 'required' => true];
        $file_name = upload_image('photo', $upload_conf, false);
        $data['photo'] = $file_name;
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'timelines/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $row = $this->timeline_model->get_details($id, 'id', [], 'photo');
        $data = $this->adit($id);
        $upload_conf = ['path' => 'uploads/pix/timelines', 'ext' => 'png|jpg|jpeg', 'size' => 300, 'required' => false];
        $file_name = upload_image('photo', $upload_conf, true, $row->photo);
        $data['photo'] = $file_name;
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'timelines/view/'.$id]);
    }
    
}