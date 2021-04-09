<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class State_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "stt.*";
		$select .= join_select($arr, 'country_name', "cnt.name");
		$joins = [];
		//countries
		if (in_array('cnt', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_COUNTRIES.' cnt' => ['cnt.id = stt.country', 'inner']]
			);
		}
		$order = ['stt.order' => 'asc'];
		return sql_data(T_STATES.' stt', $joins, $select, $where, $order);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by']);
	}


	public function map_details($by = 'id', $to_join = [], $select = "", $where = []) {
		$select = strlen($select) ? $select : "id, name, country";
		$rows = $this->get_all($to_join, $select, $where);
		return $this->map_row($rows, $by);
	}


	public function map($by = 'id', $to_join = [], $select = "", $where = []) {
		$select = strlen($select) ? $select : "id, name, country";
		$rows = $this->get_all($to_join, $select, $where);
		return $this->map_rows($rows, $by);
	}
	
}