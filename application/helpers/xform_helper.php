<?php 
function xform_open($action = '', $attributes = [], $hidden = []) {
    $action .= q_string();
    echo form_open($action, $attributes, $hidden);
}

function xform_open_multipart($action = '', $attributes = [], $hidden = []) {
    $action .= q_string();
    echo form_open_multipart($action, $attributes, $hidden);
}

function xform_close($extra = '') {
    echo form_close($extra);
}

function xform_attrs($id = '', $type = 'redirect', $redirect = '_ajax_dynamic', $msg = '', $notice_box = 'status_msg', $status_modal = 0, $loading_msg = 'Loading') {
    $ci =& get_instance();
    $attrs = [
        'id' => strlen($id) ? $id : $ci->c_method.'_form', //default eg add_form, edit_form, etc
        'class' => 'ajax_form', 
        'data-type' => $type, 
        'data-redirect' => $redirect,
        'data-msg' => $msg,
        'data-notice' => $notice_box,
        'data-status_modal' => $status_modal,
        'data-loading_msg' => $loading_msg,
    ];
    return $attrs;
}

function xform_ib_attrs($id, $type = 'redirect', $redirect = '_ajax_dynamic', $msg = '', $notice_box = 'ib_msg_box') {
    return xform_attrs($id, $type, $redirect, $msg, $notice_box);
}

function xform_pre_notice($msg = '', $class = '', $id = '') {
    $id = attr_isset($id, 'id="'.$id.'"', ''); ?>
    <div class="m-t-10 m-b-10 <?php echo $class; ?>" <?php echo $id; ?>>
        <?php echo strlen($msg) ? '<p>'.$msg.'</p>' : ''; ?> 
        All fields marked <span class="text-danger">*</span> are required.
    </div>
    <?php
}

function xform_notice($class = 'status_msg', $id = '', $auto_dismiss = true) {
    $id = attr_isset($id, 'id="'.$id.'"', ''); ?>
    <div class="m-t-10 m-b-10 <?php echo $class; ?>" data-auto_dismiss = "<?php echo (int)$auto_dismiss; ?>" <?php echo $id; ?> ></div>
    <?php
}

function xform_label($label, $for = '', $extra = [], $return = false) {
    //if associated field has required attribute, append * to label name
    $label .= isset($extra['required']) && $extra['required'] ? ':<span class="text-danger">*</span>' : ':';
    //prepend bs class
    $extra['class'] = 'form-control-label '.input_key_isset($extra, 'class', '');
    $for = attr_isset($for, 'for="'.$for.'"', '');
    $elem = '<label '.$for.' '.set_extra_attrs($extra).'  style="padding-top: 10px">'.$label.'</label>';
    if ($return) return $elem;
    echo $elem;
}

function xform_text($text, $class = '', $return = false) {
    $elem = '<div class="'.$class.'"><small class="text-muted m-b-20">'.$text.'</small></div>';
    if ($return) return $elem;
    echo $elem;
}

function xform_help($extra, $return = false) {
    $elem = '';
    if (array_key_exists('help', $extra)) {
        $class = input_key_isset($extra, 'help_class', '');
        $id = input_key_isset($extra, 'help_id', '');
        $elem = '<div class="'.$class.'" '.$id.'><small class="text-muted m-b-20">'.$extra['help'].'</small></div>';
    }
    if ($return) return $elem;
    echo $elem;
}

function xform_check($label, $name, $type = 'checkbox', $id = '', $value = '', $checked = false, $required = false, $inline = false, $extra = [], $return = false) {
    $checked = $checked ? 'checked' : '';
    $required = $required ? 'required' : '';
    $inline_class = $inline ? 'form-check-inline' : '';
    //custom attrs
    $class = $extra['class'] ?? '';
    $gclass = $extra['gclass'] ?? '';
    if (isset($extra['class'])) unset($extra['class']);
    if (isset($extra['gclass'])) unset($extra['gclass']);
    $elem = '<div class="form-check '.$inline_class.' '.$gclass.'">
                <input class="form-check-input chk_rad_15 '.$class.'" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$checked.' '.$required.' '.set_extra_attrs($extra).'>
                <label class="form-check-label text-bold" for="'.$id.'">'.$label.'</label>
            </div>';
    if ($return) return $elem;
    echo $elem;
}

