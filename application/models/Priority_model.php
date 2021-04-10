<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Priority_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "p.*";
        $select .= join_select($arr, 'title', "IFNULL(NULLIF(p.title_{$this->active_language}, ''), p.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(p.content_{$this->active_language}, ''), p.content_{$this->default_language})");
		$joins = []; 
		return sql_data(T_PRIORITIES.' p', $joins, $select, $where, ['p.order' => 'asc', "p.title_{$this->active_language}" => 'asc']);
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