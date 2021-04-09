<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Blog_category_model extends Core_Model {
    public function __construct() {
        parent::__construct();
    }


    public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "cat.*";
        $cat_title = json_extract_select('cat.title', $this->active_language);
        $cat_slug = json_extract_select('cat.slug', $this->active_language);
        $cat_slug_default = json_extract_select('cat.slug', DEFAULT_LANGUAGE);
        $uncategorized = lang_string('uncategorized');
		$select .= join_select($arr, 'category_title', "IFNULL(NULLIF({$cat_title}, ''), '{$uncategorized}')");
		$select .= join_select($arr, 'category_slug', "IFNULL(NULLIF({$cat_slug}, ''), {$cat_slug_default})");
		$joins = [];
		return sql_data(T_POST_CATEGORIES.' cat', $joins, $select, $where, ['cat.order' => 'asc']);
	}


    public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		$row = $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
        return $row;
	}


    public function get_details_by_slug($slug, $select = "*") {
        $cat_slug = json_extract_select('cat.slug', $this->active_language);
        $where = [$cat_slug.' = ' => $slug];
		$sql = $this->sql([], $select, $where);
        $this->db->select($sql['select']);
        $this->db->where($sql['where']);
        $this->db->order_by('cat.order', 'asc');
        return $this->db->get($sql['table'])->row();
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		$rows = $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
        return $rows;
	}

}