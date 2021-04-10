<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Blog_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "b.*";
		$select .= join_select($arr, 'title', "IFNULL(NULLIF(b.title_{$this->active_language}, ''), b.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(b.content_{$this->active_language}, ''), b.content_{$this->default_language})");
		$select .= join_select($arr, 'category_slug', "cat.slug");
		$select .= join_select($arr, 'category_title', "IFNULL(NULLIF(cat.title_{$this->active_language}, ''), cat.title_{$this->default_language})");
		$joins = [];
		//categories
		if (in_array('cat', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_POST_CATEGORIES.' cat' => ['cat.id = b.category_id', 'inner']]
			);
		}
		return sql_data(T_POSTS.' b', $joins, $select, $where, ['b.date_created' => 'desc', 'b.title_'.$this->active_language => 'asc']);
	}


    public function search($search) {
        //properly escape string
        $search = $this->db->escape_str($search, true);
        $where = sprintf("(
            b.`title_{$this->active_language}` LIKE '%s' OR b.`content_{$this->active_language}` LIKE '%s')",
            "%{$search}%", "%{$search}%"
        );
        return $where;
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
	
}