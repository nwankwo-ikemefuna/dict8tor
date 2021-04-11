<?php
defined('BASEPATH') or die('Direct access not allowed');

class Candidates extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->table = T_CANDIDATES;
		$this->module = MOD_CANDIDATES;
        $this->model = 'user';
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->module_restricted($this->module, VIEW, ADMIN);
    }


    public function index() { 
    	redirect('candidates/view/1');
	}
    

	public function view($type) { 
		//buttons
		$xtra_butts = [
            ['text' => 'Timelines', 'target' => 'timelines', 'icon' => 'calendar']
        ];
        $this->butts = ['edit', 'xtra_butts' => $xtra_butts];
		$row = $this->candidate_model->get_details($type, 'type');
		if (!$row) {
			redirect('user');
		}
		$data['row'] = $row;
        $this->ajax_header($row->full_name, '', $type);
		$this->load->view('portal/admin/candidates/view', $data);
		$this->ajax_footer();
	}


	public function edit($type) {
		$this->auth->module_restricted($this->module, EDIT, ADMIN);
		//buttons
		$this->butts = ['save', 'view', 'cancel'];
		$row = $this->candidate_model->get_details($type, 'type');
		if (!$row) {
			redirect('user');
		}
		$data['page'] = 'edit';
		$data['row'] = $row;
        $this->ajax_header('Edit Candidate: '. $row->full_name, '', $type);
        $this->load->view('portal/admin/candidates/adit', $data);
		$this->ajax_footer();
	}

}