<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Language_string_model extends Core_Model {
    public function __construct() {
        parent::__construct();
    }


    public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "ls.*";
        $select .= join_select($arr, 'value', "IFNULL(NULLIF(ls.value_{$this->active_language}, ''), ls.value_{$this->default_language})");
		$joins = []; 
        $order = ['ls.key' => 'asc'];
		return sql_data(T_LANGUAGE_STRINGS.' ls', $joins, $select, $where, $order);
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