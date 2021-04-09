<?php
defined('BASEPATH') or die('Direct access not allowed');

class Messaging extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->module = MOD_MESSAGING;
		$this->auth->login_restricted();
		$this->auth->def_password_restricted();
		$this->auth->school_restricted();
		$this->auth->module_restricted(MOD_MESSAGING, VIEW, ADMIN);
	}

	
	public function sms() { 
		$this->auth->module_restricted($this->module, ADD, ADMIN);
		//buttons
		$this->butts = ['save' => ['text' => 'Send', 'icon' => 'send']];
        $this->ajax_header('SMS Alerts');
		$this->load->view('portal/admin/messaging/sms');
		$this->ajax_footer();
	}


	private function get_sms_numbers() {
		//do we have some numbers already?
		if (xget('with_nums') == 1) {
			$numbers = join_us($this->session->flashdata('sms_numbers'), ', ');
			return $numbers;
		}
		return '';
	}

}