function form_custom_switch($label, $name, $type = 'primary', $id = '', $value = '', $checked = false, $required = false, $extra = [], $return = false) {
    $id_attr = $id ? 'id="'.$id.'"' : '';
    $checked = $checked ? 'checked' : '';
    $required = $required ? 'required' : '';
    $disabled = isset($extra['disabled']) && $extra['disabled'] ? 'disabled' : '';
    $with_padding_class = isset($extra['with_padding']) && $extra['with_padding'] ? 'switch-with-padding' : '';
    $elem = '<div class="form-group">
        <div class="checkbox checkbox-switch switch-'.$type.' '.$with_padding_class.'">
            <label>
                <input type="checkbox" name="'.$name.'" value="'.$value.'" '.$id_attr.' '.$checked.' '.$required.' '.$disabled.' />
                <span></span>
                '.$label.'
            </label>
        </div>
    </div>';
    if ($return) return $elem;
    echo $elem;
}

function xform_input($name, $type = 'text', $value = '', $required = false, $extra = [], $return = false) {
    //prepend bs class
    if ( ! in_array($type, ['checkbox', 'radio', 'file'])) {
        $extra['class'] = 'form-control '.input_key_isset($extra, 'class', '');
    }
    // var_dump($extra); 
    $attrs = set_extra_attrs($extra);
    $required = $required ? 'required' : '';
    if ($type == 'textarea') {
        $rows = input_key_isset($extra, 'rows', 8);
        $elem = '<textarea name="'.$name.'" rows="'.$rows.'" '.$required.' '.$attrs.'>'.$value.'</textarea>';
        $elem .= xform_help($extra, true);
    } elseif ($type == 'file') {
        $extra['class'] = 'file_input '.input_key_isset($extra, 'class', '');
        $exclude = ['help', 'help_class', 'help_id'];
        $attrs = set_extra_attrs($extra, $exclude);
        $current_file = isset($extra['current_file']) && strlen($extra['current_file']) ? current_file_preview($extra['current_file']) : '';
        $elem = '<div class="file_preview_area">
                    <input type="'.$type.'" name="'.$name.'" value="'.$value.'" '.$required.' '.$attrs.' />'
                    . xform_help($extra, true) . 
                    '<div class="file_preview card-deck">'.$current_file.'</div>
                </div>';
    } else {
        $elem = '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" '.$required.' '.$attrs.' />';
        $elem .= xform_help($extra, true);
    }
    if ($return) return $elem;
    echo $elem;
}

function xform_select($name, $value = '', $required = false, $extra = [], $return = false) { 
    $required = $required ? 'required' : '';
    //ajax dataset
    if (array_key_exists('ajax', $extra) && $extra['ajax']) {
        $options = '';
    } else {
        //is it a db record set? All db recordset must have a text_col key
        if (array_key_exists('text_col', $extra) && strlen($extra['text_col'])) {
            //value column
            $val_col = input_key_isset($extra, 'val_col', 'id');
            $text_col = input_key_isset($extra, 'text_col', 'text');
            $options = select_options_db($extra['options'], $val_col, $text_col, $value, true);
        } else {
            //just a regular array
            $assoc = $extra['assoc'] ?? false;
            $options = select_options($extra['options'], $value, $assoc, true);
        } 
    }
    //extra attrs
    $attrs_arr = input_key_isset($extra, 'extra', []);
    $attrs_arr['class'] = 'form-control '.input_key_isset($attrs_arr, 'class', '');
    //selectpicker
    $selectpicker = isset($extra['sp']) ? $extra['sp'] : true;
    $attrs_arr['class'] = $selectpicker ? $attrs_arr['class'].' selectpicker' : $attrs_arr['class'];
    $attrs = set_extra_attrs($attrs_arr);
    $selected = array_key_exists('selected', $extra) && strlen($extra['selected']) ? "data-selected='".$extra['selected']."'" : '';
    $elem = '<select name="'.$name.'" '.$required.' '.$selected.' '.$attrs.'>';
    //is blank allowed?
    if (array_key_exists('blank', $extra) && !$extra['blank']) {
        $blank = '';
    } else {
        $blank_text = input_key_isset($extra, 'blank_text', 'Select');
        $blank = '<option value="">'.$blank_text.'</option>';
    }
    $elem .= $blank;
    $elem .= $options;
    $elem .= '</select>';
    $elem .= xform_help($extra, true);
    if ($return) return $elem;
    echo $elem;
}

/**
 * Select options with hard-coded data
 * @param $options_arr: the data array
 * @param $selected_val: the currently selected value
 * @return html
 */
function select_options($options_arr, $selected_val = NULL, $assoc = false, $return = false) {
    //is options associative? if not, copy values to keys, unless otherwise stated
    if ( ! $assoc) {
        $options_arr = is_assoc_array($options_arr) ? $options_arr : array_combine($options_arr, $options_arr);
    }
    $options = "";
    if (!empty($options_arr)) {
        foreach ($options_arr as $key => $label) {
            $selected = $key == $selected_val ? 'selected' : NULL;
            $options .= '<option ' . $selected . ' value="' . $key . '">' . $label . '</option>';
        }
    }
    if ($return) return $options;
    echo $options;
}

