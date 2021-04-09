<?php
defined('BASEPATH') or die('Direct access not allowed');

class Permissions extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_PERMISSIONS;
        $this->module = MOD_PERMISSIONS;
        $this->model = 'permission';
		$this->auth->login_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "p.id, p.name ## employee_count";
        $sql = $this->permission_model->sql(['emp'], $select);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order']);
    }


	private function adit($id = null) {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('module_idx[]', 'Modules', 'trim|required');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        //already exists?
        $exists = $this->common_model->exists($this->table, ['name' => xpost('name')], $id);
        if ($exists) json_response('Role ['.xpost('name').'] already exists', false);

        $module_idx = (array) xpost("module_idx");
        $rights = [];
        foreach ($module_idx as $id) {
            if (!isset(xpost('rights')[$id])) continue;
            $role_rights = (array) xpost('rights')[$id];
            $rights[$id] = array_values($role_rights);
        }
        $data = [
            'name' => ucwords(xpost('name')),
            'rights' => json_encode($rights)
        ];
        return $data;
    }


	public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'permissions/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id');
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'permissions/view/'.$id]);
    }
	
}