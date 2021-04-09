<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Priority_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "p.*";
		$joins = []; 
		return sql_data(T_PRIORITIES.' p', $joins, $select, $where, ['p.order' => 'asc', 'p.title' => 'asc']);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0, $defaulting = false) {
        if (!$defaulting) {
            $where = array_merge(['language' => $this->active_language], $where);
        }
		$sql = $this->sql($to_join, $select, $where);
		$row = $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
        if (!$row) {
            //in default language
            if (isset($where['language'])) {
                unset($where['language']);
            }
            $where = array_merge(['language' => DEFAULT_LANGUAGE], $where);
            $row = $this->get_details($id, $by, $to_join, $select, $where, $trashed, true);
        }
        return $row;
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0, $defaulting = false) {
        if (!$defaulting) {
            $where = array_merge(['language' => $this->active_language], $where);
        }
		$sql = $this->sql($to_join, $select, $where);
		$rows = $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
        if (!$rows) {
            //in default language
            if (isset($where['language'])) {
                unset($where['language']);
            }
            $where = array_merge(['language' => DEFAULT_LANGUAGE], $where);
            $rows = $this->get_all($to_join, $select, $where, $trashed, $limit, $offset, true);
        }
        return $rows;
	}
	
}