/**
 * Select options with data populated from DB
 * @param $options_obj: the data object
 * @param $key: the key field to be saved
 * @param $label: the associated value field for rendering
 * @param $selected_val: the currently selected value
 * @return html
 */
function select_options_db($options_obj, $key, $label, $selected_val = NULL, $return = false) {
    $options = "";
    if (!empty($options_obj)) {
        foreach ($options_obj as $row) {
            $selected = $row->$key == $selected_val ? 'selected' : NULL;
            $options .= '<option ' . $selected . ' value="' . $row->$key . '">' . $row->$label . '</option>';
        }
    }
    if ($return) return $options;
    echo $options;
}

function input_group_text($text, $id = '') {
    $id = attr_isset($id, 'id="'.$id.'"', '');
    return '<div class="input-group-text" '.$id.' style="padding: 9px 12px;">'.$text.'</div>';
}

function input_group_btn($type, $target, $text, $icon = 'plus', $bg = 'primary', $title = '') {
    if ($type == 'url') {
        return link_button($text, $target, $icon, $bg, $title);
    }
    //modal
    return modal_button($text, $target, $icon, $bg, $title);
}

function modal_input_button($target, $url, $selectfield, $text = '', $icon = 'plus', $class = 'btn-primary ajax_select_btn', $title = '') {
    $icon = strlen($icon) ? 'fa fa-'.$icon : '';
    return '<button type="button" class="btn '.$class.'" data-toggle="modal" data-target="#'.$target.'" data-url="'.$url.'" data-selectfield="'.$selectfield.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$text.'</button>';
}

function _form_field($name, $type, $value, $required, $input_extra, $input_group = []) {
    //do we have an input group?
    if (is_array($input_group) && !empty($input_group)) { ?>
        <div class="input-group">
            <?php
            //prepend
            $prepend = input_key_isset($input_group, 'prepend', '');
            if (strlen($prepend)) { ?>
                <div class="input-group-prepend">
                    <?php 
                    if (isset($input_group['pp_butt']) && $input_group['pp_butt'] == true) { ?>
                        <?php echo $prepend; ?>
                        <?php 
                    } else { ?>
                        <span class="input-group-text <?php echo $input_group['pp_class'] ?? ''; ?>">
                            <?php echo $prepend; ?>
                        </span>
                        <?php 
                    } ?>
                </div>
                <?php 
            } 
            if ($type == 'select') { 
                xform_select($name, $value, $required, $input_extra);
            } else {
                xform_input($name, $type, $value, $required, $input_extra);
            } 
            //append
            $append = input_key_isset($input_group, 'append', '');
            if (strlen($append)) { ?>
                <div class="input-group-append">
                    <?php 
                    if (isset($input_group['pp_butt']) && $input_group['pp_butt'] == true) { ?>
                        <?php echo $append; ?>
                        <?php 
                    } else { ?>
                        <span class="input-group-text <?php echo $input_group['pp_class'] ?? ''; ?>">
                            <?php echo $append; ?>
                        </span>
                        <?php 
                    } ?>
                </div>
                <?php 
            } ?>
        </div>
        <?php 
    } else {
        if ($type == 'select') { 
            xform_select($name, $value, $required, $input_extra);
        } else {
            xform_input($name, $type, $value, $required, $input_extra);
        } 
    } 
}

function xform_group_list($label, $name, $type = 'text', $value = '', $required = false, $input_extra = [], $label_extras = [], $fg_extra = [], $input_group = []) {
    //prepend bs class
    $fg_extra['class'] = 'form-group '.input_key_isset($fg_extra, 'class', '');
    $for = input_key_isset($input_extra, 'id', '');
    //hide label if type is hidden, and don't wrap in form-group div to save real estate
    if ($type == 'hidden') {
        xform_input($name, $type, $value, $required, $input_extra);
    } else { ?>
        <div <?php echo set_extra_attrs($fg_extra); ?>>
            <?php
            //if required, append * to label name
            $label_extras = $required ? array_merge($label_extras, ['required' => true]) : $label_extras;
            xform_label($label, $for, $label_extras);
            _form_field($name, $type, $value, $required, $input_extra, $input_group); ?>
        </div>
        <?php
    } 
}

