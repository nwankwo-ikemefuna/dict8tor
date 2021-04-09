<?php
defined('BASEPATH') or die('Direct access not allowed');

class Employees extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_USERS;
        $this->module = MOD_EMPLOYEES;
        $this->model = 'user';
		$this->auth->login_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "u.id, last_name, first_name, other_name, email, phone, status, ## full_name, gender, permissions_name";
        $where = ['usergroup' => ADMIN];
        //fetch
        $sql = $this->user_model->sql(['p'], $select, $where);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order']);
    }


	private function adit($id = null) {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('other_name', 'Other Name', 'trim');
        $this->form_validation->set_rules('sex', 'Other Name', 'trim|required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural');
        if (!$id) {
            $this->form_validation->set_rules('password', 'Default Password', 'trim|required');
            $this->form_validation->set_rules('c_password', 'Confirm Default Password', 'trim|required|matches[password]');
        }
        $this->form_validation->set_rules('permissions[]', 'Permissions', 'trim');
        $this->form_validation->set_rules('active', 'Active', 'trim|in_list[0,1]');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        $dob = trim(xpost('dob'));
        if (strlen($dob) && !validate_date($dob, 'Y-m-d')) {
            json_response("Invalid Date of Birth format. Expected format is DD/MM/YYYY eg 23/06/2001", false);
        }

        //Email already exists?
        $email_exists = $this->common_model->exists($this->table, ['email' => xpost('email')], $id);
        if ($email_exists) json_response('Email is already in use', false);

        $permissions = (array) xpost('permissions');

        $data = [
            'usergroup'     => xpost('usergroup'),
            'first_name'    => ucwords(xpost('first_name')),
            'last_name'     => ucwords(xpost('last_name')),
            'other_name'    => ucwords(xpost('other_name')),
            'sex'           => xpost('sex'),
            'dob'           => strlen($dob) ? $dob : null,
            'phone'         => xpost('phone'),
            'email'         => strlen(xpost('email')) ? strtolower(xpost('email')) : NULL,
            'permissions'   => join_us($permissions),
            'active'        => xpost('active') ?? 0,
        ];
        if (!$id) {
            $data['password'] = password_hash(xpost('password'), PASSWORD_DEFAULT);
            $data['password_set'] = 0;
        }
        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $file_path = 'uploads/pix/users';
        $file_name = upload_photo($file_path, false);
        $data = $this->adit();
        $data["photo"] = $file_name;
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'employees/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id'); 
        $row = $this->user_model->get_details($id, 'id', [], 'photo');
        $file_path = 'uploads/pix/users';
        $file_name = upload_photo($file_path, true, $row->photo);
        $data = $this->adit($id);
        $data["photo"] = $file_name;        
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'employees/view/'.$id]);
    }
	
}