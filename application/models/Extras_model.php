<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Extras_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "e.*";
		$joins = []; 
		return sql_data(T_EXTRAS.' e', $joins, $select, $where);
	}


	public function get_details($id, $by = 'key', $to_join = [], $select = "value", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		$row = $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
        $values_arr = json_decode($row->value, true) ?? [];
        unset($row->value); //we don't need lang data no more
        //set value in chosen language, use default if not specified
        $row->key = $values_arr[$this->active_language] ?: ($values_arr[DEFAULT_LANGUAGE] ?? '');
        return $row->key;
	}
	
}