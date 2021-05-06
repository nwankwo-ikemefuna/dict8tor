<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Video_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = [], $for_admin = false) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "v.*";
		$select .= join_select($arr, 'title', "IFNULL(NULLIF(v.title_{$this->active_language}, ''), v.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(v.content_{$this->active_language}, ''), v.content_{$this->default_language})");
		$select .= join_select($arr, 'published_text', case_map_select('v.published', ['No', 'Yes']));
		$select .= join_select($arr, 'created_on', datetime_select('v.date_created'));
		$joins = [];
		$language = $for_admin ? DEFAULT_LANGUAGE : $this->active_language;
		return sql_data(T_VIDEOS.' v', $joins, $select, $where, ['v.date_created' => 'desc', 'v.title_'.$language => 'asc']);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
	}


	public function get_total_record($to_join = [], $where = [], $trashed = 0) {
        $sql = $this->sql($to_join, '*', $where);
		return $this->count_rows($sql['table'], $sql['where'], $trashed);
	}


	public function language_columns() {
        return [
            'title' => ['title' => 'Title', 'input' => 'text'],
            'content' => ['title' => 'URL', 'input' => 'text'],
        ];
    }
	
}