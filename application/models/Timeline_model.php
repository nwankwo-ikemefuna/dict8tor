<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Timeline_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = [], $for_admin = false) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "t.*";
        $select .= join_select($arr, 'title', "IFNULL(NULLIF(t.title_{$this->active_language}, ''), t.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(t.content_{$this->active_language}, ''), t.content_{$this->default_language})");
		$select .= join_select($arr, 'published_text', case_map_select('t.published', ['No', 'Yes']));
		$joins = []; 
		$language = $for_admin ? DEFAULT_LANGUAGE : $this->active_language;
		return sql_data(T_TIMELINES.' t', $joins, $select, $where, ['t.order' => 'asc', "t.title_{$language}" => 'asc']);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
	}


	public function language_columns() {
        return [
            'title' => ['title' => 'Title', 'input' => 'text'],
            'content' => ['title' => 'Content', 'input' => 'textarea', 'rows' => 12],
        ];
    }
	
}