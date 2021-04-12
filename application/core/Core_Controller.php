<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Core_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();

		//trashed?
		$this->trashed = trashed_record_list();
		//get current controller class 
		$this->c_controller = $this->router->fetch_class();
		$this->c_method = $this->router->fetch_method();
		//current page
		$this->page = $this->c_method;
		//page scripts
		$this->page_scripts = [];
		//module
		$this->module = '';
		//table
		$this->table = ''; //required esp for bulk action
		//max data 
		$this->max_data = '';
		//page buttons
		$this->butts = [];
		$this->inner_butts = [];
		//bulk action options
		$this->ba_opts = [];
		//injectable view files in page header
		$this->tv_file = null;

		//get site info
		$this->site_info = $this->setting_model->get_site_language_info();

		require_once 'application/config/http_codes.php';
		require_once 'application/config/consts.php';

		$this->default_language = DEFAULT_LANGUAGE;
		$this->active_language = $this->session->active_language ?? $this->default_language;

		// $this->is_campaign_phase = ($this->site_info->phase == 2);
		$this->is_campaign_phase = true;
		//set language strings
		$this->setting_model->set_lang_strings();
		$this->lang_strings = $this->session->language_strings[$this->active_language];

		//get candidate info
		$this->candidate_info = $this->candidate_model->get_details(1, 'type');
	}


	protected function web_header($page_title, $current_page = '') {
		$data['page_title'] = $page_title;
		$data['current_page'] = $current_page;
		return $this->load->view('web/layout/header', $data);
	}
	

	protected function web_footer($current_page = '') {
		$data['current_page'] = $current_page;
		return $this->load->view('web/layout/footer', $data);
	}


	protected function auth_header($page_title) {
		$data['page_title'] = $page_title;
		return $this->load->view('auth/layout/header', $data);
	}
	

	protected function auth_footer($current_page = '') {
		$data['current_page'] = $current_page;
		return $this->load->view('auth/layout/footer', $data);
	}
	
	
	protected function portal_header($page_title) {
		//update requested page to user if it's portal
		if ($this->session->ajax_requested_page == base_url('portal')) {
			$this->session->ajax_requested_page = base_url('user');
		} 
		$data['page_title'] = $page_title;
		$data['logout_url'] = 'logout';
		return $this->load->view('portal/layout/header', $data);
	}
	

	protected function portal_footer($current_page = '') {
		$data['current_page'] = $current_page;
		return $this->load->view('portal/layout/footer', $data);
	}


	protected function ajax_header($page_title, $record_count = '', $crud_rec_id = '', $max_data = '', $file_data = []) {
		$this->auth->ajax_request_restricted();
		$this->session->ajax_requested_page = get_requested_page();
		$data['page_title'] = $page_title;
		$data['record_count'] = $record_count;
		$data['crud_rec_id'] = $crud_rec_id;
		$data['max_data'] = $max_data;
		$data['file_data'] = $file_data;
		return $this->load->view('portal/layout/ajax_header', $data);
	}
	

	protected function ajax_footer($current_page = '') {
		$data['current_page'] = $current_page;
		return $this->load->view('portal/layout/ajax_footer', $data);
	}


	protected function check_data($table, $param, $where = [], $column = 'id', $redirect = 'forbidden') { 
		$found = $this->common_model->get_row($table, $param, $column, 0, [], '', $where);
		if ($found) return TRUE;
		$page = get_requested_page();
		$this->session->set_flashdata('error_msg', "The resource you tried to access at <b>{$page}</b> was not found. It may not exist, have been deleted, or you may not have permission to view it.");
		$redirect .= '?page='.$page;
		redirect($redirect);
    }


    public function check_loggedin() {
        if ($this->session->user_loggedin) return true;
        json_response('You are not logged in!', false);
    }


    public function check_userdata($user_id) {
        if ($user_id == $this->session->user_id) return true;
        json_response('Not allowed', false);
    }


    public function check_pass_strength() {
        $password = xpost('password');
        $check_pass = password_strength($password);
        //password cool...
        if ( ! $check_pass['has_err'] ) return true;
        $this->form_validation->set_message('check_pass_strength', $check_pass['err']);
        return false;
    }

    
    public function validate_captcha() { 
    	$input_captcha_code = $this->input->post('captcha_code', TRUE);
    	$sess_captcha_code = $this->session->tempdata('captcha_code');
    	//check if code entered is same as that saved in session
		if ($input_captcha_code === $sess_captcha_code) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_captcha', 'Invalid captcha! Refresh the captcha image or reload this page');
			return FALSE;
		}
	}
	
}