    <footer class="m-t-50">
        <hr />
        <p class="text-center m-t-20">Crafted by <a href="<?php echo SITE_AUTHOR_URL; ?>" target="_blank"><?php echo SITE_AUTHOR; ?></a></p>
    </footer>

</div><!-- /.site-wrapper-->


<?php csrf_input(); ?>

<?php
//General modals

//the guy that handles loading of stuff 
ajax_overlay_loader(); ?>

<!-- Regular guys -->
<script src="<?php echo base_url(); ?>assets/vendors/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/summernote/summernote-bs4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/toast/toast.min.js" type="text/javascript"></script>

<!-- General Custom scripts -->
<script src="<?php echo base_url(); ?>assets/common/js/speech2text.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/summernote_config.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/general.js"></script>
<!-- Utils -->
<script src="<?php echo base_url(); ?>assets/common/js/ajax.js"></script>

<?php
//custom page-specific scripts
load_scripts($this->page_scripts, 'assets/web/custom/js'); 
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
        is_portal = false,
        csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>",
        ajax_requested_page = "<?php echo $requested_resource; ?>",
        date_today = "<?php echo date('d-m-Y'); ?>",
        current_datetime = "<?php echo date('Y-m-d H:i:s'); ?>";
</script>

</body>
</html>