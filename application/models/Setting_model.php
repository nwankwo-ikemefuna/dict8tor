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


    public function get_site_info($active_language = null) {
        if (!$active_language) {
            $active_language = $this->session->active_language ?? $this->default_language;
        }
        $joins = [$this->info_table.' i' => ['i.phase = s.phase', 'inner']];
        $row = $this->get_row($this->settings_table.' s', 1, 'id', 0, $joins, 'i.*, s.phase AS active_phase, s.logo, s.logo_portal, s.favicon, s.email, s.phone, s.address');
        //language specific data
        $lang_info_arr = json_decode($row->lang_info, true) ?? [];
        unset($row->lang_info); //we don't need lang data no more
        $lang_keys_arr = array_keys($lang_info_arr);
        foreach ($lang_keys_arr as $key) {
            //set value in chosen language, use default if not specified
            if ($lang_info_arr) {
                $row->$key = $lang_info_arr[$key][$active_language] ?: ($lang_info_arr[$key][$this->default_language] ?? '');
            }
        }
        return $row;
    }


    public function set_lang_strings($reset = false) {
        $active_language = $this->session->active_language ?? $this->default_language;
        //is it already set for active language?
        if (!$reset && $this->session->has_userdata('language_strings') && isset($this->session->language_strings[$active_language]) && $this->session->language_strings[$active_language]) {
            return false;
        }
        $rows = $this->get_rows($this->lang_strings_table, 0, [], 'key, value');
        $strings_arr = [];
        foreach ($rows as $row) {
            $values_arr = json_decode($row->value, true) ?? [];
            //set value in chosen language, use default if not specified
            if ($values_arr) {
                $strings_arr[$row->key] = $values_arr[$active_language] ?: ($values_arr[$this->default_language] ?? '');
            }
        }
        $lang_strings_arr[$active_language] = $strings_arr;
        $this->session->set_userdata('language_strings', $lang_strings_arr);
    }

}