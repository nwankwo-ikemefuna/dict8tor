<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Hands_on_info_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = [], $for_admin = false) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "hof.*";
        $select .= join_select($arr, 'title', "IFNULL(NULLIF(hof.title_{$this->active_language}, ''), hof.title_{$this->default_language})");
        $select .= join_select($arr, 'content', "IFNULL(NULLIF(hof.content_{$this->active_language}, ''), hof.content_{$this->default_language})");
		$joins = [];
		$language = $for_admin ? DEFAULT_LANGUAGE : $this->active_language;
		return sql_data(T_HANDS_ON_INFO.' hof', $joins, $select, $where, ["hof.title_{$language}" => 'asc']);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function language_columns() {
        return [
            'title' => ['title' => 'Title', 'input' => 'text'],
            'content' => ['title' => 'Content', 'input' => 'textarea', 'rows' => 12],
        ];
    }


	public function image_columns() {
        return [
			'featured_image' => ['title' => 'Featured Logo', 'dimension' => '303x90', 'ext' => 'png|jpg|jpeg', 'max' => 300, 'unit' => 'KB'],
		];
    }
	
}