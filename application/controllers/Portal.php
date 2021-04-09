<?php
defined('BASEPATH') or die('Direct access not allowed');

/**
* @author Nwankwo Ikemefuna.
* Date Created: 31/12/2019
* Date Modified: 31/12/2019
*/

class Portal extends Core_controller {
	public function __construct() {
		parent::__construct();
		$this->auth->login_restricted();
		$this->page_scripts = ['portal'];
	}

	
	public function index() { 
		//set persistent data
		$this->set_persistent_data();
		$page_title = 'Portal';
		$this->portal_header($page_title);
		$this->load->view('portal/index'); 
		$this->portal_footer();
	}


	private function set_persistent_data() {

		//countries
		$countries = $this->country_model->get_all([], "cnt.id, cnt.name");
		$this->session->set_userdata('_countries', $countries);

		//states by country
		$country_states = $this->state_model->map('country');
		$this->session->set_userdata('_country_states', $country_states);
	}

}