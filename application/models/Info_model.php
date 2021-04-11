<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Info_model extends Core_Model {
    public function __construct() {
        parent::__construct();
    }


    public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "i.*";
		$joins = []; 
		return sql_data(T_INFO.' i', $joins, $select, $where);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}

    public function image_columns() {
        return [
			'poster_photo' => ['title' => 'Poster Photo', 'dimension' => '1920x1050', 'max' => 300],
			'about_intro_photo' => ['title' => 'About Intro Photo', 'dimension' => '960x600', 'max' => 300],
			'about_family_photo' => ['title' => 'About Family Photo', 'dimension' => '960x600', 'max' => 300],
			'about_public_service_photo' => ['title' => 'About Public Service Photo', 'dimension' => '960x600', 'max' => 300],
			'intro_video_placeholder' => ['title' => 'Intro Video Placeholder Photo', 'dimension' => '768x432', 'max' => 300],
		];
    }

}