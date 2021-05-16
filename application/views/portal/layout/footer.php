        </div><!-- /#ajax_page_container -->
        <footer class="footer">
            <a href="<?php echo base_url(); ?>" class="company-name text-theme" target="_blank"><?php echo SITE_NAME; ?></a> &copy; <?php echo date('Y'); ?>.
            <div class="float-right">
                Powered by<a href="<?php echo SITE_AUTHOR_URL; ?>" class="company-name text-theme" target="_blank"><?php echo SITE_AUTHOR; ?></a>
            </div>
            <div class="clearfix"></div>
        </footer>

    </div>
</div>

<?php csrf_input(); ?>

<?php
//General modals

//modal confirm action
modal_header('m_confirm_action'); ?>
    <div class="msg"></div>
    <div class="confirm_status m-t-10"></div>
<?php modal_footer(true, true); 

//confirm bulk action
modal_header('m_confirm_ba'); ?>
    <div class="ba_msg"></div>
    <div class="confirm_status m-t-10"></div>
<?php modal_footer(true, true, 'ba_confirm_btn'); 

//modal row options
modal_header('m_row_options', 'More Options', '', 'modal-form');
modal_footer(false); 

//Image View
//modal row options
modal_header('m_img_view', 'Image View', 'fill-in', 'modal-lg');
modal_footer(false); 

//the guy that handles loading of stuff 
ajax_overlay_loader(); ?>

<!-- Vendors -->
<!-- Regular guys -->
<script src="<?php echo base_url(); ?>assets/vendors/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/bootstrap.min.js"></script>
<!-- Selectpicker -->
<script src="<?php echo base_url(); ?>assets/vendors/selectpicker/js/bootstrap-select.min.js"></script>
<!-- Moment -->
<script src="<?php echo base_url(); ?>assets/vendors/moment/moment.js"></script>
<!-- Tempus Dominus Datetimepicker -->
<script src="<?php echo base_url(); ?>assets/vendors/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Datatables BS 4 -->
<script src="<?php echo base_url(); ?>assets/vendors/datatables_bs4/datatables.min.js"></script>
<!-- Summernote-->
<script src="<?php echo base_url(); ?>assets/vendors/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<!-- PSG Countdown Timer-->
<script src="<?php echo base_url(); ?>assets/vendors/psg-countdown/js/jquery.psgTimer.js" type="text/javascript"></script>
<!-- Template scripts -->
<script src="<?php echo base_url(); ?>assets/portal/template/js/main.js"></script>

<!-- Portal Common scripts -->
<script src="<?php echo base_url(); ?>assets/portal/custom/js/common.js"></script>
<script src="<?php echo base_url(); ?>assets/portal/custom/js/modals.js"></script>

<!-- General Custom scripts -->
<script src="<?php echo base_url(); ?>assets/common/js/summernote_config.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/general.js"></script>
<!-- Utils -->
<script src="<?php echo base_url(); ?>assets/common/js/data_table.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/num2words.js"></script>

<?php
//custom page-specific scripts
load_scripts($this->page_scripts, 'assets/portal/custom/js'); 
?>

<?php 
$requested_resource = get_requested_resource_ajax();
?>
<script type="text/javascript">
    //pass vars to javascript
    var base_url = "<?php echo base_url(); ?>",
        c_controller = "<?php echo $this->c_controller; ?>",
        current_page = "<?php echo $current_page; ?>",
        is_loggedin = <?php echo json_encode((Bool)$this->session->user_loggedin); ?>,
        is_portal = true,
        csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>",
        ajax_requested_page = "<?php echo $requested_resource; ?>",
        date_today = "<?php echo date('d-m-Y'); ?>",
        current_datetime = "<?php echo date('Y-m-d H:i:s'); ?>",
        _departments = '<?php echo json_encode($this->session->_departments); ?>',
        _dept_classes = '<?php echo json_encode($this->session->_dept_classes); ?>',
        _countries = '<?php echo json_encode($this->session->_countries); ?>',
        _country_states = '<?php echo json_encode($this->session->_country_states); ?>';
</script>

</body>
</html>