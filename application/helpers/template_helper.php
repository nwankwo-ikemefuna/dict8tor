<?php 
function data_show_list($label, $data, $label_class = '', $content_class = '') { ?>
    <div class="row m-b-5">
        <div class="<?php echo grid_col(12); ?>">
            <div class="view_label <?php echo $label_class; ?>"><?php echo $label; ?>:</div>
            <div class="view_data <?php echo $content_class; ?>"><?php echo $data; ?></div>
        </div>
    </div>
    <?php
}

function data_show_grid($label, $data, $label_class = '', $content_class = '') { ?>
    <div class="row m-b-5">
        <div class="<?php echo grid_col(12, 4); ?>">
            <div class="view_label <?php echo $label_class; ?>"><?php echo $label; ?>:</div>
        </div>
        <div class="<?php echo grid_col(12, 8); ?>">
            <div class="view_data <?php echo $content_class; ?>"><?php echo $data; ?></div>
        </div>
    </div>
    <?php
}

function table_row_double_data($title, $data) { ?>
    <tr>
        <td><?php echo $title; ?></td>
        <td><?php echo $data; ?></td>
    </tr>
    <?php
} 

function view_section_title($title = '', $icon = '', $hr_top = true) { 
    if ($hr_top) echo "<hr />"; ?>
    <h4 class="view_section_title"><i class="<?php echo strlen($icon) ? 'fa fa-'.$icon : ''; ?>"></i> <?php echo $title; ?></h4>
    <?php
}

