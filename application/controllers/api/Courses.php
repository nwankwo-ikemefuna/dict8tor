<?php
defined('BASEPATH') or die('Direct access not allowed');

class Courses extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->table = T_COURSES;
        $this->module = MOD_COURSES;
        $this->model = 'course';
        $this->auth->login_restricted();
        $this->auth->module_restricted($this->module, VIEW, ADMIN);
        
    }


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "cu.id, cu.name, cu.code, cu.order, cu.dept_id, cu.total_classes, lect.last_name, lect.first_name, lect.other_name ## department, lecturer_lnames";
        $dept_id = xget('dept_id');
        $where = [];
        $where = strlen($dept_id) ? array_merge($where, ['cu.dept_id' => $dept_id]) : $where;
        $group_by = 'cu.id, lect.last_name, lect.first_name, lect.other_name';
        $sql = $this->course_model->sql(['d', 'lect'], $select, $where);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $group_by);
    }


    private function adit($id = null) {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('order', 'Order', 'trim|required|is_natural');
        $this->form_validation->set_rules('dept_id', 'Department', 'trim|required|is_natural');
        $this->form_validation->set_rules('classes[]', 'Classes', 'trim');
        $this->form_validation->set_rules('lecturers[]', 'Lecturers', 'trim');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        //already exists?
        $exists = $this->common_model->exists($this->table, ['dept_id' => xpost('dept_id'), 'code' => strtoupper(xpost('code'))], $id);
        if ($exists) json_response('Course with code ['.xpost('code').'] already exists in the selected department', false);
        $data = [
            'dept_id'       => xpost('dept_id'),
            'name'          => xpost('name'),
            'code'          => strtoupper(xpost('code')),
            'order'         => xpost('order'),
            'lecturers'     => join_us((array) xpost('lecturers')),
            'classes'       => join_us((array) xpost('classes')),
            'total_classes' => count((array) xpost('classes'))
        ];
        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'courses/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'courses/view/'.$id]);
    }
    
}