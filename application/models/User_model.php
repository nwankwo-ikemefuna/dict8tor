<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class User_model extends Core_Model {
	public function __construct() {
		parent::__construct();
	}


	public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "u.*";
		$select .= join_select($arr, 'full_name', full_name_select('u', false));
		$select .= join_select($arr, 'usergroup_name', "ug.name");
		$select .= join_select($arr, 'usergroup_title', "ug.title");
		$select .= join_select($arr, 'gender', gender_select('u.sex'));
		$select .= join_select($arr, 'age', user_age_select("u.dob"));
		$select .= join_select($arr, 'account_status', case_map_select('u.active', ACC_STATUSES));
		$select .= join_select($arr, 'permissions_name', "GROUP_CONCAT(DISTINCT `p`.`name` SEPARATOR ', ')");
		$select .= join_select($arr, 'avatar', file_select('uploads/pix/users/', 'u.photo', avatar_select_default('u.sex')));
		$joins = []; 
		//usergroups
		if (in_array('ug', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_USERGROUPS.' ug' => ['u.usergroup = ug.id', 'inner']]
			);
		}
		//permissions
		if (in_array('p', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[T_PERMISSIONS.' p' => [inset_join('`p`.`id`', '`u`.`permissions`'), 'left', false]]
			);
		}
		return sql_data(T_USERS.' u', $joins, $select, $where);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


	public function get_all($to_join = [], $select = "", $where = [], $trashed = 0, $limit = '', $offset = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_rows($sql['table'], $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['order'], $sql['group_by'], $limit, $offset);
	}
	
}