function bulk_action($options_arr, $record_count = 0, $default_modal = 'm_confirm_ba') {
    /*sample usage 
    
    */
    if (empty($options_arr) || $record_count == 0) return;
    $ci =& get_instance();
    ?>
    <div class="row m-b-10">
        <div class="<?php echo grid_col(12, 8, '', 4); ?>">
            <h5>Bulk Action (<em>with selected</em>) <span id="ba_selected_msg" class="text-danger"></span></h5>
            <div class="input-group">
                <select name="ba_option" class="form-control" style="height: 35px;">
                    <option value="">Select</option>
                    <?php
                    //append trash, restore and delete options
                    if (in_array('delete', $options_arr)) {
                        if ($ci->trashed == 0) {
                            $options_arr = array_merge($options_arr, ['Trash']);
                        } else {
                            $options_arr = array_merge($options_arr, ['Restore', 'Delete']);
                        }
                    }
                    $options = "";
                    foreach ($options_arr as $_key => $vals) {
                        if ($vals == 'delete') continue;
                        $label = is_array($vals) ? $_key : $vals;
                        //is array?
                        if (is_array($vals)) {
                            $key = $_key;
                            $label = $vals['label'] ?? $key;
                            $modal = $vals['modal'] ?? $default_modal;
                            $id_field = $vals['id_field'] ?? 'id';
                        } else {
                            $key = $label = $vals;
                            $modal = $default_modal;
                            $id_field = 'id';
                        }
                        $options .= '<option value="' . $key . '" data-modal="'.$modal.'" data-id_field="'.$id_field.'">' . $label . '</option>';
                    }
                    echo $options;
                    ?>
                </select>
                <div class="input-group-append">
                    <?php
                    echo tm_confirm('Apply', $ci->module, $ci->model, $ci->table, 'ba_apply btn-lg', '', 'primary', 'Execute bulk action'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function ajax_table($id, $url, $headers, $columns = [], $extras = [], $col_defs = []) { 
    $custom = empty($columns); //custom or general?
    $responsive = $extras['responsive'] ?? true; 
    $head_class = $extras['head_class'] ?? 'thead-default';
    $actions_class = $extras['actions_class'] ?? 'min-w-100';
    $extras_arr = [
        'custom' => $extras['custom'] ?? true,
        'checker' => $extras['checker'] ?? true,
        'actions' => $extras['actions'] ?? true,
        'created' => $extras['created'] ?? true,
        'updated' => $extras['updated'] ?? true
    ]; ?>
    <div class="row">
        <div class="<?php echo grid_col(12); ?> m-b-10">
            <div class="<?php echo $responsive ? 'table-responsive' : ''; ?>">
                <?php echo csrf_hidden_input();
                //data columns and configs
                $cols = [];
                if (!empty($columns)) {
                    foreach ($columns as $value) {
                        if (is_array($value)) {
                            $cols[] = $value;
                        } else {
                            $cols[] = ['data' => $value];
                        }
                    } 
                } ?>
                <table 
                    class="table ajax_dt_table mb-0" 
                    id="<?php echo $id; ?>" 
                    data-url="<?php echo $url; ?>" 
                    <?php if ( ! $custom) { ?> data-cols='<?php echo json_encode($cols); ?>' <?php } ?> 
                    <?php if (!empty($col_defs)) { ?> data-col_defs='<?php echo json_encode($col_defs); ?>' <?php } ?>
                    data-extras='<?php echo json_encode($extras_arr); ?>' 
                    data-custom='<?php echo json_encode($custom); ?>'>
                    <thead class="<?php echo $head_class; ?>">
                        <tr>
                            <?php if ($extras_arr['checker']) { ?>
                                <th style="width: 10px"><?php echo xform_input('', 'checkbox', '', false, ['class' => 'ba_check_all']); ?></th>
                                <?php 
                            } ?>
                            <?php if ($extras_arr['actions']) { ?>
                                <th class="<?php echo $actions_class; ?>">Actions</th>
                                <?php 
                            } ?>
                            <?php 
                            foreach ($headers as $key => $value) {
                                $name = is_array($value) ? $key : $value;
                                $class = $value['class'] ?? '';
                                echo '<th class="'.$class.'">'.$name.'</th>';
                            } ?>
                            <?php if ($extras_arr['created']) { ?>
                                <th class="min-w-200">Created On</th>
                                <?php 
                            } ?>
                            <?php if ($extras_arr['updated']) { ?>
                                <th class="min-w-200">Updated On</th>
                                <?php 
                            } ?>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <?php
}

function dt_dumb_column($data, $searchable = false, $orderable = false) {
    return ['data' => $data, 'searchable' => $searchable, 'orderable' => $orderable];
}

function dt_hidden_column($data) {
    return ['data' => $data, 'visible' => false];
}

function side_menu($name, $url, $icon = '', $title = '', $target = '', $is_ajax = true) {
    if ($is_ajax) {
        $html = strlen($icon) ? '<i class="fa fa-'.$icon.'" aria-hidden="true"></i>' : '';
        $html .= '<span>'.$name.'</span>';
        ?>
        <li class="nav-item">
            <?php ajax_page_link($url, $html); ?>
        </li>
        <?php
    } else { ?>
        <li class="nav-item">
            <a href="<?php echo base_url($url); ?>" title="<?php echo strlen($title) ? $title : $name; ?>" target="<?php echo $target; ?>">
                <?php 
                if (strlen($icon)) { ?>
                    <i class="fa fa-<?php echo $icon; ?>" aria-hidden="true"></i>
                    <?php 
                } ?>
                <span><?php echo $name; ?></span>
            </a>
        </li>
        <?php
    }
}

function side_menu_tm($name, $url, $trigger = '', $icon = '', $title = '', $is_ajax = true) {
    $title = strlen($title) ? $title : $name; 
    ?>
    <li class="nav-item">
        <a class="<?php echo $trigger; ?> clickable" data-page="<?php echo $is_ajax ? $url : base_url($url); ?>" data-is_ajax="<?php echo (int) $is_ajax; ?>" title="<?php echo $title; ?>">
            <?php 
            if (strlen($icon)) { ?>
                <i class="fa fa-<?php echo $icon; ?>" aria-hidden="true"></i>
                <?php 
            } ?>
            <span><?php echo $name; ?></span>
        </a>
    </li>
    <?php
}

function side_menu_auth($module, $right, $usergroups = null, $name, $url, $icon = '', $title = '', $target = '', $is_ajax = true) {
    $ci =& get_instance();
    if ($ci->auth->vet_access($module, $right, $usergroups)) { 
        side_menu($name, $url, $icon, $title, $target, $is_ajax);
    }
}

function side_menu_tm_auth($module, $right, $usergroups = null, $name, $url, $trigger = '', $icon = '', $title = '', $is_ajax = true) {
    $ci =& get_instance();
    if ($ci->auth->vet_access($module, $right, $usergroups)) { 
        side_menu_tm($name, $url, $trigger, $icon, $title, $is_ajax);
    }
}

function side_menu_parent_open($name, $icon = '', $title = '') { 
    $icon = strlen($icon) ? 'fa fa-'.$icon : ''; ?>
    <li class="nav-item has-child">
        <a href="javascript:void(0);" class="ripple" title="<?php echo strlen($title) ? $title : $name; ?>">
            <i class="<?php echo $icon; ?>" aria-hidden="true"></i>
            <span><?php echo $name; ?></span>
            <span class="fa fa-chevron-right" aria-hidden="true"></span>
        </a>
        <ul class="nav child-menu">
        <?php
}

function side_menu_parent_close() { ?>
    </ul></li>
    <?php
}

function side_menu_parent_open_auth($module, $right, $usergroups = null, $name, $icon = 'cube', $title = '') {
    $ci =& get_instance();
    if ($ci->auth->vet_access($module, $right, $usergroups)) { 
        side_menu_parent_open($name, $icon, $title);
    }
}

function side_menu_parent_close_auth($module, $right, $usergroups = null) { 
    $ci =& get_instance();
    if ($ci->auth->vet_access($module, $right, $usergroups)) { ?>
        </ul></li>
        <?php
    }
}

function toggle_password_visibility() {
    ?>
    <span id="show_password_icon"><a id="show_password" title="Show password" style="cursor: pointer"><i class="fa fa-eye"></i></a></span>
    <span id="hide_password_icon" style="display: none"><a id="hide_password" title="Hide password" style="cursor: pointer"><i class="fa fa-eye-slash"></i></a></span>
   <?php
}