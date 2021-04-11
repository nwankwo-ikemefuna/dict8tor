<?php
defined('BASEPATH') or die('Direct access not allowed');

class Candidates extends Core_controller {
	public function __construct() {
		parent::__construct();
        $this->table = T_CANDIDATES;
        $this->module = MOD_CANDIDATES;
        $this->model = 'candidate';
		$this->auth->login_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
	}


	private function adit() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('other_name', 'Other Name', 'trim');
        $this->form_validation->set_rules('display_name_short', 'Short Display Name', 'trim|required');
        $this->form_validation->set_rules('display_name_full', 'Full Display Name', 'trim|required');
        $this->form_validation->set_rules('sex', 'Other Name', 'trim|required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_natural');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        $this->form_validation->set_rules('office', 'Office Sought', 'trim|required');
        $this->form_validation->set_rules('sm_facebook', 'Facebook Handle', 'trim');
        $this->form_validation->set_rules('sm_twitter', 'Twitter Handle', 'trim');
        $this->form_validation->set_rules('sm_instagram', 'Instagram Handle', 'trim');
        if ($this->form_validation->run() === FALSE) json_response(validation_errors(), false);

        $dob = trim(xpost('dob'));
        if (strlen($dob) && !validate_date($dob, 'Y-m-d')) {
            json_response("Invalid Date of Birth format. Expected format is DD/MM/YYYY eg 23/06/2001", false);
        }

        $data = [
            'first_name'    => ucwords(xpost('first_name')),
            'last_name'     => ucwords(xpost('last_name')),
            'other_name'    => ucwords(xpost('other_name')),
            'sex'           => xpost('sex'),
            'dob'           => strlen($dob) ? $dob : null,
            'phone'         => xpost('phone'),
            'email'         => strtolower(xpost('email')),
            'address'       => xpost_txt('address'),
            'office'        => xpost('office'),
            'sm_facebook'   => xpost('sm_facebook'),
            'sm_twitter'    => xpost('sm_twitter'),
            'sm_instagram'  => xpost('sm_instagram'),
        ];
        return $data;
    }


    public function edit() {
        $this->auth->module_restricted($this->module, EDIT, ADMIN);
        $type = xpost('type'); 
        $data = $this->adit(); 
        $this->common_model->update($this->table, $data, ['type' => $type]);
        json_response(['redirect' => 'candidates/view/'.$type]);
    }
	
}