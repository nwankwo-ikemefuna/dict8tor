<?php
defined('BASEPATH') or exit('Direct access to script not allowed');

class Setting_model extends Core_Model {
    public function __construct() {
        parent::__construct();
        $this->settings_table = 'settings';
        $this->info_table = 'info';
        $this->lang_strings_table = 'language_strings';
        $this->default_language = 'english';
    }


    public function sql($to_join = [], $select = "*", $where = []) {
		$arr = sql_select_arr($select);
		$select =  $select != '*' ? $arr['main'] : "s.*";
		$joins = []; 
        //phase info
		if (in_array('i', $to_join) || in_array('all', $to_join)) {
			$joins = array_merge($joins, 
				[$this->info_table.' i' => ['i.phase = s.phase', 'inner']] 
			);
		}
		return sql_data($this->settings_table.' s', $joins, $select, $where);
	}


	public function get_details($id, $by = 'id', $to_join = [], $select = "*", $where = [], $trashed = 0) {
		$sql = $this->sql($to_join, $select, $where);
		return $this->get_row($sql['table'], $id, $by, $trashed, $sql['joins'], $sql['select'], $sql['where'], $sql['group_by']);
	}


    public function get_site_language_info($active_language = null) {
        if (!$active_language) {
            $active_language = $this->session->active_language ?? $this->default_language;
        }
        //language specific data
        $lang_keys_arr = array_keys($this->language_columns());
        $info_select = language_column_select($lang_keys_arr, $active_language, 'i');
        $info_select .= 'i.poster_photo, i.about_intro_photo, i.about_family_photo, i.about_public_service_photo, i.intro_video_placeholder, i.intro_video';
        return $this->get_details(1, 'id', ['i'], "s.phase, s.logo, s.logo_portal, s.favicon, s.email, s.phone, s.address, {$info_select}");
    }


    public function set_lang_strings($reset = false) {
        $active_language = $this->session->active_language ?? $this->default_language;
        //is it already set for active language?
        if (!$reset && $this->session->has_userdata('language_strings') && isset($this->session->language_strings[$active_language]) && $this->session->language_strings[$active_language]) {
            // return false;
        }
        $rows = $this->language_string_model->get_all([], 'ls.key ## value');
        $strings_arr = [];
        foreach ($rows as $row) {
            $strings_arr[$row->key] = $row->value;
        }
        $lang_strings_arr[$active_language] = $strings_arr;
        $this->session->set_userdata('language_strings', $lang_strings_arr);
    }


    public function language_columns() {
        return [
            'name' => ['title' => 'Site Name', 'input' => 'text'],
            'initials' => ['title' => 'Site Short Name', 'input' => 'text'],
            'tagline' => ['title' => 'Tagline', 'input' => 'text'],
            'campaign_line' => ['title' => 'Campaign Line', 'input' => 'text'],
            'description' => ['title' => 'Description', 'input' => 'textarea', 'rows' => 5],
            'intro_msg' => ['title' => 'Introductory Message', 'input' => 'textarea', 'rows' => 5],
            'about_intro' => ['title' => 'About Intro', 'input' => 'textarea', 'rows' => 8],
            'about_family' => ['title' => 'About Family', 'input' => 'textarea', 'rows' => 8],
            'about_public_service' => ['title' => 'About Public Service', 'input' => 'textarea', 'rows' => 8],
        ];
    }

}