function xform_group_grid($label, $name, $type = 'text', $value = '', $required = false, $input_extra = [], $label_extras = [], $fg_extra = [], $input_group = [], $label_col_attrs = [], $input_col_attrs = []) {
    //prepend bs class
    $fg_extra['class'] = 'form-group '.input_key_isset($fg_extra, 'class', '');
    $label_col_attrs['class'] = grid_col(12, 6, 4, 4).' '.input_key_isset($label_col_attrs, 'class', '');
    $input_col_attrs['class'] = grid_col(12, 6, 8, 8).' '.input_key_isset($input_col_attrs, 'class', '');
    //label for
    $for = input_key_isset($input_extra, 'id', '');

    //hide label if type is hidden, and don't wrap in form-group div to save real estate
    if ($type == 'hidden') {
        xform_input($name, $type, $value, $required, $input_extra);
    } else { ?>
        <div class="row">
            <div <?php echo set_extra_attrs($label_col_attrs); ?>>
                <div <?php echo set_extra_attrs($fg_extra); ?>>
                    <?php
                    //if required, append * to label name
                    $label_extras = $required ? array_merge($label_extras, ['required' => true]) : $label_extras;
                    xform_label($label, $for, $label_extras); ?>
                </div>
            </div>
            <div <?php echo set_extra_attrs($input_col_attrs); ?>>
                <div <?php echo set_extra_attrs($fg_extra); ?>>
                    <?php
                    _form_field($name, $type, $value, $required, $input_extra, $input_group); ?>
                </div>
            </div>
        </div>
        <?php
    } 
}

function xform_group_html_datepicker_list($label, $name, $type = 'date', $value = '', $required = false, $with_time = false, $input_extra = [], $label_extras = [], $fg_extra = []) { 
    //prepend bs class
    $fg_extra['class'] = 'form-group '.input_key_isset($fg_extra, 'class', '');
    $for = input_key_isset($input_extra, 'id', '');
    $label_extras = $required ? array_merge($label_extras, ['required' => true]) : $label_extras; ?>
    <div <?php echo set_extra_attrs($fg_extra); ?>>
        <?php 
        xform_label($label, $for, $label_extras);
        $input_extra = array_merge(['class' => 'form-control'], $input_extra);
        if (strlen($value)) {
            $format = $with_time ? 'Y-m-d\TH:i' : 'Y-m-d';
            $date = new DateTime($value);
            $value = $date->format($format);
        }
        _form_field($name, $type, $value, $required, $input_extra); ?>
    </div>
    <?php
}

function xform_inner_btn($html = 'Save', $form_id = '', $bg = 'info', $extra = []) {
    $form_id = attr_isset($form_id, 'form="'.$form_id.'"', ''); 
    $html .= ajax_spinner(); 
    $type = $extra['type'] ?? 'submit';
    $extra['class'] = 'btn btn-'.$bg.' btn-sm '.input_key_isset($extra, 'class', '');
    ?>
    <button type="<?php echo $type; ?>" <?php echo $form_id; ?> <?php echo set_extra_attrs($extra); ?> >
        <span><?php echo $html; ?></span>
    </button>
    <?php
}

function xform_btn($html = 'Save', $form_id = '', $extra = [], $use_theme = true) {
    $form_id = attr_isset($form_id, 'form="'.$form_id.'"', ''); 
    $html .= ajax_spinner(); 
    $type = $extra['type'] ?? 'submit';
    $extra['class'] = ($use_theme ? 'btn btn-theme' : '').' '.input_key_isset($extra, 'class', '');
    ?>
    <button type="<?php echo $type; ?>" <?php echo $form_id; ?> <?php echo set_extra_attrs($extra); ?> >
        <span><?php echo $html; ?></span>
    </button>
    <?php
}

function xform_submit($html = 'Save', $form_id = '', $extra = [], $fg_extra = ['class' => 'form-group'], $use_theme = true) { ?>
    <div <?php echo set_extra_attrs($fg_extra); ?>>
        <?php xform_btn('<span>'.$html.'</span>', $form_id, $extra, $use_theme); ?>
    </div>
    <?php
}

function xform_save_submit($text_save = 'Save & Add Another', $text_submit = 'Save & View', $form_id = '', $extra = [], $fg_extra = ['class' => 'form-group']) {
    $form_id = attr_isset($form_id, 'form="'.$form_id.'"', ''); ?>
    <div <?php echo set_extra_attrs($fg_extra); ?>>
        <?php
        $extra = array_merge(['class' => 'btn btn-theme submit_type'], $extra);
        $extra_save = array_merge($extra, ['value' => 'save']);
        $extra_submit = array_merge($extra, ['value' => 'submit']);
        //hidden input against which the selected option will rendered for transport to server
        xform_input('submit_type', 'hidden');
        xform_btn('<span>'.$text_save.'</span>', $form_id, $extra_save);
        xform_btn('<span>'.$text_submit.'</span>', $form_id, $extra_submit);
        ?>
    </div>
    <?php
}

