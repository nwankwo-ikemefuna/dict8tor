<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Candidate_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "u.*";
		$select .= join_select($arr, 'full_name', full_name_select('u', false));
		$select .= join_select($arr, 'avatar', file_select('uploads/pix/info/', 'u.photo', avatar_select_default('u.sex')));
		$joins = []; 
		return sql_data(T_CANDIDATE_PROFILE.' u', $joins, $select, $where);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
	}
	
}