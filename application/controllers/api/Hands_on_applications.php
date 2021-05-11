<?php
defined('BASEPATH') or die('Direct access not allowed');

class Hands_on_applications extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_HANDS_ON_APPLICATIONS;
        $this->module = MOD_HANDS_ON;
        $this->model = 'hands_on_application';
		$this->auth->login_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


    public function get() { 
        response_headers();
        $butts = ['view', 'delete'];
        $keys = ['id'];
        $buttons = table_crud_butts($this->module, $this->model, ADMIN, $this->table, xget('trashed'), $keys, $butts);
        $select = "hop.id, hop.email, hop.phone, last_name, first_name, other_name, grant_project_title ## created_on, full_name, grant_project_lga_name, grant_project_budget_amount";
        //fetch
        $sql = $this->hands_on_application_model->sql(['lga', 'p_lga'], $select);
        echo $this->common_model->get_rows_ajax($sql['table'], $keys, $buttons, xget('trashed'), $sql['joins'], $sql['select'], $sql['where'], $sql['order']);
    }
	
}