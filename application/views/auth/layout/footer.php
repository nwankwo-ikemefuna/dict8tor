			</div><!--/.login-register-->
        </div><!--/.align-items-center-->
    </div><!--/.login-container-->
</div><!--/.form-container-->

<?php csrf_input(); ?>

<!-- Vendors -->
<!-- Regular guys -->
<script src="<?php echo base_url(); ?>assets/vendors/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/bootstrap.min.js"></script>

<!-- General Custom scripts -->
<script src="<?php echo base_url(); ?>assets/common/js/general.js"></script>
<script src="<?php echo base_url(); ?>assets/common/js/ajax.js"></script>

<?php
//custom page-specific scripts
load_scripts($this->page_scripts, 'assets/portal/custom/js'); 
?>

<script>
    //pass vars to javascript
    var base_url = "<?php echo base_url(); ?>",
    	c_controller = "<?php echo $this->c_controller; ?>",
    	csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>",
    	is_portal = false;
</script>

</body>
</html>