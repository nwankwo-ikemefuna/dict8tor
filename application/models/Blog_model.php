<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Blog_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "b.*";
        $cat_title = json_extract_select('cat.title', $this->active_language);
        $cat_slug = json_extract_select('cat.slug', $this->active_language);
        $cat_slug_default = json_extract_select('cat.slug', DEFAULT_LANGUAGE);
        $uncategorized = lang_string('uncategorized');
		$select .= join_select($arr, 'category_title', "IFNULL(NULLIF({$cat_title}, ''), '{$uncategorized}')");
		$select .= join_select($arr, 'category_slug', "IFNULL(NULLIF({$cat_slug}, ''), {$cat_slug_default})");
		$joins = [];
		//categories
		if (in_array('cat', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_POST_CATEGORIES.' cat' => ['cat.id = b.category_id', 'left']] //a post may not always have a category
			);
		}
		return sql_data(T_POSTS.' b', $joins, $select, $where, ['b.date_created' => 'desc', 'b.title' => 'asc']);
	}


    public function search($search) {
        //properly escape string
        $search = $this->db->escape_str($search, true);
        $where = sprintf("(
            b.`title` LIKE '%s' OR b.`content` LIKE '%s')",
            "%{$search}%", "%{$search}%"
        );
        return $where;
    }


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		$row = $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
        return $row;
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		$rows = $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
        return $rows;
	}


	public function get_total_record($to_join = [], $where = [], $trashed = 0) {
        $sql = $this->sql($to_join, '*', $where);
		return $this->count_rows($sql['table'], $sql['where'], $trashed);
	}
	
}