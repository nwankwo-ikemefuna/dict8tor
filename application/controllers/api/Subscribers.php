<?php
defined('BASEPATH') or die('Direct access not allowed');

class Subscribers extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_SUBSCRIBERS;
        $this->module = MOD_SUBSCRIBERS;
        $this->model = 'subscriber';
		$this->auth->login_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function get() { 
        response_headers();
        $butts = ['view', 'edit', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "sub.id, email, phone ## created_on";
        //fetch
        $sql = $this->subscriber_model->sql([], $select);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order']);
    }


	private function adit($id = null) {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        //Email already exists?
        $email_exists = $this->common_model->exists($this->table, ['email' => strtolower(xpost('email'))], $id);
        if ($email_exists) json_response('Email is already subscribed', false);

        //Phone already exists?
        $phone_exists = $this->common_model->exists($this->table, ['phone' => xpost('phone')], $id);
        if ($phone_exists) json_response('Phone is already subscribed', false);

        $data = [
            'phone'         => xpost('phone'),
            'email'         => strtolower(xpost('email')),
        ];
        return $data;
    }


    public function add() {
        $this->auth->module_restricted($this->module, ADD, ADMIN);
        $data = $this->adit();
        $id = $this->common_model->insert($this->table, $data);
        json_response(['redirect' => 'subscribers/view/'.$id]);
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $id = xpost('id'); 
        $data = $this->adit($id);
        $this->common_model->update($this->table, $data, ['id' => $id]);
        json_response(['redirect' => 'subscribers/view/'.$id]);
    }
	
}