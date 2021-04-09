<!-- page content -->
<div class="main-content small-gutter" role="main">

    <?php 
    //has user reset default password?
    if ($this->session->user_password_set != 1 && $this->session->ajax_requested_page != base_url('user/reset_pass')) {
        $reset_url = ajax_page_link('user/reset_pass', 'Reset it now', 'alert-link', '', '', '', 1, '', '', true);
        show_alert('You have not reset your default password. '.$reset_url, 'danger', 'text-center');
    } ?>
        
    <div class="row bg-title clearfix">
        <div class="<?php echo grid_col(12, '', 9); ?>">
            <h4 class="page-title" id="ajax_page_title" data-site_title="<?php echo SITE_NAME; ?>">
                <?php echo $page_title;
                if ((bool) $this->trashed) {
                    echo '<span class="text-danger"> [Trashed]</span>'; 
                } ?>
            </h4>
        </div>
        <?php
        //record count [with max data]
        if (strlen($record_count)) {
            $_affix = intval($record_count) === 1 ? '' : 's'; ?>
            <div class="<?php echo grid_col(12, '', 3); ?>">
                <h4 class="page-title float-md-right">
                    <?php
                    echo number_format(intval($record_count)) . ' record' . $_affix . (strlen($max_data) && $max_data != -1 ? ' <small class="text-danger">(max: '.number_format(intval($max_data)).')</small>' : ''); ?>
                </h4>
            </div>
            <?php
        } ?>
    </div>
    
    <?php 
    //crud buttons not empty?
    if (is_array($this->butts) && !empty($this->butts)) { ?>
        <div class="row page_buttons">
            <div class="<?php echo grid_col(12); ?>">
                <div class="pull-left">
                    <?php echo page_crud_butts($this->module, null, $this->butts, $crud_rec_id, $record_count); ?>
                </div>
            </div>
        </div>
        <?php 
    } ?>
    
    <div class="row m-t-15">
        <div class="<?php echo grid_col(12); ?> m-b-10">
            <div class="bg-white padding-25 h-100">
                <div class="m-t-10">

                    <?php
                    //flash messages
                    flash_message('info_msg', 'info');
                    flash_message('success_msg', 'success');
                    flash_message('error_msg', 'danger'); 
                    ?>

                </div>

                <?php
                //inner page buttons
                if (is_array($this->inner_butts) && !empty($this->inner_butts)) {
                    foreach ($this->inner_butts as $_butt) {
                        $ib_text = $_butt['text'] ?? '';
                        $ib_type = $_butt['type'] ?? 'url';
                        $ib_ajax_page = isset($_butt['ajax_page']) ? $_butt['ajax_page'] : true;
                        $ib_class = $_butt['class'] ?? 'btn-info';
                        $ib_title = $_butt['title'] ?? '';
                        $ib_icon = $_butt['icon'] ?? 'indent';
                        $ib_icon = $_butt['icon'] ?? 'indent';
                        $ib_extra = $_butt['extra'] ?? [];
                        if ($ib_type == 'action') { 
                            $ib_form = $_butt['form'] ?? '';
                            $ib_bg = $_butt['bg'] ?? 'info';
                            $ib_html = '<i class="fa fa-'.$ib_icon.'"></i> '.$ib_text;
                            $ib_extra = isset($_butt['id']) ? array_merge($ib_extra, ['id' => $_butt['id']]) : $ib_extra;
                            $ib_extra = isset($_butt['class']) ? array_merge($ib_extra, ['class' => $_butt['class']]) : $ib_extra;
                            xform_inner_btn($ib_html, $ib_form, $ib_bg, $ib_extra);
                        } else {
                            $ib_target = $_butt['target'] ?? '';
                            if ($ib_ajax_page) {
                                $ib_attrs = set_extra_attrs($ib_extra);
                                ajax_page_button($ib_target, $ib_text, $ib_class, $ib_title, $ib_icon, $ib_attrs);
                            } else {
                                echo link_button($ib_text, $ib_target, $ib_icon, $ib_class, $ib_title, '', false, $ib_extra);
                            }
                        }
                    }
                    xform_notice('ib_msg_box');
                } ?>

                <?php 
                //inject file
                if (!empty($this->tv_file)) {
                    if (is_array($this->tv_file)) {
                        foreach ($this->tv_file as $file) {
                            if (file_exists('application/views/'.$file.'.php')) 
                                $this->load->view($file, $file_data);
                        }
                    } else {
                        if (file_exists('application/views/'.$this->tv_file.'.php')) 
                            $this->load->view($this->tv_file, $file_data);
                    }
                }
                //bulk action options
                if (is_array($this->ba_opts) && !empty($this->ba_opts)) 
                    bulk_action($this->ba_opts, $record_count);