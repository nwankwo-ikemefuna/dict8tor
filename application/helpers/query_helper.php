<?php 
function sql_data($table, $joins, $select, $where, $order = null, $group_by = '') {
	return ['table' => $table, 'joins' => $joins, 'select' => $select, 'where' => $where, 'order' => $order, 'group_by' => $group_by];
}

function sql_select_arr($select) {
	//eg sample string: p.content, p.user_id ## avatar, comment_count
	//content and user_id are from main table while...
	//avatar and comment_count are from joined tables
	if ($select == '*' || ! preg_match('/##/', $select)) 
		return ['main' => $select, 'joins' => []];
	//do we have fields from joined tables => anything right of ## in select?
	$parts = array_map('trim', (array) split_us($select, '##'));
	$main = $parts[0];
	$joins = array_map('trim', (array) split_us($parts[1]));
	$arr = ['main' => $main, 'joins' => $joins];
	return $arr;
}

function join_select($arr, $key, $statement) {
	$select = "";
	if ($arr['main'] == '*' || in_array($key, $arr['joins'])) {
		$select = ", {$statement} AS {$key}";
	}
	return $select;
}

function full_name_select($table_alias = '', $with_alias = true, $alias = 'full_name', $prefix = '', $affix = '') {
	$tbl_alias = strlen($table_alias) ? "{$table_alias}." : '';
	//individual names
	$pfx = strlen($table_alias) ? "{$table_alias}_" : '';
	$select = "
		IFNULL({$tbl_alias}{$prefix}{$affix}title, '') AS {$pfx}title,  
		IFNULL({$tbl_alias}{$prefix}{$affix}first_name, '') AS {$pfx}first_name, 
		IFNULL({$tbl_alias}{$prefix}{$affix}last_name, '') AS {$pfx}last_name,  
		IFNULL({$tbl_alias}{$prefix}{$affix}other_name, '') AS {$pfx}other_name";
	//concatenated name
	$select .= ", TRIM(
		CONCAT(
			IFNULL({$tbl_alias}{$prefix}title{$affix}, ''), ' ', 
			IFNULL({$tbl_alias}{$prefix}first_name{$affix}, ''), ' ',
			IFNULL({$tbl_alias}{$prefix}other_name{$affix}, ''), ' ',
			IFNULL({$tbl_alias}{$prefix}last_name{$affix}, '') 
		))";
	$select .= $with_alias ? " AS {$alias}" : '';
	return $select;
}

function user_age_select($dob_column, $alias = '') {
	$alias = strlen($alias) ? " AS {$alias}" : '';
	$select = "IFNULL( 
	CONCAT(TIMESTAMPDIFF(YEAR, {$dob_column}, CURDATE()), (IF(TIMESTAMPDIFF(YEAR, {$dob_column}, CURDATE()) = 1, ' year', ' years'))), '') {$alias}";
	return $select;
}

function db_user_title($title) {
	return strlen(trim($title)) ? ucwords($title) : NULL;
}

function datetime_select($field, $alias = '', $full_month = false) {
	$month = $full_month ? 'M' : 'b';
	$as_alias = strlen($alias) ? "AS {$alias}" : '';
	return "DATE_FORMAT({$field}, '%D %{$month}, %Y at %h:%i %p') {$as_alias}";
}

function price_select($code_col, $price_col, $alias = 'amount', $precision = 0) {
	return "CONCAT('&#', {$code_col}, ';', CONVERT(FORMAT({$price_col}, {$precision}) using utf8)) AS {$alias}";
}

function file_select($path, $file_col, $default = '') {
	return "IF({$file_col} IS NULL, {$default}, CONCAT('{$path}', '/', {$file_col}))";
}

function case_map_select($col, $arr, $default = '') {
	$cases = "";
	foreach ($arr as $key => $value) {
		$cases .= "WHEN '{$key}' THEN '{$value}' ";
	}
	$cases .= strlen($default) ? "ELSE '{$default}'" : '';
	$select = "
		CASE {$col}
			{$cases}
		END";
	return $select;
}

function avatar_select_default($col) {
	$arr = [SEX_MALE => AVATAR_MALE, SEX_FEMALE => AVATAR_FEMALE];
	return case_map_select($col, $arr, AVATAR_GENERIC);
}

function gender_select($col) {
	$arr = [SEX_MALE => 'Male', SEX_FEMALE => 'Female'];
	return case_map_select($col, $arr);
}

function inset_join($col, $haystack) {
	return "FIND_IN_SET({$col}, {$haystack}) > 0";
}

function inset_select($col, $data) {
	$list = is_array($data) ? join_us($data) : $data;
	return "FIND_IN_SET({$col}, '{$list}') > 0";
}

function inset_select_col($col, $haystack_col) {
	return "FIND_IN_SET({$col}, IFNULL({$haystack_col}, '')) > 0";
}

function inset_select_mult($params, $field) {
	if (empty($params)) return [];
	$params_arr = is_array($params) ? $params : split_us($params);
	$where = [];
    foreach ($params_arr as $param) {
        $where[] = "FIND_IN_SET({$param}, {$field}) > 0";
    }
    $where = join(" OR ", $where);
    $where = '('.$where.')';
    return $where;
}

function json_extract_select($field, $key) {
	$lookup = '$."'.$key.'"';
    return "JSON_UNQUOTE(JSON_EXTRACT({$field}, '".$lookup."'))";
}

function language_column_select($keys_arr, $language, $alias = '') {
	$alias .= $alias ? '.' : '';
	$select = '';
	foreach ($keys_arr as $key) {
		$select .= "{$alias}{$key}_{$language} AS {$key}, ";
	}
	return $select;
}