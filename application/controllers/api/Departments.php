<?php
defined('BASEPATH') or die('Direct access not allowed');

class Departments extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_DEPARTMENTS;
        $this->module = MOD_DEPARTMENTS;
        $this->model = 'dept';
		$this->auth->login_restricted();
		$this->auth->school_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "d.id, d.name, d.order, hod.last_name, hod.first_name, hod.other_name ## hod, class_count";
        $where = ['d.school_id' => SCHOOL_ID];
        $sql = $this->dept_model->sql(['c', 'hod'], $select, $where);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order']);
    }


	private function adit($id = null) {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('order', 'Order', 'trim|required|is_natural');
        $this->form_validation->set_rules('hod_id', 'HOD', 'trim|is_natural');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);
        //already exists?
        $exists = $this->common_model->exists($this->table, ['name' => xpost('name')], $id);
        if ($exists) json_response('Department ['.xpost('name').'] already exists', false);
        $data = [
            'school_id' => SCHOOL_ID,
            'hod_id'    => strlen(xpost('hod_id')) ? xpost('hod_id') : NULL,
            'name'      => xpost('name'),
            'order'     => xpost('order'),
        ];
        return $data;
    }


	public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'departments/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'departments/view/'.$id]);
    }
	
}