function xform($action, $fields, $attrs = [], $butt_text = 'Save', $butt_form = '', $butt_attrs = [], $notice_attrs = []) {
    echo form_open($action, $attrs);
        //form fields
        foreach ($fields as $field) {
            $layout = input_key_isset($field, 'layout', 'grid');
            $label = input_key_isset($field, 'label', '');
            $name = input_key_isset($field, 'name', '');
            $type = input_key_isset($field, 'type', '');
            $value = input_key_isset($field, 'value', '');
            $required = input_key_isset($field, 'required', '');
            $extra = input_key_isset($field, 'extra', []);
            $label_extras = input_key_isset($field, 'label_extra', []);
            $fg_extra = input_key_isset($field, 'fg_extra', []);
            $input_group = input_key_isset($field, 'input_group', []);
            //layout type
            if ($layout == 'list') { //list
                xform_group_list($label, $name, $type, $value, $required, $extra, $label_extras, $fg_extra, $input_group);
            } else { //grid
                $label_col_attrs = input_key_isset($field, 'label_col_attrs', ['class' => grid_col(12, 6, 4, 3)]);
                $input_col_attrs = input_key_isset($field, 'input_col_attrs', ['class' => grid_col(12, 6, 8, 9)]);
                xform_group_grid($label, $name, $type, $value, $required, $extra, $label_extras, $fg_extra, $input_group, $label_col_attrs, $input_col_attrs);
            }
        }
        //form notice
        $notice_class = input_key_isset($notice_attrs, 'class', 'status_msg');
        $notice_id = input_key_isset($notice_attrs, 'id', '');
        xform_notice($notice_class, $notice_id);
        //form button
        $butt_class = input_key_isset($butt_attrs, 'class', 'btn btn-theme');
        xform_submit($butt_text, $butt_form, $butt_attrs);
    echo form_close();
}

function adit_value($row, $field, $default = '', $strip_tags = false, $allow_tags = '') {
    if ( !empty($row)) {
        return $strip_tags ? strip_tags($row->$field, $allow_tags) : $row->$field;
    }
    return $default;
}

function ajax_form_modal(array $data, array $fields, $butt_attrs = ['class' => 'btn btn-theme pull-left']) {
    $form_class = input_key_isset($data, 'class', 'ajax_form');
    $reload = input_key_isset($data, 'reload', 1);
    $m_class = input_key_isset($data, 'm_class', 'fill-in');
    $m_size = input_key_isset($data, 'm_size', '');
    $notice = input_key_isset($data, 'notice', 'm_status_msg');
    $attrs = ['id' => $data['form'], 'class' => $form_class, 'data-type' => $data['type'], 'data-modal' => $data['modal'], 'data-msg' => $data['item'].' '.$data['crud_type'].'ed successfully', 'data-reload' => $reload, 'data-notice' => $notice];
    modal_header($data['modal'], $data['title'], $m_class, $m_size);
        xform($data['url'], $fields, $attrs, ucfirst($data['crud_type']), '', $butt_attrs, ['class' => $notice]);
    modal_footer(false);
}

function csrf_hidden_input($return = false) {
    $ci =& get_instance();
    $elem = xform_input('csrf_hash', 'hidden', $ci->security->get_csrf_hash(), false, ['id' => 'csrf_hash']);
    if ($return) return $elem;
    echo $elem;
} 

function xform_sortable($title, $order, $id, $idfld = 'idx', $class = '') { ?>
    <div class="card sortable_data <?php echo $class; ?>">
        <div class="card-header bg-info">
            <?php echo $order.'. '.$title;
            xform_input($idfld.'[]', 'hidden', $id); ?>
        </div>
    </div>
    <?php
}

function xform_check_all($class = 'ba_check_all') {
    echo '<input type="checkbox" class="radio-box '.$class.'"/>';
}

function xform_captcha($captcha, $theme = [255, 255, 255], $layout = 'grid') {
    $label = '<span id="captcha_image">'.$captcha.'</span>
        <span>
            <a href="javascript:void(0);" id="refresh_captcha_image" title="Refresh" style="color: #666;"><i class="fa fa-refresh"></i></a>
        </span>';
    $captcha_input = 'xform_group_'.$layout;
	$captcha_input($label, 'captcha_code', 'text', '', true, ['maxlength' => 6, 'placeholder' => 'Enter captcha here']);
	xform_input('', 'hidden', json_encode($theme), false, ['class' => 'captcha_theme']);		
}