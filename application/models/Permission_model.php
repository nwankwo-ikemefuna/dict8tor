<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Permission_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "p.*";
		$select .= join_select($arr, 'employee_count', "IFNULL(COUNT(emp.id), 0)");
		$joins = []; 
		//employee count
		if (in_array('emp', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_USERS.' emp' => ['p.id IN(emp.permissions)', 'left']]
			);
		}
		$order = ['p.id' => 'asc'];
		return sql_data(T_PERMISSIONS.' p', $joins, $select, $where, $order);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by']);
	}

}