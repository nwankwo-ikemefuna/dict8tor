<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Blog_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = [], $for_admin = false) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "b.*";
		$select .= join_select($arr, 'title', "IFNULL(NULLIF(b.title_{$this->active_language}, ''), b.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(b.content_{$this->active_language}, ''), b.content_{$this->default_language})");
		$select .= join_select($arr, 'category_slug', "cat.slug");
		$select .= join_select($arr, 'category_title', "IFNULL(NULLIF(cat.title_{$this->active_language}, ''), cat.title_{$this->default_language})");
		$select .= join_select($arr, 'category_title_default', "cat.title_{$this->default_language}");
		$select .= join_select($arr, 'featured_text', case_map_select('b.featured', ['No', 'Yes']));
		$select .= join_select($arr, 'published_text', case_map_select('b.published', ['No', 'Yes']));
		$select .= join_select($arr, 'created_on', datetime_select('b.date_created'));
		$joins = [];
		//categories
		if (in_array('cat', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_POST_CATEGORIES.' cat' => ['cat.id = b.category_id', 'inner']]
			);
		}
		$language = $for_admin ? DEFAULT_LANGUAGE : $this->active_language;
		return sql_data(T_POSTS.' b', $joins, $select, $where, ['b.date_created' => 'desc', 'b.title_'.$language => 'asc']);
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


	public function language_columns() {
        return [
            'title' => ['title' => 'Title', 'input' => 'text'],
            'content' => ['title' => 'Content', 'input' => 'textarea', 'rows' => 12],
        ];
    }
	
}