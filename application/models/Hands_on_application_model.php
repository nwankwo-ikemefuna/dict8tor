<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Hands_on_application_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "hop.*";
		$select .= join_select($arr, 'full_name', full_name_select('u', false));
		$select .= join_select($arr, 'gender', gender_select('hop.sex'));
		$select .= join_select($arr, 'age', user_age_select("hop.dob"));
		$select .= join_select($arr, 'state_name', "stt.name");
		$select .= join_select($arr, 'lga_name', "lga.name");
		$select .= join_select($arr, 'applicant_status_text', case_map_select('hop.applicant_status', ACC_STATUSES));
        $select .= join_select($arr, 'created_on', datetime_select('hop.date_created'));
		$joins = [];
		//states
		if (in_array('stt', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_STATES.' stt' => ['stt.id = hop.state']]
			);
		} 
		//lgas
		if (in_array('lga', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_LGAS.' lga' => ['lga.id = hop.lga']]
			);
		} 
		return sql_data(T_HANDS_ON_APPLICATIONS.' hop', $joins, $select, $where);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
	}


	public function form_elements_applicant($states, $lgas) {
		$form_elements = [
			['name' => 'first_name', 'title' => 'First Name', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'last_name', 'title' => 'Last Name', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'dob', 'title' => 'Date of Birth', 'type' => 'date', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'email', 'title' => 'Email Address', 'type' => 'email', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'phone', 'title' => 'Mobile Number', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'address', 'title' => 'Residential Address', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 6],
			['name' => 'state', 'title' => 'State of Origin', 'type' => 'select', 'class' => '', 'options' => $states, 'text_col' => 'name', 'id' => 'nigerian_states', 'value' => CRS_ID, 'required' => true, 'col' => 6],
			['name' => 'lga', 'title' => 'LGA of Origin', 'type' => 'select', 'class' => '', 'options' => $lgas ?? [], 'text_col' => 'name', 'required' => true, 'col' => 6],
			['name' => 'qualification', 'title' => 'Highest Educational Qualification', 'type' => 'select', 'class' => '', 'options' => educational_qualifications(), 'required' => true, 'col' => 6],
			['name' => 'about', 'title' => 'Tell us about yourself in 200 words', 'type' => 'textarea', 'class' => '', 'rows' => 4, 'required' => true, 'col' => 12],
		];
		return $form_elements;
	}


	public function form_elements_grant($lgas) {
		$form_elements = [
			['name' => 'grant_project_title', 'title' => 'Project Name', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 12],
			['name' => 'grant_project_lga', 'title' => 'Project Location (LGA)', 'type' => 'select', 'class' => '', 'options' => $lgas ?? [], 'text_col' => 'name', 'required' => true, 'col' => 4],
			['name' => 'grant_project_ward', 'title' => 'Project Location (Ward)', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 4],
			['name' => 'grant_project_community', 'title' => 'Project Location (Community)', 'type' => 'text', 'class' => '', 'required' => true, 'col' => 4],
			['name' => 'grant_project_goals', 'title' => 'Project Goal/Objectives', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_description', 'title' => 'Project Description', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_expected_outcome', 'title' => 'Expected outcome/achievement of project', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_volunteer_impact', 'title' => 'Briefly describe how volunteering will play a role in the execution of this project', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_implementation', 'title' => 'Project implementation strategies and timelines', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_budget', 'title' => 'Proposed budget', 'type' => 'number', 'class' => '', 'required' => true, 'col' => 12],
			['name' => 'grant_project_budget_specifics', 'title' => 'What specific aspects of the project budget will this grant be used for?', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_sustainability_plan', 'title' => 'What is the sustainability plan for this project?', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => true, 'col' => 12],
			['name' => 'grant_project_video', 'title' => 'Upload a video of 60 seconds or under on Youtube explaining your project', 'type' => 'url', 'class' => '', 'required' => true, 'col' => 12, 'placeholder' => 'Paste the Youtube video link here'],
		];
		return $form_elements;
	}


	public function form_elements_ngo() {
		$form_elements = [
			['name' => 'ngo_name', 'title' => 'Name of organisation', 'type' => 'text', 'class' => '', 'required' => false, 'col' => 12],
			['name' => 'ngo_registered', 'title' => 'Is organisation registered with Corporate Affairs Commission?', 'type' => 'select', 'class' => '', 'id' => 'ngo_registered', 'options' => [0 => 'No', 1 => 'Yes'], 'required' => false, 'col' => 12, 'assoc' => true],
			['name' => 'ngo_reg_id', 'title' => 'Registration ID', 'type' => 'text', 'class' => '', 'required' => false, 'col' => 6, 'form_group_class' => 'ngo_reg_section', 'hidden' => true],
			['name' => 'ngo_reg_date', 'title' => 'Date of registration', 'type' => 'date', 'class' => '', 'required' => false, 'col' => 6, 'form_group_class' => 'ngo_reg_section', 'hidden' => true],
			['name' => 'ngo_mission_vision', 'title' => 'Vision & Mission of the organisation', 'type' => 'textarea', 'class' => '', 'rows' => 6, 'required' => false, 'col' => 12],
			['name' => 'ngo_applicant_position', 'title' => 'What is your position in the organisation?', 'type' => 'text', 'class' => '', 'required' => false, 'col' => 12],
		];
		return $form_elements;
	}
	
}