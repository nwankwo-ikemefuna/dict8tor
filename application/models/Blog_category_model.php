<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Blog_category_model extends Core_Model {
    public function __construct() {
        parent::__construct();
    }


    public function sql($to_join = [], $select = "*", $where = [], $for_admin = false) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "cat.*";
        $select .= join_select($arr, 'title', "IFNULL(NULLIF(cat.title_{$this->active_language}, ''), cat.title_{$this->default_language})");
		$joins = [];
		$language = $for_admin ? DEFAULT_LANGUAGE : $this->active_language;
		return sql_data(T_POST_CATEGORIES.' cat', $joins, $select, $where, ['cat.order' => 'asc', 'cat.title_'.$language => 'asc']);
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
            'title' => ['title' => 'Title', 'input' => 'text']
        ];
    }

}