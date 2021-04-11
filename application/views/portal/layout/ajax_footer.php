            </div><!-- /.bg-white padding-25 h-100 -->
        </div><!-- /.col-12 -->
    </div><!-- /.row -->
</div><!-- /.main-content -->
<!-- /page content -->

<?php q_string_input(); ?>

<?php
//custom page-specific scripts
load_scripts(['ajax_page'], 'assets/portal/custom/js');
load_scripts($this->page_scripts, 'assets/portal/custom/js'); 
?>

<script>
    //pass vars to javascript
    var c_controller = "<?php echo $this->c_controller; ?>";
    var current_page = "<?php echo $current_page; ?>";
</script>