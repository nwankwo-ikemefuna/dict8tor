<div class="text-center">
	<?php flash_message('error_msg', 'danger'); ?>
    <h2 class="text-bold text-danger">403 - Forbidden!</h2>
    <p class="p-b-10"></p>
    <div>
    	<?php 
		//coming from portal?
		if ($is_ajax) {
	        ajax_page_button('user', 'Save Me!', 'btn-info btn-rounded btn-lg');
	    } else { ?>
	    	<a href="<?php echo base_url('portal'); ?>" class="btn btn-info btn-rounded btn-lg">Take Me Home</a>
	    <?php } ?>
    </div>
</div>